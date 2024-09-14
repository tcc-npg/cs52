<?php

namespace App\Controllers\InventorySystem;

use App\Controllers\BaseController;
use Config\Database;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function dashboard()
    {
        $db = Database::connect();
        $books = $db->query('select * from is_books')->getResultArray();
    
        return view('inventory-system/dashboard', [
            'books' => $books
        ]);
    }
}
