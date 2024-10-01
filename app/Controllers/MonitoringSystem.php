<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MonitoringSystem\ModulesModel;
use App\Models\MonitoringSystem\ModuleStudentsModel;
use App\Models\MonitoringSystem\OtherPayableModel;
use App\Models\MonitoringSystem\UniformsModel;
use App\Models\SubjectModel;

use App\Models\StudentDetailsModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class MonitoringSystem extends BaseController
{
    protected $helpers = ['_url', '_toast'];
    public function uniform()
    {
        $model = model(UniformsModel::class);

        $data = $model->listStudentUniform();

        return view('monitoring/uniform', [
            'list' => $data

        ]);
    }

    public function addStudentInUniform()
    {
        $student_id = $this->request->getPost('studentId');

        $student_model = model(StudentDetailsModel::class);

        $student = $student_model->getStudentsByStudentId($student_id);

        $updateSuccessMessage = 'Student added successfully';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';

        if (empty($student)) {
            $updateSuccessMessage = 'Student not found';
            $toastColor = 'warning';
            $toastHeader = 'Warning ';
            $toastIcon = 'bxs-info-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);

        }

        $uniform_model = model(UniformsModel::class);
        $uniform_model->save([
            'user_id' => $student->user_id
        ]);

        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);

    }


    public function modules()
    {
        $module_model = model(ModulesModel::class);
        $list = $module_model->getModuleDetails();
        return view('monitoring/modules', [
            'list' => $list
        ]);
    }

    public function addModule()
    {
        $subject_code = $this->request->getPost('subjectCode');

        $subject_model = model(SubjectModel::class);
        $module = $subject_model->getSubjectByCode($subject_code);

        $updateSuccessMessage = 'Subject added successfully';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';

        if (empty($module)) {
            $updateSuccessMessage = 'Subject not found';
            $toastColor = 'warning';
            $toastHeader = 'Warning ';
            $toastIcon = 'bxs-info-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }


            $module_model = model(ModulesModel::class);
            $module_model->save([
                'code' => $subject_code
            ]);

            
            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        
    }


    public function studentsList(int|string $module_id, $name): string
    {

        $module = model(ModuleStudentsModel::class);

        $list = $module->getStudentList($module_id);

        return view('monitoring/student-list', [
            'module_list' => $list,
            'name' => $name

        ]);

    }


    public function otherPayables()
    {

        $model = model(OtherPayableModel::class);

        $data = $model->findAll();

        foreach ($data as $key) {
            $list = $model->getPayableDetails($key['payable_id']);
        }


        return view('monitoring/other-payable', [
            'list' => $list
        ]);
    }

    public function addNewPayable(){
        $model = model(OtherPayableModel::class);
        
    }

    public function payeeList()
    {

        $model = model(OtherPayableModel::class);

        $data = $model->findAll();

        foreach ($data as $key) {
            $list = $model->getPayableDetails($key['payable_id']);
            $name = $key['payable_name'];
        }

        return view('monitoring/payee-list', [
            'list' => $list,
            'name' => $name
        ]);
    }






    public function viewData(int|string $module_id)
    {

        $module = model(ModuleStudentsModel::class);

        $data = $module->getStudentList($module_id);

        return view('monitoring/analytics', [
            'module_details' => $data

        ]);
    }


}


