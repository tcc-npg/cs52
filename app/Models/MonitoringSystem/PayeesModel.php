<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class PayeesModel extends Model
{
    protected $table = 'ms_payable_payee';
    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'status',
        'payment',
        'balance',
        'user_id',
        'payable_id'
    ];

    public function getPayeeDetails($payable_id)
    {
        return $this->select('b.user_id, b.student_number, 
        c.first_name, c.last_name, b.year_level, 
        ms_payable_payee.status,  ms_payable_payee.balance ')
            ->join('student_details b', 'ms_payable_payee.user_id = b.user_id')
            ->join('user_details c', 'ms_payable_payee.user_id = c.user_id')
            ->where('ms_payable_payee.payable_id', $payable_id)
            ->findAll();
    }

    public function getPayee($user_id, $payable_id)
    {
        return $this->select('b.user_id, b.student_number, 
        c.first_name, c.last_name, b.year_level, 
        ms_payable_payee.status, ms_payable_payee.balance ')
            ->join('student_details b', 'ms_payable_payee.user_id = b.user_id')
            ->join('user_details c', 'ms_payable_payee.user_id = c.user_id')
            ->where('ms_payable_payee.user_id', $user_id)
            ->where('ms_payable_payee.payable_id', $payable_id)
            ->first();
    }


    public function insertStudentInPayable($payable_id, $user_id)
{
    // Data to be inserted
    $data = ['user_id' => $user_id, 'payable_id' => $payable_id];

    // First, check if the user is already added in the payable list
    $existingRecord = $this->db->table($this->table)
        ->where('user_id', $user_id)
        ->where('payable_id', $payable_id)
        ->get()
        ->getRow();

    // If a record exists, return false indicating that the user is already added
    if ($existingRecord) {
        return false; // Or return a custom message if you want
    }

    // If no record exists, proceed with the insert
    return $this->db->table($this->table)->insert($data);
}


   
}
