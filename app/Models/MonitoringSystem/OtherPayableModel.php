<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class OtherPayableModel extends Model
{
    protected $table = 'ms_other_payables ';
    protected $primaryKey = 'payable_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'payable_id',
        'payable_name',
        'amount',
        'deadline',
        'payees'

    ];

   


}
