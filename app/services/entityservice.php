<?php

namespace App\Services;

use App\Repositories\EntityRepository;

class EntityService
{
    private EntityRepository $repository;

    public function __construct()
    {
        $this->repository = new EntityRepository();
    }

    public function getAllEntities($entityType): bool|array
    {
        return $this->repository->getAllEntities($entityType);
    }

    public function getEntityProperties($entityType): array
    {
        return $this->repository->getEntityProperties($entityType);
    }

    public function getEntityById($entityType, $id)
    {
        return $this->repository->getEntityById($entityType, $id);
    }

    public function createEntity($entityType, $data): bool
    {
        return $this->repository->createEntity($entityType, $data);
    }

    public function updateEntity($entityType, $id, $data): bool
    {
        return $this->repository->updateEntity($entityType, $id, $data);
    }

    public function getForeignKeyOptions($foreignKey): bool|array
    {
        return $this->repository->getForeignKeyOptions($foreignKey);
    }

    public function deleteEntity($entityType, $id): bool
    {
        return $this->repository->deleteEntity($entityType, $id);
    }

    public function entityExists(mixed $type, string $string, mixed $name): bool
    {
        return $this->repository->entityExists($type, $string, $name);
    }

    public function canDeleteEntity($type, $id): bool
    {
        return $this->repository->canDeleteEntity($type, $id);
    }

    public function getAllEntitiesWithNames(mixed $entityType): bool|array
    {
        return $this->repository->getAllEntitiesWithNames($entityType);
    }

    public function getEntityDetailsById(string $string, int|string $id): array
    {
        return $this->repository->getEntityDetailsById($string, $id);
    }
}
