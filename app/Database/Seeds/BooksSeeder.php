<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BooksSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('is_books')->insertBatch(
            [
                [
                    'book_name' => 'Book 1',
                    'author' => 'Author 1',
                ],
                [
                    'book_name' => 'Book 2',
                    'author' => 'Author 2',
                ],
                [
                    'book_name' => 'Book 3',
                    'author' => 'Author 3',
                ]
            ]
        );
    }
}
