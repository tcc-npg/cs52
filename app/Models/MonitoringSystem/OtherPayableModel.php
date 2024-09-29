<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class OtherPayableModel extends Model
{
    protected $table = 'ms_other_payables ';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    public function getPayableDetails($payableId)
    {


        return $this->select('ms_other_payables.payable_name, ms_other_payables.payable_id, ms_other_payables.deadline, ms_other_payables.payees, ms_other_payables.amount,
        b.payment, b.status,
        c.year_level,
        d.first_name, d.last_name ')
            ->join('ms_payable_payee b', 'ms_other_payables.payable_id = b.payable_id')
            ->join('student_details c', 'b.user_id = c.user_id')
            ->join('user_details d', 'b.user_id = d.user_id')
            ->where('ms_other_payables.payable_id', $payableId)
            ->findAll();
    }


}
