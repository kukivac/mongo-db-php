<?php

declare(strict_types=1);

namespace App\Models;

class Move extends BaseModel
{
    protected function getCollectionName(): string
    {
        return 'moves';
    }
}
