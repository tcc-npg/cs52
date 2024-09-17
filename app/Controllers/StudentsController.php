<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentDetailsModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class StudentsController extends BaseController
{
    public function list(int|string $year): string
    {
        if (!in_array($year, [1, 2, 3, 4, 'all'])) {
            throw PageNotFoundException::forPageNotFound();
        }

        helper('inflector'); 
        $model = model(StudentDetailsModel::class);
        $studentList = $model->getStudentsByYear($year);
        return view('user/student/student-list', [
            'year' => $year,
            'list' => $studentList
        ]);
    }
}
