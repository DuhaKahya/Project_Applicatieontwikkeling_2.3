<?php

namespace App\Repositories;

use Exception;
use InvalidArgumentException;
use PDO;
use PDOException;
use RuntimeException;

class EntityRepository extends Repository
{
    public function getAllEntities($entityType): bool|array
    {
        try {
            $tableName = $this->getTableName($entityType);
            if (!$tableName || !$this->validateTableName($tableName)) {
                $this->flashHelper->setFlashMessage('error', 'Invalid entity type.');
                header('Location: /');
            }

            $stmt = $this->connection->prepare("
                SELECT *
                FROM {$tableName}
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->flashHelper->setFlashMessage('error', 'An error occurred while fetching entities.');
            header('Location: /');
            exit();
        }
    }

    private function getTableName($entityType): ?string
    {
        return ucfirst($entityType) . 's';
    }

    private function validateTableName($tableName): bool
    {
        $stmt = "
            SELECT TABLE_NAME
            FROM INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = :dbName AND TABLE_NAME = :tableName
        ";
        $stmt = $this->connection->prepare($stmt);
        $stmt->execute([
            'dbName' => $this->dbName,
            'tableName' => $tableName
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return !empty($result);
    }

    public function getEntityById($entityType, $id)
    {
        try {
            $tableName = $this->getTableName($entityType);
            $identifierColumn = $this->getEntityProperties($entityType)['identifier'] ?? null;

            if (!$tableName || !$this->validateTableName($tableName)) {
                $this->flashHelper->setFlashMessage('error', 'Invalid entity type or table does not exist.');
                header('Location: /');
            }

            if (!$identifierColumn) {
                $this->flashHelper->setFlashMessage('error', 'Invalid entity type.');
                header('Location: /');
            }

            $query = "
                SELECT *
                FROM {$tableName}
                WHERE {$identifierColumn} = :id
            ";

            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->flashHelper->setFlashMessage('error', 'An error occurred while fetching entity details.');
            header('Location: /');
            exit();
        }
    }

    public function getEntityProperties($entityType): array
    {
        try {
            $tableName = $this->getTableName($entityType);
            if (!$tableName) {
                $this->flashHelper->setFlashMessage('error', 'Invalid entity type.');
                header('Location: /');
                exit();
            }

            $columns = $this->getColumnDetails($tableName);
            $primaryKey = $this->getPrimaryKey($tableName);
            $relationships = $this->getRelationships($tableName);

            return [
                'headers' => array_column($columns, 'COLUMN_NAME'),
                'fields' => array_map('lcfirst', array_column($columns, 'COLUMN_NAME')),
                'identifier' => $primaryKey,
                'relationships' => $relationships,
            ];
        } catch (PDOException $e) {
            $this->flashHelper->setFlashMessage('error', 'An error occurred while fetching entity properties.');
            header('Location: /');
            exit();
        }
    }

    private function getColumnDetails($tableName): array
    {
        $stmt = "
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = :dbName
                AND TABLE_NAME = :tableName
            ";
        $stmt = $this->connection->prepare($stmt);
        $stmt->execute(['dbName' => $this->dbName, 'tableName' => $tableName]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getPrimaryKey($tableName): ?string
    {
        $stmt = "
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = :dbName
              AND TABLE_NAME = :tableName
              AND CONSTRAINT_NAME = 'PRIMARY'
            ";
        $stmt = $this->connection->prepare($stmt);
        $stmt->execute(['dbName' => $this->dbName, 'tableName' => $tableName]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['COLUMN_NAME'] ?? null;
    }

    private function getRelationships($tableName): array
    {
        $stmt = "
            SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = :dbName
              AND TABLE_NAME = :tableName
              AND REFERENCED_TABLE_NAME IS NOT NULL
            ";
        $stmt = $this->connection->prepare($stmt);
        $stmt->execute(['dbName' => $this->dbName, 'tableName' => $tableName]);
        $foreignKeys = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $relationships = [];
        foreach ($foreignKeys as $foreignKey) {
            $relationships[] = [
                'table' => $foreignKey['REFERENCED_TABLE_NAME'],
                'foreignKey' => $foreignKey['COLUMN_NAME'],
                'references' => $foreignKey['REFERENCED_COLUMN_NAME'],
            ];
        }

        return $relationships;
    }

    public function createEntity($entityType, $data): bool
    {
        try {
            $tableName = $this->getTableName($entityType);
            $entityProperties = $this->getEntityProperties($entityType);
            $identifierColumn = $entityProperties['identifier'] ?? null;

            // Exclude the auto-incremented primary key field from the list of columns
            if ($identifierColumn && array_key_exists($identifierColumn, $data)) {
                unset($data[$identifierColumn]);
            }

            //gpt
            $columns = array_keys($data);
            $placeholders = array_map(function ($col) {
                return ':' . $col;
            }, $columns);

            $stmt = sprintf(
                "
            INSERT INTO %s (%s)
            VALUES (%s)
        ",
                $tableName,
                implode(', ', $columns),
                implode(', ', $placeholders)
            );

            $stmt = $this->connection->prepare($stmt);

            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            $this->flashHelper->setFlashMessage('error', 'An error occurred while creating the entity.');
            header('Location: /');
            exit();
        }

    }

    public function updateEntity($entityType, $id, $data): bool
    {
        try {
            $tableName = $this->getTableName($entityType);
            $identifierColumn = $this->getEntityProperties($entityType)['identifier'];

            $assignments = array_map(function ($col) {
                return $col . '=:' . $col;
            }, array_keys($data));

            //gpt
            $stmt = sprintf(
                "
                UPDATE %s
                SET %s
                WHERE %s=:id
            ",
                $tableName,
                implode(', ', $assignments),
                $identifierColumn
            );

            $stmt = $this->connection->prepare($stmt);
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->bindValue(':id', $id);

            return $stmt->execute();
        } catch (PDOException $e) {
            $this->flashHelper->setFlashMessage('error', 'An error occurred while updating the entity.');
            header('Location: /');
            exit();
        }
    }

    public function getForeignKeyOptions($foreignKey): bool|array
    {
        try {
            $tableName = $this->getTableNameFromForeignKey($foreignKey);

            $stmt = $this->connection->prepare("
                SELECT *
                FROM {$tableName}
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->flashHelper->setFlashMessage('error', 'An error occurred while fetching foreign key options.');
            header('Location: /');
            exit();
        }
    }

    private function getTableNameFromForeignKey($foreignKey): string
    {
        $baseName = rtrim($foreignKey, 'Id');
        return ucfirst($baseName) . 's';
    }

    public function deleteEntity($entityType, $id): bool
    {
        try{
            $tableName = $this->getTableName($entityType);
            $identifierColumn = $this->getEntityProperties($entityType)['identifier'];

            $stmt = $this->connection->prepare("
                DELETE
                FROM {$tableName}
                WHERE {$identifierColumn} = :id
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->flashHelper->setFlashMessage('error', 'An error occurred while deleting the entity.');
            header('Location: /');
            exit();
        }
    }

    public function entityExists($entityType, $fieldName, $value): bool
    {
        $tableName = $this->getTableName($entityType);
        $stmt = "
            SELECT COUNT(*)
            FROM {$tableName}
            WHERE {$fieldName} = :value
            ";
        $stmt = $this->connection->prepare($stmt);
        $stmt->bindParam(':value', $value);

        try {
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result > 0;
        } catch (Exception $e) {
            $this->flashHelper->setFlashMessage('error', 'An error occurred while checking if the entity exists.');
            header('Location: /');
            exit();
        }
    }

    public function canDeleteEntity($type, $id): bool
    {
        $entityProperties = $this->getEntityProperties($type);

        if (isset($entityProperties['relationships'])) {
            foreach ($entityProperties['relationships'] as $relationship) {
                $count = $this->countRelatedEntities($relationship['table'], $relationship['foreignKey'], $id);
                if ($count > 0) {
                    return false;
                }
            }
        }
        return true;
    }

    public function countRelatedEntities($relatedTable, $foreignKey, $id): int
    {
        try{
            $stmt = "
                SELECT COUNT(*)
                FROM {$relatedTable}
                WHERE {$foreignKey} = :id
            ";
            $stmt = $this->connection->prepare($stmt);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            $this->flashHelper->setFlashMessage('error', 'An error occurred while counting related entities.');
            header('Location: /');
            exit();
        }

    }

    public function getAllEntitiesWithNames($entityType): bool|array
    {
        $tableName = $this->getTableName($entityType);
        if (!$tableName) {
            $this->flashHelper->setFlashMessage('error', 'Invalid entity type.');
            header('Location: /');
        }

        $selectStatements = ["$tableName.*"];
        $joinClauses = [];
        $whereClauses = "";

        switch ($entityType) {
            case 'artistEvent':
                $selectStatements[] = "$tableName.ArtistEventId AS id";
                $selectStatements[] = "Artists.Name AS artistName";
                $selectStatements[] = "ArtistEventLocations.Name AS locationName";

                $joinClauses[] = "LEFT JOIN Artists ON $tableName.ArtistId = Artists.ArtistId";
                $joinClauses[] = "LEFT JOIN ArtistEventLocations ON $tableName.ArtistEventLocationId = ArtistEventLocations.ArtistEventLocationId";
                $whereClauses = "WHERE $tableName.Price IS NOT NULL";
                break;
            default:
                $this->flashHelper->setFlashMessage('error', 'Unsupported entity type.');
                break;
        }

        //gpt
        $stmt = sprintf(
            "SELECT %s FROM %s %s %s",
            implode(', ', $selectStatements),
            $tableName,
            implode(' ', $joinClauses),
            $whereClauses
        );

        try {
            $stmt = $this->connection->prepare($stmt);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->flashHelper->setFlashMessage('error', 'An error occurred while fetching entities.');
            header('Location: /');
            exit();
        }
    }

    public function getEntityDetailsById($entityType, $id): array
    {
        $tableName = $this->getTableName($entityType);
        $properties = $this->getEntityProperties($entityType);
        $identifierColumn = $properties['identifier'] ?? null;

        if (!$tableName || !$identifierColumn) {
            $this->flashHelper->setFlashMessage('error', 'Invalid entity type or identifier.');
            header('Location: /');
        }

        $selectStatements = ["$tableName.*"];
        $joinClauses = [];

        switch ($entityType) {
            case 'artistEvent':
                $selectStatements[] = "$tableName.ConcertStartTime AS startTime";
                $selectStatements[] = "$tableName.ConcertEndTime AS endTime";
                $selectStatements[] = "Artists.Name AS artistName";
                $selectStatements[] = "ArtistEventLocations.Name AS locationName";
                $joinClauses[] = "LEFT JOIN Artists ON $tableName.ArtistId = Artists.ArtistId";
                $joinClauses[] = "LEFT JOIN ArtistEventLocations ON $tableName.ArtistEventLocationId = ArtistEventLocations.ArtistEventLocationId";
                break;
            default:
                $this->flashHelper->setFlashMessage('error', 'Unsupported entity type.');
                break;
        }

        //gpt
        $stmt = sprintf(
            "SELECT %s FROM %s %s WHERE $tableName.$identifierColumn = :id",
            implode(', ', $selectStatements),
            $tableName,
            implode(' ', $joinClauses),
        );

        try {
            $stmt = $this->connection->prepare($stmt);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                $this->flashHelper->setFlashMessage('error', 'Entity not found.');
            }

            return $result;
        } catch (PDOException $e) {
            $this->flashHelper->setFlashMessage('error', 'An error occurred while fetching entity details.');
            header('Location: /');
            exit();
        }
    }
}
