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
        'payment'
    ];

    public function getPayeeDetails($payable_id)
    {
        return $this->select('b.user_id, b.student_number, 
        c.first_name, c.last_name, b.year_level, 
        ms_payable_payee.status ')
            ->join('student_details b', 'ms_payable_payee.user_id = b.user_id')
            ->join('user_details c', 'ms_payable_payee.user_id = c.user_id')
            ->where('ms_payable_payee.payable_id', $payable_id)
            ->findAll();
    }


    public function insertStudentInPayable(int $payable_id, $user_id)
    {

        $data = ['user_id' => $user_id, 'payable_id' => $payable_id];

        return $this->db->table($this->table)
            ->where('user_id', $data['user_id'])
            ->where('payable_id', $data['payable_id'])
            ->insert($data);
    }


}
