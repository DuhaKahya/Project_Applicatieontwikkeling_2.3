<?php

namespace App\Controllers;

use App\Services\EntityService;
use App\Helpers\FlashHelper;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use App\Helpers\RegexHelper;

class ManageController extends Controller
{
    const LOCATION_MANAGE_TYPE = 'manage?type=';
    const WORD_LIMIT = 20;
    private EntityService $entityService;
    private FlashHelper $flashHelper;
    private RegexHelper $regexHelper;

    public function __construct()
    {
        $this->entityService = new EntityService();
        $this->flashHelper = new FlashHelper();
        $this->regexHelper = new RegexHelper();
    }


    public function index(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role_name'] === 'Customer') {
            header('Location: /');
            exit();
        }


        $entityType = $_GET['type'] ?? 'user';

        $entities = $this->entityService->getAllEntities($entityType);
        $entityProperties = $this->entityService->getEntityProperties($entityType);

        foreach ($entities as $key => $entity) {
            foreach ($entity as $field => $value) {
                if (is_string($value)) {
                    $entities[$key][$field] = $this->limitWords($value);
                }
            }
        }

        require_once __DIR__ . '/../views/dashboard/manage.php';
    }

    private function limitWords(string $string): string
    {
        $words = explode(" ", $string);
        $truncated = implode(" ", array_slice($words, 0, self::WORD_LIMIT));

        if (count($words) > self::WORD_LIMIT) {
            $truncated .= '...';
        }

        return $truncated;
    }

    #[NoReturn] public function processCreate(): void
    {
        $type = $_POST['type'] ?? null;
        $proceed = true;

        if (!$type) {
            $this->handleTypeMissingError($type);
        }

        $formData =  $this->filterAndSanitizeFormData($type, $_POST);

        if ($this->entityExists($type, $formData)) {
            $this->handleEntityExistsError($type);
        }

        if ($this->checkForMissingFields($formData, $type) || $this->handleFileUploads($type, $formData)) {
            $proceed = false;
        }

        if ($proceed) {
            $this->processEntityCreation($type, $formData);
        }
    }

    #[NoReturn] private function handleTypeMissingError(string $type): void
    {
        $this->flashHelper->setFlashMessage('error', 'Type is required for creating an entity.');
        $this->redirectTo("{$type}/create");
    }

    #[NoReturn] private function redirectTo($path): void
    {
        header('Location: /' . $path);
        exit;
    }

    private function filterAndSanitizeFormData(string $type, array $formData): array
    {
        $formData = $this->filterEditableFields($type, $formData);
        unset($formData['type']);

        if ($type === 'artist' && isset($formData['name'])) {
            $formData['slug'] = $this->generateSlugFromName($formData['name']);
        }

        return $this->sanitizeFormData($type, $formData);
    }

    private function filterEditableFields($type, $formData): array
    {
        $entityProperties = $this->entityService->getEntityProperties($type);
        $editableFields = $entityProperties['fields'];

        return array_intersect_key($formData, array_flip($editableFields));
    }

    private function generateSlugFromName($name): string
    {
        $slug = strtolower($name);
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
        return trim($slug, '-');
    }

    private function sanitizeFormData(string $type, array $formData): array
    {
        $entityProperties = $this->entityService->getEntityProperties($type);
        $identifierColumn = $entityProperties['identifier'] ?? '';

        $sanitizedData = [];
        foreach ($formData as $key => $value) {
            // Skip validation for the identifier column
            if ($key === $identifierColumn) {
                $sanitizedData[$key] = $value;
                continue;
            }

            $sanitizedData[$key] = is_numeric($value) ? $this->sanitizeInt($value) : $this->sanitizeHtml($value);
        }

        return $sanitizedData;
    }

    private function entityExists(string $type, array $formData): bool
    {
        return isset($formData['name']) && $this->entityService->entityExists($type, 'name', $formData['name']);
    }

    #[NoReturn] private function handleEntityExistsError(string $type): void
    {
        $this->flashHelper->setFlashMessage('error', 'An entity with this name already exists.');
        $this->redirectTo("{$type}/create");
    }

    private function checkForMissingFields(array $formData, $type): bool
    {
        $missingFields = [];
        $entityProperties = $this->entityService->getEntityProperties($type);
        $identifierColumn = $entityProperties['identifier'] ?? '';
        $excludedFields = array_merge([$identifierColumn, 'slug'], preg_grep('/Id$/', $entityProperties['fields']));

        $requiredFields = array_diff($entityProperties['fields'], $excludedFields);

        foreach ($requiredFields as $field) {
            if (str_contains(strtolower($field), 'image') || str_contains(strtolower($field), 'music')) {
                if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
                    $missingFields[] = $field;
                }
            } else {
                if (empty($formData[$field])) {
                    $missingFields[] = $field;
                }
            }
        }

        if (!empty($missingFields)) {
            $missingFieldNames = implode(', ', $missingFields);
            $this->flashHelper->setFlashMessage('error', "Missing required fields: {$missingFieldNames}.");
            $this->redirectTo("{$type}/create");
        }

        return false;
    }

    private function handleFileUploads(string $type, array &$formData): bool
    {
        foreach ($_FILES as $key => $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                try {
                    $filePath = $this->processUploadedFile($file, $type, $key);
                    $formData[$key] = $filePath;
                } catch (Exception $e) {
                    $this->flashHelper->setFlashMessage('error', $e->getMessage());
                    $this->redirectTo("{$type}/create");
                }
            }
        }
        return false;
    }

    private function processUploadedFile($file, $entityType, $field): string
    {
        try {
            $isMusic = str_contains(strtolower($field), 'music');
            $this->validateFile($file, $isMusic, $entityType);
            $destination = $this->generateFilePath($file, $entityType, $isMusic);
            return $this->moveUploadedFile($file, $destination, $entityType);
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', $e->getMessage());
            $this->redirectTo("{$entityType}/create");
        }
    }

    private function validateFile($file, $isMusic, $entityType): void
    {
        $allowedTypes = $isMusic ? ['audio/mpeg', 'audio/mp3'] : ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = $isMusic ? 10000000 : 5000000;

        if (!in_array($file['type'], $allowedTypes)) {
            $this->flashHelper->setFlashMessage('error', 'Unsupported file type.');
            $this->redirectTo("{$entityType}/create");
        }

        if ($file['size'] > $maxSize) {
            $this->flashHelper->setFlashMessage('error', 'File is too large.');
            $this->redirectTo("{$entityType}/create");
        }
    }

    private function generateFilePath($file, $entityType, $isMusic): string
    {
        $directory = __DIR__ . "/../public/" . ($isMusic ? "music" : "images") . "/{$entityType}/";
        $this->ensureDirectoryExists($directory, $entityType);

        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

        try {
            $randomFileName = bin2hex(random_bytes(16)) . '.' . $fileExtension;
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'Failed to generate random file name.');
            $this->redirectTo("{$entityType}/create");
        }

        return $directory . $randomFileName;
    }

    private function ensureDirectoryExists($directory, $entityType): void
    {
        if (!is_dir($directory) && !mkdir($directory, 0755, true)) {
            $this->flashHelper->setFlashMessage('error', 'Failed to create directory.');
            $this->redirectTo("{$entityType}/create");
        }
    }

    private function moveUploadedFile($file, $destination, $entityType): string
    {

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            $this->flashHelper->setFlashMessage('error', 'Failed to move uploaded file.');
            $this->redirectTo("{$entityType}/create");
        }
        $relativePath = str_replace(__DIR__ . "/../public", '', $destination);
        return '/' . ltrim($relativePath, '/');
    }

    #[NoReturn] private function processEntityCreation(string $type, array $formData): void
    {
        $success = $this->entityService->createEntity($type, $formData);
        if ($success) {
            $this->flashHelper->setFlashMessage('success', 'Entity created successfully.');
            $this->redirectTo(self::LOCATION_MANAGE_TYPE . urlencode($type));
        } else {
            $this->flashHelper->setFlashMessage('error', 'An error occurred during creation.');
            $this->redirectTo("{$type}/create");
        }
    }

    public function createEntity($type): void
    {

        $this->editEntity($type);
    }

    public function editEntity($type, $id = null): void
    {
        $isEditing = isset($id);
        $entityProperties = $this->entityService->getEntityProperties($type);

        $entityData = [];
        if ($isEditing) {
            $entityData = $this->entityService->getEntityById($type, $id);
        }

        $foreignKeyOptions = [];
        foreach ($entityProperties['fields'] as $field) {
            if (str_contains($field, 'Id') && $field !== $entityProperties['identifier']) {
                $foreignKeyOptions[$field] = $this->entityService->getForeignKeyOptions($field);
            }
        }

        $actionUrl = $isEditing ? "/manage/processEdit?type=" . $type . "&id=" . $id : "/manage/processCreate?type=" . $type;

        require_once __DIR__ . '/../views/dashboard/edit_or_create.php';
    }

    public function processEdit(): void
    {
        $type = $_POST['type'] ?? null;
        $id = $_POST['id'] ?? null;

        if (!$type || !$id) {
            $this->flashHelper->setFlashMessage('error', 'Type and ID are required for editing an entity.');
            return;
        }

        $formData = $this->filterEditableFields($type, $_POST);

        $this->filterAndSanitizeFormData($type, $_POST);
        
        $entityProperties = $this->entityService->getEntityProperties($type);
        $identifierColumn = $entityProperties['identifier'] ?? '';
        foreach ($formData as $key => &$value) {
            if ($key !== $identifierColumn) {
                $value = is_numeric($value) ? $this->sanitizeInt($value) : $this->sanitizeHtml($value);
            }

            if ($value === '' || is_null($value)) {
                $missingFields[] = $key;
            }
        }

        if (!empty($missingFields)) {
            $missingFieldNames = implode(', ', $missingFields);
            $this->flashHelper->setFlashMessage('error', "Missing required fields: {$missingFieldNames}.");
            $this->redirectTo("{$type}/create");
        }

        $this->handleFileUploads($type, $formData);

        $success = $this->entityService->updateEntity($type, $id, $formData);
        if ($success) {
            $this->flashHelper->setFlashMessage('success', 'Entity updated successfully.');
            $this->redirectTo(self::LOCATION_MANAGE_TYPE . urlencode($type));
        } else {
            $this->flashHelper->setFlashMessage('error', 'An error occurred during update.');
        }
    }

    public function processDelete($type, $id): void
    {
        if (!$type || !$id) {
            $this->flashHelper->setFlashMessage('error', 'Type and ID are required for deleting an entity.');
            return;
        }

        // Check if the entity can be safely deleted
        try {
            $canDelete = $this->entityService->canDeleteEntity($type, $id);
            if (!$canDelete) {
                $this->flashHelper->setFlashMessage('error', 'This entity cannot be deleted because it is referenced by other entities.');
                $this->redirectTo(self::LOCATION_MANAGE_TYPE . urlencode($type));
            }
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', $e->getMessage());
            return;
        }

        $success = $this->entityService->deleteEntity($type, $id);
        if ($success) {
            $this->flashHelper->setFlashMessage('success', 'Entity deleted successfully.');
            $this->redirectTo(self::LOCATION_MANAGE_TYPE . urlencode($type) . '&status=deleted');
        } else {
            $this->flashHelper->setFlashMessage('error', 'An error occurred during deletion.');
        }
    }
}
