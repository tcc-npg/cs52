<?php

namespace App\Models;

use App\Entities\SettingsEntity;
use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $returnType = SettingsEntity::class;
    protected $allowedFields = [
        'class',
        'value',
        'type',
        'context',
        'created_at',
        'updated_at',
    ];

    public function findByKey(string $key): object|array|null
    {
        return $this->where('key', $key)->first();
    }

    public function findByClass(string|array $class): object|array|null
    {
        if (!is_array($class)) {
            return $this->where('class', $class)->findAll();
        }
        return $this->whereIn('class', $class)->findAll();
    }
}
