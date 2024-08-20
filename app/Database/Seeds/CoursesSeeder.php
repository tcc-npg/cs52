<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Seeder;
use CodeIgniter\Files\File;
use Config\Database;

class CoursesSeeder extends Seeder
{

    public function __construct(Database $config, ?BaseConnection $db = null)
    {
        parent::__construct($config, $db);
        helper('inflector');
    }

    public function run(): void
    {
        $this->db->table('courses')->insertBatch($this->getData());
    }

    private function getData(): array
    {
        $file = new File(ROOTPATH . 'course_list.csv');
        $csv = $file->openFile();
        $headerIndicator = 'Year';
        $data = [];
        $current = null;

        foreach ($csv as $rowData) {
            if (!empty($rowData) && !str_contains($rowData, $headerIndicator)) {
                $row = explode(',', $rowData);
                if (strtolower(trim($row[0])) !== $headerIndicator) {
                    $data[] = [...$this->buildData($row, $current)];
                }
            }
        }

        return $data;
    }

    private function buildData(array $row, &$current): array
    {
        if (count($row) < 1) return [];

        $yearLevel = $row[0] == '' ? $current : $row[0];
        $semester = $row[1];
        $code = $row[2];
        $name = humanize($row[3]);
        $units = $row[4];

        $current = $yearLevel;

        return [
            'year_level' => $yearLevel,
            'semester' => $semester,
            'code' => strtoupper($code),
            'name' => $name,
            'description' => $name,
            'slug' => strtolower(url_title($name)),
            'units' => $units,
        ];

    }
}
