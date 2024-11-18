<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class ModuleStudentsModel extends Model
{
    protected $table = 'ms_module_students';
    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';

    protected $allowedFields = [
        'status',
        'user_id',
        'module_id',
        'payment',
        'payment_date',
        'balance'
    ];

    public function getStudentList(int $module_id)
    {
        return $this->select('b.user_id, b.student_number, c.first_name, c.last_name, b.year_level, ms_module_students.status, ms_module_students.balance')
            ->join('student_details b', 'ms_module_students.user_id = b.user_id')
            ->join('user_details c', 'ms_module_students.user_id = c.user_id')
            ->where('ms_module_students.module_id', $module_id)
            ->findAll();

    }

    public function getStudentModule($student_id, $module_id)
    {
        return $this->select('b.user_id, b.student_number, c.first_name, c.last_name, b.year_level, d.secret, ms_module_students.status, ms_module_students.balance ')
            ->join('student_details b', 'ms_module_students.user_id = b.user_id')
            ->join('user_details c', 'ms_module_students.user_id = c.user_id')
            ->join('auth_identities d', 'ms_module_students.user_id = d.user_id')
            ->where('ms_module_students.user_id', $student_id)
            ->where('ms_module_students.module_id', $module_id)
            ->first();
    }

    public function insertStudentInModule(int $module_id, $user_id)
{
    // Data to be inserted
    $data = ['user_id' => $user_id, 'module_id' => $module_id];

    // First, check if the user is already enrolled in the module
    $existingRecord = $this->db->table($this->table)
        ->where('user_id', $user_id)
        ->where('module_id', $module_id)
        ->get()
        ->getRow();

    // If the record exists, return false or a message indicating the user is already enrolled
    if ($existingRecord) {
        return false; // Or you can return an error message
    }

    // If no record exists, insert the new record
    return $this->db->table($this->table)->insert($data);
}

}
