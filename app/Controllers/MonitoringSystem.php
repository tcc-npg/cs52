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

    //**************************************************8****** UNNIFORM METHODS********************************************/
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




        // return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);

    }


    public function updateStudentInfo()
    {
        $updateSuccessMessage = 'Subject added successfully';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';
       
        $uniform_model = new UniformsModel();

        // Validate incoming request data
        if ($this->validate([
            'shirtSize' => 'required|in_list[xs,s,m,l,xl]', // Assuming shirtSize is an enum
            'pantSize' => 'required|in_list[xs,s,m,l,xl]', // Assuming pantSize is also an enum
            'status' => 'permit_empty|in_list[p,c]', // Status can be null, if null mean there is record but no payment
            'id' => 'required|integer'
        ])) {
            // Get form data
            $formData = $this->request->getPost();

            $data = [
                'shirt_size' => $formData['shirtSize'],
                'pant_size' => $formData['pantSize'],
                'status' => $formData['status'] ?? null 
            ];

            // Call the model to update the student
            if ($uniform_model->updateStudentInformation($formData['id'], $data)) {
                return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
            } else {
                $updateSuccessMessage = 'Subject not found';
                $toastColor = 'warning';
                $toastHeader = 'Warning ';
                $toastIcon = 'bxs-info-circle';
            }
        }

 
        
    }


    //*************************************************************** MODULE METHODS ***********************************************************/
    public function modules()
    {
        $module_model = model(ModulesModel::class);
        $list = $module_model->getModuleDetails();

        $subject_model = model(SubjectModel::class);
        $subject_list = $subject_model->findAll();

        return view('monitoring/modules', [
            'list' => $list,
            'subject_list' => $subject_list
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




    //****************************************** OTHER PAYABLE METHODS *****************************************************/

    public function otherPayables()
    {

        $model = model(OtherPayableModel::class);

        $list = $model->findAll();

        return view('monitoring/other-payable', [
            'list' => $list
        ]);
    }


    public function addNewPayable()
    {
        $updateSuccessMessage = 'New Payable Added';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';
        // Apply validation rules
        if (
            $this->validate([
                'payableName' => 'required',
                'amount' => 'required|decimal',
                'deadline' => 'required|valid_date',
                'payees' => 'required'
            ])
        ) {
            $formData = $this->request->getPost();
            $payableName = $formData['payableName'];
            $amount = $formData['amount'];
            $deadline = $formData['deadline'];
            $payees = $formData['payees'];

            // Save the data
            $model = model(OtherPayableModel::class);
            $model->save([
                'payable_name' => $payableName,
                'amount' => $amount,
                'deadline' => $deadline,
                'payees' => $payees
            ]);

            // Redirect or show success message
            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        } else {
            // Return validation errors
            $updateSuccessMessage = 'INVALID INPUTS';
            $toastColor = 'warning';
            $toastHeader = 'Warning ';
            $toastIcon = 'bxs-info-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }
    }


    public function payeeList($payable_id)
    {

        $payable_model = model(OtherPayableModel::class);

        $list = $payable_model->find($payable_id);
        $amount = $list['amount'];

        $year = '';
        switch ($list['payees']) {
            case '1st':
                $year = 1;
                break;
            case '2nd':
                $year = 2;
                break;
            case '3rd':
                $year = 3;
                break;
            case '4th':
                $year = 4;
                break;
            default:
                $year = 'all';

        }
        ;

        $student_model = model(StudentDetailsModel::class);

        $students = $student_model->getStudentsByYear($year);

        return view('monitoring/payee-list', [
            'list' => $students,
            'amount' => $amount

        ]);


    }




    //******************************* ANALYTICS METHODS *******************************************/

    public function viewData($module_id)
    {

        $student_model = model(ModuleStudentsModel::class);
        $module_model = model(ModulesModel::class);
        $uniform_model = model(UniformsModel::class);


        // $uniforms = $uniform_model->findAll();
        $students = $student_model->getStudentList($module_id);
        $modules = $module_model->findAll();

        // print_r($uniforms);
        // exit;

        

        return view('monitoring/analytics', [
            'students' => $students,
            'modules' => $modules

        ]);
    }


}


