<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Seeder;
use CodeIgniter\Files\File;
use Config\Database;

class SubjectsSeeder extends Seeder
{

    public function __construct(Database $config, ?BaseConnection $db = null)
    {
        parent::__construct($config, $db);
        helper('inflector');
    }

    public function run(): void
    {
        $this->db->table('subjects')->insertBatch($this->getData());
    }

    private function getData(): array
    {
        $file = new File(ROOTPATH . 'course_list.csv');
        $csv = $file->openFile();
        $headerIndicator = 'Year';
        $data = [];
        $currentYearLevel = null;
        $currentSemester = null;

        foreach ($csv as $rowData) {
            if (!empty($rowData) && !str_contains($rowData, $headerIndicator)) {
                $row = preg_split('/,(?=(?:[^"]*"[^"]*")*[^"]*$)/', $rowData);
                $data[] = $this->buildData($row, $currentYearLevel, $currentSemester);
            }
        }

        return $data;
    }

    private function buildData(array $row, &$currentYearLevel, &$currentSemester): array
    {
        if (count($row) < 1) return [];

        $yearLevel = $row[0] == '' ? $currentYearLevel : $row[0];
        $semester = $row[1] == '' ? $currentSemester : $row[1];;
        $code = $row[2];
        $name = trim(humanize($row[3]), '"');
        $units = $row[4];

        // TODO check db for the values below if correct
        $currentYearLevel = $yearLevel;
        $currentSemester = strtolower($semester) === 'summer' ? $currentSemester : $semester;

        return [
            'year_level' => $yearLevel,
            'semester' => $semester,
            'code' => strtoupper($code),
            'name' => $name,
            'description' => $name,
            'slug' => strtolower(url_title($name)),
            'units' => $units,
            'curriculum_id' => 1,
        ];
    }
}
