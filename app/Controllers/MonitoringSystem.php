<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MonitoringSystem\ModulesModel;
use App\Models\MonitoringSystem\ModuleStudentsModel;
use App\Models\MonitoringSystem\OtherPayableModel;
use App\Models\MonitoringSystem\PayeesModel;
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




        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);

    }


    // needs to add function to update 'updated_at' value
    public function updateStudentInfo()
    {
        $updateSuccessMessage = 'Information updated successfully';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';

        $uniform_model = model(UniformsModel::class);

        // Validate incoming request data
        if (
            $this->validate([
                'shirtSize' => 'permit_empty|in_list[xs,s,m,l,xl]', // Assuming shirtSize is an enum
                'pantSize' => 'permit_empty|in_list[xs,s,m,l,xl]', // Adjust as needed
                'status' => 'permit_empty|in_list[p,c]', // Status can be empty or in list
                'id' => 'required|integer'
            ])
        ) {
            // Get form data
            $formData = $this->request->getPost();

            // Prepare data for updating
            $data = [];

            if (!empty($formData['shirtSize'])) {
                $data['shirt_size'] = $formData['shirtSize'];
            }

            if (!empty($formData['pantSize'])) {
                $data['pants_size'] = $formData['pantSize'];
            }

            if (!empty($formData['status'])) {
                $data['status'] = $formData['status'];
            }

            if (!empty($formData['payment'])) {
                $data['payment'] = $formData['payment'];
            }

            // Update student information
            $uniform_model->updateStudentInformation($formData['id'], $data);

            // Return success toast
            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        } else {
            // Handle validation errors
            $updateErrorMessage = 'Missing or incorrect fields';
            $toastColor = 'warning';
            $toastHeader = 'Warning';
            $toastIcon = 'bxs-info-circle';

            // Return error toast
            return redirectBackWithToast($updateErrorMessage, $toastColor, $toastHeader, $toastIcon);
        }
    }


    public function deleteStudentInUniformList($student_id)
    {
        $uniform_model = model(UniformsModel::class);

        $updateSuccessMessage = 'Student Removed';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';

        $uniform_model->delete($student_id);
        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);

    }

    public function setUniformAmount()
    {
        $amount = $this->request->getPost('totalAmount');

        $uniform_model = model(UniformsModel::class);


        $data = [
            'amount' => $amount
        ];

        // Update all rows in the table
        $uniform_model->where('1=1')->set($data)->update();


        $updateSuccessMessage = 'Total Amount Updated';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';

        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);


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
        $amount = $this->request->getPost('amount');


        if (
            $this->validate([
                'subjectCode' => 'required',
                'amount' => 'required|decimal'  // Validate amount as a decimal number
            ])
        ) {
            $subject_model = model(SubjectModel::class);
            $module = $subject_model->getSubjectByCode($subject_code);

            $module_model = model(ModulesModel::class);

            // Check if module already exists in the database
            $existingModule = $module_model->where('code', $subject_code)->first();

            if ($existingModule) {
                // Module already exists
                $updateSuccessMessage = 'Module already exists in the database.';
                $toastHeader = 'Error';
                $toastColor = 'danger';
                $toastIcon = 'bxs-error-circle';
                return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
            } else {
                // Module does not exist, proceed with saving
                $module_model->save([
                    'code' => $subject_code,
                    'amount' => $amount
                ]);

                $updateSuccessMessage = 'Module added successfully.';
                $toastHeader = 'Success';
                $toastColor = 'success';
                $toastIcon = 'bxs-check-circle';
                
            }

        } else {
            // Validation failed
            $updateSuccessMessage = 'Please Check Inputs';
            $toastHeader = 'Error';
            $toastColor = 'danger';
            $toastIcon = 'bxs-error-circle';
            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }



        $latest_module = $module_model->orderBy('created_at', 'DESC')
            ->first();


        $year_level = $this->request->getPost('yearLevel');

        $year = '';
        switch ($year_level) {
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

        $module_student = model(ModuleStudentsModel::class);
        foreach ($students as $student) {
            $module_student->insertStudentInModule($latest_module['module_id'], $student->user_id);

        }



        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);

    }

    public function studentsList(int|string $module_id, $name, $module_amount): string
    {

        $module = model(ModuleStudentsModel::class);

        $list = $module->getStudentList($module_id);

        return view('monitoring/student-list', [
            'module_list' => $list,
            'name' => $name,
            'module_id' => $module_id,
            'amount' => $module_amount

        ]);

    }

    public function deleteModule()
    {

        $module_model = model(ModulesModel::class);

        $module_id = $this->request->getPost(index: 'moduleId');

        $module_model->delete([$module_id]);


        return redirect()->to(url_to('monitoring.modules'));

    }


    public function updateStudentModuleStatus($user_id)
    {

        $module_student = model(ModuleStudentsModel::class);

        $new_status = $this->request->getPost('status');
        $payment = $this->request->getPost('payment');

        $data = [];

        if (!empty($new_status)) {
            $data['status'] = $new_status;
        }
        if (!empty($payment)) {
            $data['payment'] = $payment;
        }

        // print_r($data);
        // exit;

        // Perform the update query
        $module_student->where('user_id', $user_id)->set($data)->update();

        $updateSuccessMessage = 'Status updated';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';

        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
    }

    public function deleteStudentInModuleList($user_id)
    {

        $module_student = model(ModuleStudentsModel::class);

        $updateSuccessMessage = 'Student Removed';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';


        $module_student->delete($user_id);
        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);

    }


    public function addStudentInModuleList()
    {

        $student_id = $this->request->getPost('studentId');
        $module_id = $this->request->getPost('moduleId');



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

        $module_student = model(ModuleStudentsModel::class);
        $module_student->insertStudentInModule($module_id, $student->user_id);
        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
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

            $latest_payable = $model->orderBy('created_at', 'DESC')
                ->first();

            $year = '';
            switch ($payees) {
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
            $payee_model = model(PayeesModel::class);

            foreach ($students as $student) {
                $payee_model->insertStudentInPayable($latest_payable['payable_id'], $student->user_id);

            }


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
        $payable = $payable_model->where('payable_id', $payable_id)->first();
        $amount = $payable['amount'];
        $name = $payable['payable_name'];
        $payable_id = $payable['payable_id'];
        $payee_model = model(PayeesModel::class);
        $list = $payee_model->getPayeeDetails($payable_id);



        return view('monitoring/payee-list', [
            'list' => $list,
            'amount' => $amount,
            'name' => $name,
            'payable_id' => $payable_id

        ]);

    }

    public function updatePayeeInfo($user_id)
    {
        $payee_model = model(PayeesModel::class);

        $new_status = $this->request->getPost('status');
        $payment = $this->request->getPost('payment');

        $data = [];

        if (!empty($new_status)) {
            $data['status'] = $new_status;
        }
        if (!empty($payment)) {
            $data['payment'] = $payment;
        }

        $payee_model->where('user_id', $user_id)->set($data)->update();

        $updateSuccessMessage = 'Status updated';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';

        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
    }


    public function deleteOtherPayable()
    {

        $other_payable_model = model(OtherPayableModel::class);

        $module_id = $this->request->getPost(index: 'moduleId');

        $other_payable_model->delete([$module_id]);


        return redirect()->to(url_to('monitoring.otherPayables'));

    }


    //******************************* ANALYTICS METHODS *******************************************/

    public function viewData($module_id)
    {

        $student_model = model(ModuleStudentsModel::class);
        $module_model = model(ModulesModel::class);
        $uniform_model = model(UniformsModel::class);


        $uniforms = $uniform_model->listStudentUniform();
        $students = $student_model->getStudentList($module_id);
        $modules = $module_model->findAll();




        return view('monitoring/analytics', [
            'students' => $students,
            'modules' => $modules,
            'uniforms' => $uniforms
        ]);
    }


}