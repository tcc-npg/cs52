<?php

namespace App\Controllers;

use App\Entities\StudentDetailsEntity;
use App\Entities\UserDetailsEntity;
use App\Models\StudentDetailsModel;
use App\Models\SubjectModel;
use App\Models\UserDetailsModel;
use CodeIgniter\HTTP\RedirectResponse;
use ReflectionException;

class UserController extends BaseController
{
    protected $helpers = ['form'];

    public function index(): string
    {
        helper('_toast');
        $studentDetails = null;
        if ($this->user->inGroup('student')) {
            $studentDetails = $this->user->getStudentDetails();
        }
        return view('user/profile', [
            'userDetails' => $this->user->getUserDetails(),
            'studentDetails' => $studentDetails,
            'userId' => $this->user->id,
            'isProfileComplete' => $this->user->isProfileComplete()
        ]);
    }

    public function subjectsEnrolled(): string
    {
        $subjectsModel = model(SubjectModel::class);
        $subjects = $subjectsModel->getSubjectsForYearAndSemester($this->user->getStudentDetails()->year_level, 1);
        return view('user/student/subjects-enrolled.php', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function update(int $userId): RedirectResponse
    {
        $validation = service('validation');

        $redirect = redirect()->back();

        $validation->setRuleGroup('userDetailsRules');
        $validation1 = $validation->withRequest($this->request)->run();
        $validated1 = $validation->getValidated();

        $validation->setRuleGroup('studentDetailsRules');
        $validation2 = $validation->withRequest($this->request)->run();
        $validated2 = $validation->getValidated();

        $updateSuccessMessage = 'No changes were made.';
        $toastColor = 'info';
        $toastIcon = 'bxs-info-circle';
        $toastHeader = 'Info';

        if ($validation2 && $validation1) {
            $userDetailsModel = model(UserDetailsModel::class);
            $studentDetailsModel = model(StudentDetailsModel::class);

            $userDetails = new UserDetailsEntity();
            $userDetails = $userDetails->fill($validated1);
            $userDetails->user_id = $userId;

            $studentDetails = new StudentDetailsEntity();
            $studentDetails = $studentDetails->fill($validated2);
            $studentDetails->user_id = $userId;

            if (!$this->user->isProfileComplete() ||
                (
                    $this->userDetailsHasChanges($validated1, $this->user->getUserDetails()->toArray())
                    ||
                    $this->userDetailsHasChanges($validated2, $this->user->getStudentDetails()->toArray())
                )
            ) {
                $userDetailsSaved = $userDetailsModel->save($userDetails);
                $studentDetailsSaved = $studentDetailsModel->save($studentDetails);
                if ($userDetailsSaved && $studentDetailsSaved) {
                    $updateSuccessMessage = 'Your profile details has been successfully updated!';
                    $toastHeader = 'Success';
                    $toastColor = 'success';
                    $toastIcon = 'bxs-check-circle';
                } else {
                    $updateSuccessMessage = 'An error was encountered while updating your profile details.';
                    $toastHeader = 'Error';
                    $toastColor = 'danger';
                    $toastIcon = 'bxs-x-circle';
                }
            }
        }

        return $redirect->withInput()
            ->with('update_successful', $updateSuccessMessage)
            ->with('toast_color', $toastColor)
            ->with('toast_icon', $toastIcon)
            ->with('toast_header', $toastHeader);
    }

    // TODO convert to helper method
    private function userDetailsHasChanges(array $array1, array $array2): bool
    {
        $keys = array_keys($array1);
        for ($i = 0; $i < count($array1); $i++) {
            if (!in_array($keys[$i], ['user_id', 'created_at', 'updated_at'])) {
                if ($array1[$keys[$i]] !== $array2[$keys[$i]]) {
                    return true;
                }
            }
        }
        return false;
    }
}
