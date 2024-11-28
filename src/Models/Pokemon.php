<?php

declare(strict_types=1);

namespace App\Models;

class Pokemon extends BaseModel
{
    protected function getCollectionName(): string
    {
        return 'pokemon';
    }

    public function findById(int $id): ?array
    {
        return $this->findOne(['id' => $id]);
    }

    public function findByType(string $type): array
    {
        return $this->find(['type' => $type]);
    }

    public function findByName(string $name): ?array
    {
        return $this->findOne(['name.english' => $name]);
    }
}
