<?php

namespace App\Models;

use App\Entities\SettingsEntity;
use CodeIgniter\Model;
use CodeIgniter\Pager\Pager;
use ReflectionException;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $returnType = SettingsEntity::class;
    protected $allowedFields = [
        'class',
        'value',
        'type',
        'key',
        'context',
        'created_at',
        'updated_at',
    ];

//    protected $afterUpdateBatch = ['updateSchoolYear'];

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

//    /**
//     * @throws ReflectionException
//     */
//    protected function updateSchoolYear(object|array $data): object|array
//    {
//        $updated = $data['data'];
//
//        $cols = array_column($updated, 'key');
//
//        if (!in_array('sy_start_date', $cols) && !in_array('sy_end_date', $cols)) return $data;
//
//        $currentSySetting = $this->findByKey('current_sy');
//        $currentSy = $currentSySetting->value;
//
//        $newSy = array_reduce($updated, function ($result, $item) {
//            if ($item['key'] === 'sy_start_date') {
//                $result = substr($item['value'], 0, 4);
//            }
//            if ($item['key'] === 'sy_end_date') {
//                $result .= '-' . substr($item['value'], 0, 4);;
//            }
//            return $result;
//        });
//
//        if (strlen($currentSy) !== strlen($newSy)) return $data;
//
//        if ($currentSy === $newSy) return $data;
//
//        $currentSySetting->value = $newSy;
//
//        $this->save($currentSySetting);
//
//        return $data;
//    }
}
