<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MonitoringSystem\ModulesModel;
use App\Models\MonitoringSystem\ModuleStudentsModel;
use App\Models\MonitoringSystem\OtherPayableModel;
use App\Models\MonitoringSystem\PayeesModel;
use App\Models\MonitoringSystem\PaymentModel;
use App\Models\MonitoringSystem\UniformsModel;
use App\Models\SubjectModel;

use App\Models\StudentDetailsModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class MonitoringSystem extends BaseController
{
    protected $helpers = ['_url', '_toast'];

    //******************************************************** UNNIFORM METHODS********************************************/
    public function uniform()
    {
        helper(['_sizes', '_status']);
        $model = model(UniformsModel::class);
        $payment_model = model(PaymentModel::class);
        $payeePayments = [];

        if (auth()->user()->inGroup('admin')) {
            $students = $model->listStudentUniform();
            foreach ($students as $student) {
                $payments = $payment_model->where('user_id', $student['user_id'])
                    ->where('uniform_id', $student['id'])
                    ->findAll();

                $newBalance = 0;
                $totalPayment = 0;
                foreach ($payments as $payment) {
                    $totalPayment += $payment['amount'];
                }

                $newBalance = $student['amount'] - $totalPayment;

                $data = [
                    'balance' => $newBalance
                ];

                $model->where('user_id', $student['user_id'])->update($student['id'], $data);


                if ($student['balance'] == 0) {
                    $data = ['status' => 'p'];
                    $model->where('user_id', $student['user_id'])->update($student['id'], $data);
                } elseif ($student['balance'] < $student['amount'] && !empty($payments)) {
                    $data = ['status' => 'c'];
                    $model->where('user_id', $student['user_id'])->update($student['id'], $data);
                }



                $payeePayments[] = [
                    'students' => $student,
                    'payments' => $payments
                ];
            }
        } else {
            $student = $model->listStudentUniformInfo(auth()->user()->id);

            if (empty($student['user_id']) || empty($student['id'])) {


                return view('monitoring/uniform', [
                    'list' => $payeePayments
                ]);
            }
            ;

            // Now proceed with the query since the student data exists
            $payments = $payment_model->where('user_id', $student['user_id'])
                ->where('uniform_id', $student['id'])
                ->findAll();

            $newBalance = 0;
            $totalPayment = 0;
            foreach ($payments as $payment) {
                $totalPayment += $payment['amount'];
            }
            $newBalance = $student['amount'] - $totalPayment;
            $data = [
                'balance' => $newBalance
            ];

           
            $model->where('user_id', $student['user_id'])->update($student['user_id'], $data);
           
            if ($student['balance'] == 0) {
                $data = ['status' => 'p'];
                $model->where('user_id', $student['user_id'])->update($student['id'], $data);
            } elseif ($student['balance'] < $student['amount'] && !empty($payments)) {
                $data = ['status' => 'c'];
                $model->where('user_id', $student['user_id'])->update($student['id'], $data);
            }

            $payeePayments[] = [
                'students' => $student,
                'payments' => $payments
            ];

        }

        return view('monitoring/uniform', [
            'list' => $payeePayments

        ]);
    }

    public function addStudentInUniform()
    {
        if (auth()->user()->inGroup('admin')) {
            $studentId = $this->request->getPost('studentId');

            $studentModel = model(StudentDetailsModel::class);
            $student = $studentModel->getStudentsByStudentId($studentId);

            // Default success message
            $updateSuccessMessage = 'Student added successfully';
            $toastHeader = 'Success';
            $toastColor = 'success';
            $toastIcon = 'bxs-check-circle';

            // Check if the student exists
            if (empty($student)) {
                $updateSuccessMessage = 'Student not found';
                $toastColor = 'warning';
                $toastHeader = 'Warning';
                $toastIcon = 'bxs-info-circle';

                return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
            }

            // Check if the student is already in the uniform list
            $uniformModel = model(UniformsModel::class);
            $existingUniform = $uniformModel->where('user_id', $student->user_id)->first();

            if ($existingUniform) {
                $updateSuccessMessage = 'Student is already in the uniform list';
                $toastColor = 'Warning';
                $toastHeader = 'Error';
                $toastIcon = 'bxs-error-circle';

                return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
            }

            // Save the student to the uniforms model
            $uniformModel->save(['user_id' => $student->user_id]);

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        } else {
            $updateSuccessMessage = 'Unauthorized Access';
            $toastHeader = 'Warning';
            $toastColor = 'warning';
            $toastIcon = 'bxs-check-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }
    }




    // needs to add function to update 'updated_at' value
    public function updateStudentInfo($user_id, $uniform_id)
    {
        if (auth()->user()->inGroup('admin')) {
            // Toast message details for success and error
            $updateSuccessMessage = 'Information updated successfully';
            $updateErrorMessage = 'No changes made. Please update at least one field.';
            $toastHeader = 'Success';
            $toastErrorHeader = 'Error';
            $toastColorSuccess = 'success';
            $toastColorError = 'warning';
            $toastIconSuccess = 'bxs-check-circle';
            $toastIconError = 'bxs-error-circle';

            // Load the models
            $uniform_model = model(UniformsModel::class);
            $payment_model = model(PaymentModel::class);
            $email = \Config\Services::email();


            // Get the input from the form
            $shirt_size = $this->request->getPost('shirtSize');
            $pant_size = $this->request->getPost('pantSize');
            $new_payment = $this->request->getPost('payment');
            $new_status = $this->request->getPost('status');

            // Initialize a flag to track if any field was updated
            $isUpdated = false;

            // Array to hold payment data if applicable
            $payment_data = [];
            $subject = 'Uniform Information Update';
            $message = ''; // Initialize the message variable

            // Check if shirt size is provided and update it
            if (!empty($shirt_size)) {
                $uniform_model->where('user_id', $user_id)->set('shirt_size', $shirt_size)->update();
                $message .= "The shirt size has been successfully updaten\n ";
                $isUpdated = true;
            }

            // Check if pant size is provided and update it
            if (!empty($pant_size)) {
                $uniform_model->where('user_id', $user_id)->set('pants_size', $pant_size)->update();
                $message .= "The pants size has been successfully updated\n";
                $isUpdated = true;
            }

            // Check if status is provided and update it
            if (!empty($new_status)) {
                $uniform_model->where('user_id', $user_id)->set('status', $new_status)->update();
                $message .= "The status has been successfully updated\n";
                $isUpdated = true;
            }

            if (isset($new_payment) && $new_payment !== '') {
                $payment_data['amount'] = $new_payment;

                if ($new_payment > 0) {
                    $payment_data['payment_date'] = date('Y-m-d H:i:s');
                    $payment_data['uniform_id'] = $uniform_id;
                    $payment_data['user_id'] = $user_id;

                    $payment_model->insert($payment_data);
                    $message .= "A payment of $new_payment has been successfully recorded\n";
                    $isUpdated = true;
                }
            }

            // Check if payment is provided and handle the payment data

            // Output the final message if there were updates, or provide an alternative message
            if ($isUpdated) {

                $student_details = $uniform_model->listStudentUniformInfo($user_id);

                // Ensure student email exists
                if (!empty($student_details['secret'])) {
                    $student_email = $student_details['secret'];


                    // Set email parameters
                    $email->setFrom('smasher.warren@gmail.com', 'College of Computer Studies Office');
                    $email->setTo($student_email);
                    $email->setSubject($subject);
                    $email->setMessage($message);

                    // Send email and handle response
                    if ($email->send()) {
                        $updateSuccessMessage = 'Status updated, Email sent to student';
                    } else {
                        // Print error message if email not sent
                        $errorData = $email->printDebugger(['headers']);
                        print_r($errorData);
                        exit;
                    }
                }
            }

            // If no updates were made, show an error message
            if (!$isUpdated) {


                return redirectBackWithToast($updateErrorMessage, $toastColorError, $toastErrorHeader, $toastIconError);
            }

            // If updates were made, show a success message
            return redirectBackWithToast($updateSuccessMessage, $toastColorSuccess, $toastHeader, $toastIconSuccess);
        } else {
            $updateSuccessMessage = 'Unauthorized Access';
            $toastHeader = 'Warning';
            $toastColor = 'warning';
            $toastIcon = 'bxs-check-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }
    }




    public function deleteStudentInUniformList($uniform_id)
    {
        if (auth()->user()->inGroup('admin')) {
            $uniform_model = model(UniformsModel::class);

            $updateSuccessMessage = 'Student Removed';
            $toastHeader = 'Success';
            $toastColor = 'success';
            $toastIcon = 'bxs-check-circle';

            $uniform_model->delete($uniform_id);
            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        } else {
            $updateSuccessMessage = 'Unauthorized Access';
            $toastHeader = 'Warning';
            $toastColor = 'warning';
            $toastIcon = 'bxs-check-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }
    }

    public function setUniformAmount()
    {
        if (auth()->user()->inGroup('admin')) {
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

        } else {
            $updateSuccessMessage = 'Unauthorized Access';
            $toastHeader = 'Warning';
            $toastColor = 'warning';
            $toastIcon = 'bxs-check-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }
    }



    //*************************************************************** MODULE METHODS ***********************************************************/
    public function modules()
    {
        $module_model = model(ModulesModel::class);
        helper('inflector');
        if (auth()->user()->inGroup('admin')) {
            $list = $module_model->getModuleDetails();
            $subject_model = model(SubjectModel::class);
            $subject_list = $subject_model->findAll();

        } else {
            $list = $module_model->getStudentModules($this->user->getStudentDetails()->year_level);
            $subject_list = [];
        }
        return view('monitoring/modules', [
            'list' => $list,
            'subject_list' => $subject_list
        ]);
    }

    public function addModule()
    {

        $updateSuccessMessage = 'Subject added successfully';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';

        if (auth()->user()->inGroup('admin')) {


            $subject_code = $this->request->getPost('subjectCode');
            $amount = $this->request->getPost('amount');
            $year_level = $this->request->getPost('yearLevel');

            if (
                $this->validate([
                    'subjectCode' => 'required',
                    'amount' => 'required|decimal',
                    'yearLevel' => 'required'  // Validate amount as a decimal number
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

                    $student_model = model(StudentDetailsModel::class);

                    $students = $student_model->getStudentsByYear($year_level);

                    if (empty($students)) {
                        $updateSuccessMessage = 'No students are currently enrolled.';
                        $toastColor = 'warning';
                        $toastHeader = 'Warning ';
                        $toastIcon = 'bxs-info-circle';

                        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
                    }

                    // Module does not exist, proceed with saving
                    $module_model->save([
                        'code' => $subject_code,
                        'amount' => $amount,
                        'year_level' => $year_level
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
        } else {
            $updateSuccessMessage = 'Unauthorized Access';
            $toastHeader = 'Warning';
            $toastColor = 'warning';
            $toastIcon = 'bxs-check-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }
    }

    public function studentsList($module_id, $name)
    {
        helper('_status');
        $module_model = model(ModulesModel::class);
        $students_model = model(ModuleStudentsModel::class);
        $payment_model = model(PaymentModel::class);


        $module = $module_model->where('module_id', $module_id)->first();

        $module_amount = $module['amount'];

        $payeePayments = [];

        if (auth()->user()->inGroup('admin')) {
            $students = $students_model->getStudentList($module_id);
            foreach ($students as $student) {
                $payments = $payment_model->where('user_id', $student['user_id'])
                    ->where('module_id', $module_id)
                    ->findAll();

                $newBalance = 0;
                $totalPayment = 0;

                foreach ($payments as $payment) {
                    $totalPayment += $payment['amount'];
                }

                $newBalance = $module_amount - $totalPayment;

                $data = [
                    'balance' => $newBalance
                ];


                $students_model->where('user_id', $student['user_id'])->update($student['user_id'], $data);

                if ($student['balance'] == 0) {
                    $data = ['status' => 'p'];
                    $students_model->where('user_id', $student['user_id'])->update($student['user_id'], $data);
                } elseif ($student['balance'] < $module_amount && !empty($payments)) {
                    $data = ['status' => 'c'];
                    $students_model->where('user_id', $student['user_id'])->update($student['user_id'], $data);
                }


                $payeePayments[] = [
                    'students' => $student,
                    'payments' => $payments
                ];
            }

        } else {
            $student = $students_model->getStudentModule(auth()->user()->id, $module_id);
            if (empty($student)) {
                $updateSuccessMessage = 'Student not in the list. Please notify admin.';
                $toastColor = 'warning';
                $toastHeader = 'Warning ';
                $toastIcon = 'bxs-info-circle';

                return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);

            }

            $payments = $payment_model->where('user_id', $student['user_id'])
                ->where('module_id', $module_id)
                ->findAll();


            $newBalance = 0;
            $totalPayment = 0;

            foreach ($payments as $payment) {
                $totalPayment += $payment['amount'];
            }

            $newBalance = $module_amount - $totalPayment;

            $data = [
                'balance' => $newBalance
            ];

            $students_model->where('user_id', $student['user_id'])->update($student['user_id'], $data);

            if ($student['balance'] == 0) {
                $data = ['status' => 'p'];
                $students_model->where('user_id', $student['user_id'])->update($student['user_id'], $data);
            } elseif ($student['balance'] < $module_amount && !empty($payments)) {
                $data = ['status' => 'c'];
                $students_model->where('user_id', $student['user_id'])->update($student['user_id'], $data);
            }

            $payeePayments[] = [
                'students' => $student,
                'payments' => $payments
            ];

        }


        return view('monitoring/student-list', [
            'module_list' => $payeePayments,
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


    public function updateStudentModuleStatus($user_id, $module_id)
    {
        // Load models
        $module_student = model(ModuleStudentsModel::class);
        $payment_model = model(PaymentModel::class);
        $email = \Config\Services::email();

        // Get input data
        $new_status = $this->request->getPost('status');
        $payment = $this->request->getPost('payment');
        $module_name = $this->request->getPost('moduleName');

        // Prepare update data
        $data = [];
        $subject = 'Module Information Update : ' . $module_name;
        $message = "Dear Student, \n\n"; // Initialize the message variable

        // Update module status if provided
        if (!empty($new_status)) {
            $module_student->where('user_id', $user_id)->set('status', $new_status)->update();
            $message .= "The status of your module, \"$module_name,\" has been successfully updated.";
        }

        // Handle payment processing
        if (isset($payment) && $payment !== '') {
            $data['amount'] = $payment;

            // Only set payment date if payment is greater than 0
            if ($payment > 0) {
                $data['payment_date'] = date('Y-m-d H:i:s');
                $data['module_id'] = $module_id;
                $data['user_id'] = $user_id;

                // Insert a new payment record for the user
                $payment_model->insert($data);

                // Add payment details to the message
                $message .= "\nA payment of PHP " . number_format($payment, 2) . " has been recorded.";
            }



        } else {
            // Handle cases where no new status or payment data is provided
            if (empty($new_status)) {
                $updateSuccessMessage = 'Please enter data fields.';
                $toastColor = 'warning';
                $toastHeader = 'Warning';
                $toastIcon = 'bxs-info-circle';

                return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
            }
        }
        // Get student details
        $student_details = $module_student->getStudentModule($user_id, $module_id);

        // Ensure student email exists
        if (!empty($student_details['secret'])) {
            $student_email = $student_details['secret'];

            // Set email parameters
            $email->setFrom('smasher.warren@gmail.com', 'College of Computer Studies Office');
            $email->setTo($student_email);
            $email->setSubject($subject);
            $email->setMessage($message);

            // Send email and handle response
            if ($email->send()) {
                $updateSuccessMessage = 'Status updated, Email sent to student';
            } else {
                // Print error message if email not sent
                $errorData = $email->printDebugger(['headers']);
                print_r($errorData);
                exit;
            }
        }

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
        if ($module_student->insertStudentInModule($module_id, $student->user_id)) {
            // Success: Student added
            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        } else {
            // Error: Student already in the list
            $updateSuccessMessage = 'Student already added in the list.';
            $toastHeader = 'Warning';
            $toastColor = 'warning';
            $toastIcon = 'bxs-info-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }
    }



    //****************************************** OTHER PAYABLE METHODS *****************************************************/

    public function otherPayables()
    {


        $model = model(OtherPayableModel::class);

        if (auth()->user()->inGroup('admin')) {

            $list = $model->findAll();
        } else {
            helper('inflector');
            $list = $model->getStudentPayables($this->user->getStudentDetails()->year_level . ordinal($this->user->getStudentDetails()->year_level));
        }

        return view('monitoring/other-payable', [
            'list' => $list
        ]);
    }


    public function addNewPayable()
    {
        if (auth()->user()->inGroup('admin')) {
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
                $updateSuccessMessage = 'Please enter data fields.';
                $toastColor = 'warning';
                $toastHeader = 'Warning ';
                $toastIcon = 'bxs-info-circle';

                return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
            }
        } else {
            $updateSuccessMessage = 'Unauthorized Access';
            $toastHeader = 'Warning';
            $toastColor = 'warning';
            $toastIcon = 'bxs-check-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }
    }



    public function payeeList($payable_id)
    {
        helper('_status');
        $payable_model = model(OtherPayableModel::class);
        $payment_model = model(PaymentModel::class);


        $payable = $payable_model->where('payable_id', $payable_id)->first();

        $amount = $payable['amount'];
        $name = $payable['payable_name'];
        $payable_id = $payable['payable_id'];
        $payable_amount = $payable['amount'];

        $payee_model = model(PayeesModel::class);


        $payeePayments = [];

        if (auth()->user()->inGroup('admin')) {
            $payees = $payee_model->getPayeeDetails($payable_id);
            foreach ($payees as $payee) {
                $payments = $payment_model->where('user_id', $payee['user_id'])
                    ->where('payable_id', $payable_id)
                    ->findAll();

                $newBalance = 0;
                $totalPayment = 0;
                $payment_id = [];

                foreach ($payments as $payment) {
                    $totalPayment += $payment['amount'];
                    $payment_id[] = $payment['payment_id'];
                }

                $newBalance = $payable_amount - $totalPayment;

                $data = [
                    'balance' => $newBalance
                ];

                $payee_model->where('user_id', $payee['user_id'])->update($payee['user_id'], $data);

                if ($payee['balance'] == 0) {
                    $data = ['status' => 'p'];
                    $payee_model->where('user_id', $payee['user_id'])->update($payee['user_id'], $data);
                } elseif ($payee['balance'] < $payable_amount && !empty($payments)) {
                    $data = ['status' => 'c'];
                    $payee_model->where('user_id', $payee['user_id'])->update($payee['user_id'], $data);
                }

                $payeePayments[] = [
                    'payee' => $payee,
                    'payments' => $payments,
                    '$payment_id' => $payment_id
                ];
            }
        } else {
            $payee = $payee_model->getPayee(auth()->user()->id, $payable_id);
            if (empty($payee)) {
                $updateSuccessMessage = 'Student not in the list. Please notify admin.';
                $toastColor = 'warning';
                $toastHeader = 'Warning ';
                $toastIcon = 'bxs-info-circle';

                return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);

            }
            $payments = $payment_model->where('user_id', $payee['user_id'])
                ->where('payable_id', $payable_id)
                ->findAll();
            $newBalance = 0;
            $totalPayment = 0;
            

            foreach ($payments as $payment) {
                $totalPayment += $payment['amount'];
            }

            $newBalance = $payable_amount - $totalPayment;

            $data = [
                'balance' => $newBalance
            ];

            $payee_model->where('user_id', $payee['user_id'])->update($payee['user_id'], $data);

            if ($payee['balance'] == 0) {
                $data = ['status' => 'p'];
                $payee_model->where('user_id', $payee['user_id'])->update($payee['user_id'], $data);
            } elseif ($payee['balance'] < $payable_amount && !empty($payments)) {
                $data = ['status' => 'c'];
                $payee_model->where('user_id', $payee['user_id'])->update($payee['user_id'], $data);
            }


            $payeePayments[] = [
                'payee' => $payee,
                'payments' => $payments
            ];
        }


        return view('monitoring/payee-list', [
            'list' => $payeePayments,
            'amount' => $amount,
            'name' => $name,
            'payable_id' => $payable_id


        ]);

    }

    public function updatePayeeInfo($user_id, $payable_id)
    {
        if (auth()->user()->inGroup('admin')) {
            $payee_model = model(PayeesModel::class);
            $payment_model = model(PaymentModel::class);
            $email = \Config\Services::email();

            $new_status = $this->request->getPost('status');
            $payment = $this->request->getPost('payment');
            $payable_name = $this->request->getPost('payableName');


            $data = [];
            $subject = 'Payable Information Update: ' . $payable_name;
            $message = "Dear Student, \n\n"; // Initialize the message variable

            // Update payable status if provided
            if (!empty($new_status)) {
                $payee_model->where('user_id', $user_id)->set('status', $new_status)->update();
                $message .= "The status of your payable, \"$payable_name,\" has been successfully updated.";
            }

            // Handle payment processing
            if (isset($payment) && $payment !== '') {
                $data['amount'] = $payment;

                // Only set payment date if payment is greater than 0
                if ($payment > 0) {
                    $data['payment_date'] = date('Y-m-d H:i:s');
                    $data['payable_id'] = $payable_id;      // Set payable ID
                    $data['user_id'] = $user_id;            // Set user ID

                    // Insert a new payment record for the user
                    $payment_model->insert($data);

                    // Add payment details to the message
                    $message .= "\n\nA payment of PHP " . number_format($payment, 2) . " has been recorded.";
                }
            } else {
                if (empty($new_status)) {
                    $updateSuccessMessage = 'Please enter data fields.';
                    $toastColor = 'warning';
                    $toastHeader = 'Warning ';
                    $toastIcon = 'bxs-info-circle';

                    return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
                }
            }

            $payee_details = $payee_model->getPayee($user_id, $payable_id);

            if (!empty($payee_details['secret'])) {
                $student_email = $payee_details['secret'];

                // Set email parameters
                $email->setFrom('smasher.warren@gmail.com', 'College of Computer Studies Office');
                $email->setTo($student_email);
                $email->setSubject($subject);
                $email->setMessage($message);

                // Send email and handle response
                if ($email->send()) {
                    $updateSuccessMessage = 'Status updated, Email sent to student';
                } else {
                    // Print error message if email not sent
                    $errorData = $email->printDebugger(['headers']);
                    print_r($errorData);
                    exit;
                }
            }

            $toastHeader = 'Success';
            $toastColor = 'success';
            $toastIcon = 'bxs-check-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        } else {
            $updateSuccessMessage = 'Unauthorized Access';
            $toastHeader = 'Warning';
            $toastColor = 'warning';
            $toastIcon = 'bxs-check-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }
    }


    public function deleteOtherPayable()
    {
        if (auth()->user()->inGroup('admin')) {

            $other_payable_model = model(OtherPayableModel::class);

            $module_id = $this->request->getPost(index: 'moduleId');

            $other_payable_model->delete([$module_id]);


            return redirect()->to(url_to('monitoring.otherPayables'));
        } else {
            $updateSuccessMessage = 'Unauthorized Access';
            $toastHeader = 'Warning';
            $toastColor = 'warning';
            $toastIcon = 'bxs-check-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }
    }


    public function deleteStudentInPayableList($user_id, $payable_id)
    {
        if (auth()->user()->inGroup('admin')) {
            $payee_model = model(PayeesModel::class);
            $payment_model = model(PaymentModel::class);


            $updateSuccessMessage = 'Student Removed';
            $toastHeader = 'Success';
            $toastColor = 'success';
            $toastIcon = 'bxs-check-circle';


            $payee_model->delete($user_id);
            
            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        } else {
            $updateSuccessMessage = 'Unauthorized Access';
            $toastHeader = 'Warning';
            $toastColor = 'warning';
            $toastIcon = 'bxs-check-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }
    }

    public function addStudentInPayableList()
    {
        // Get POST data
        $student_id = $this->request->getPost('studentId');
        $payable_id = $this->request->getPost('payableId');

        // Load the student model
        $student_model = model(StudentDetailsModel::class);

        // Fetch student details
        $student = $student_model->getStudentsByStudentId($student_id);

        // Default success toast settings
        $updateSuccessMessage = 'Student added successfully';
        $toastHeader = 'Success';
        $toastColor = 'success';
        $toastIcon = 'bxs-check-circle';

        // Check if student exists
        if (empty($student)) {
            // Student not found - Update toast settings
            $updateSuccessMessage = 'Student not found';
            $toastColor = 'warning';
            $toastHeader = 'Warning';
            $toastIcon = 'bxs-info-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }

        // Load the payee model
        $payee_model = model(PayeesModel::class);

        // Try to insert the student into the payable list
        if ($payee_model->insertStudentInPayable($payable_id, $student->user_id)) {
            // Success: Student added
            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        } else {
            // Error: Student already in the list
            $updateSuccessMessage = 'Student already added in the list.';
            $toastHeader = 'Warning';
            $toastColor = 'warning';
            $toastIcon = 'bxs-info-circle';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }
    }



    //******************************* ANALYTICS METHODS *******************************************/

    public function viewData()
    {
        if (auth()->user()->inGroup('admin')) {

            helper('_sizes');

            $student_model = model(ModuleStudentsModel::class);
            $module_model = model(ModulesModel::class);
            $uniform_model = model(UniformsModel::class);
            $other_payable_model = model(OtherPayableModel::class);
            $payee_model = model(PayeesModel::class);

            $modules = $module_model->getModuleDetails();
            $uniforms = $uniform_model->listStudentUniform();
            $other_payables = $other_payable_model->findAll();



            $module_items = [];

            foreach ($modules as $module) {
                $module_paid = 0;
                $module_claimed = 0;
                $module_incomplete = 0;
                $module_total_students = 0;
                $module_no_record = 0;

                $students = $student_model->where('module_id', $module['module_id'])->select('status')->findAll();

                foreach ($students as $student) {
                    $module_total_students++;
                    if ($student['status'] === 'p') {
                        $module_paid++;
                        $module_claimed++;
                    } elseif ($student['status'] === 'c') {
                        $module_claimed++;
                        $module_incomplete++;
                    } else {
                        $module_no_record++;
                    }

                }
                $combined = array_merge($module, [
                    'module_total_students' => $module_total_students,
                    'module_paid' => $module_paid,
                    'module_claimed' => $module_claimed,
                    'module_incomplete' => $module_incomplete,
                    'module_no_record' => $module_no_record
                ]);

                // Add the combined array to the final list of items
                $module_items[] = $combined;
            }


            // Initialize the data array to store all variables
            $uniform_data = [
                'uniform_total_students' => 0,
                'uniform_paid' => 0,
                'uniform_claimed' => 0,
                'uniform_incomplete' => 0,
                'uniform_no_record' => 0,

                'xSmallPants' => 0,
                'smallPants' => 0,
                'mediumPants' => 0,
                'largePants' => 0,
                'xLargePants' => 0,
                'noRecordPants' => 0,

                'xSmallPolo' => 0,
                'smallPolo' => 0,
                'mediumPolo' => 0,
                'largePolo' => 0,
                'xLargePolo' => 0,
                'noRecordPolo' => 0,

                'xSmallBlouse' => 0,
                'smallBlouse' => 0,
                'mediumBlouse' => 0,
                'largeBlouse' => 0,
                'xLargeBlouse' => 0,
                'noRecordBlouse' => 0,
            ];

            foreach ($uniforms as $uniform) {
                // Increment total students count
                $uniform_data['uniform_total_students']++;

                // Count pants sizes
                switch ($uniform['pants_size']) {
                    case 'xs':
                        $uniform_data['xSmallPants']++;
                        break;
                    case 's':
                        $uniform_data['smallPants']++;
                        break;
                    case 'm':
                        $uniform_data['mediumPants']++;
                        break;
                    case 'l':
                        $uniform_data['largePants']++;
                        break;
                    case 'xl':
                        $uniform_data['xLargePants']++;
                        break;
                    default:
                        $uniform_data['noRecordPants']++;
                        break;
                }

                // Count shirt/blouse sizes based on gender
                if ($uniform['gender'] === 'M') {
                    switch ($uniform['shirt_size']) {
                        case 'xs':
                            $uniform_data['xSmallPolo']++;
                            break;
                        case 's':
                            $uniform_data['smallPolo']++;
                            break;
                        case 'm':
                            $uniform_data['mediumPolo']++;
                            break;
                        case 'l':
                            $uniform_data['largePolo']++;
                            break;
                        case 'xl':
                            $uniform_data['xLargePolo']++;
                            break;
                        default:
                            $uniform_data['noRecordPolo']++;
                            break;
                    }
                } else {
                    switch ($uniform['shirt_size']) {
                        case 'xs':
                            $uniform_data['xSmallBlouse']++;
                            break;
                        case 's':
                            $uniform_data['smallBlouse']++;
                            break;
                        case 'm':
                            $uniform_data['mediumBlouse']++;
                            break;
                        case 'l':
                            $uniform_data['largeBlouse']++;
                            break;
                        case 'xl':
                            $uniform_data['xLargeBlouse']++;
                            break;
                        default:
                            $uniform_data['noRecordBlouse']++;
                            break;
                    }
                }

                // Count uniform status
                if ($uniform['status'] === 'p') {
                    $uniform_data['uniform_paid']++;
                    $uniform_data['uniform_claimed']++;
                } elseif ($uniform['status'] === 'c') {
                    $uniform_data['uniform_claimed']++;
                    $uniform_data['uniform_incomplete']++;
                } else {
                    $uniform_data['uniform_no_record']++;
                }
            }


            $other_payable_data = [];

            foreach ($other_payables as $payable) {
                $payable_paid = 0;
                $payable_claimed = 0;
                $payable_incomplete = 0;
                $payable_total_students = 0;
                $payable_no_record = 0;

                $payees = $payee_model->where('payable_id', $payable['payable_id'])->select('status')->findAll();

                foreach ($payees as $payee) {
                    $payable_total_students++;
                    if ($payee['status'] === 'p') {
                        $payable_paid++;
                        $payable_claimed++;
                    } elseif ($payee['status'] === 'c') {
                        $payable_claimed++;
                        $payable_incomplete++;
                    } else {
                        $payable_no_record++;
                    }

                }
                $combined = array_merge($payable, [
                    'payable_total_students' => $payable_total_students,
                    'payable_paid' => $payable_paid,
                    'payable_claimed' => $payable_claimed,
                    'payable_incomplete' => $payable_incomplete,
                    'payable_no_record' => $payable_no_record
                ]);

                // Add the combined array to the final list of items
                $other_payable_data[] = $combined;
            }



            return view('monitoring/analytics', [
                'modules' => $module_items,
                'uniforms' => $uniform_data,
                'other_payables' => $other_payable_data
            ]);
        }
    }


}