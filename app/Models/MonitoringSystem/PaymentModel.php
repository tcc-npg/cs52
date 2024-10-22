<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table            = 'ms_payments';
    protected $primaryKey       = 'payment_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'payable_id',
        'module_id',
        'uniform_id',
        'amount',
    ];

    
}
