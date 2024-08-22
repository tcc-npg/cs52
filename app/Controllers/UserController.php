<?php

namespace App\Controllers;

use App\Entities\StudentDetailsEntity;
use App\Entities\UserDetailsEntity;
use App\Models\SettingsModel;
use App\Models\StudentDetailsModel;
use App\Models\SubjectModel;
use App\Models\UserDetailsModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Validation\Validation;
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
            'belongsToStudentGroup' => $this->user->inGroup('student') ? 'true' : 'false',
            'isProfileComplete' => $this->user->isProfileComplete()
        ]);
    }

    public function subjectsEnrolled(): string
    {
        $subjectsModel = model(SubjectModel::class);
        $settingsModel = model(SettingsModel::class);
        $subjects = $subjectsModel->getSubjectsForYearAndSemester($this->user->getStudentDetails()->year_level, $settingsModel->findByKey('current_sem')->value);
        return view('user/student/subjects-enrolled.php', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function update(int $userId): RedirectResponse
    {
        /** @var Validation $validation */
        $validation = service('validation');
        $redirect = redirect()->back();
        $isStudent = $this->request->getVar('is_student');
        $studentDetailsValidatedData = [];
        $studentDetailsModel = [];
        $toastIcon = 'bxs-info-circle';

        // validate user details
        $userDetailsValidatedData = $this->validateDetails($validation, 'userDetailsRules');
        $userDetailsModel = model(UserDetailsModel::class);

        // if student, validate as well and then load the model
        if ($isStudent) {
            $studentDetailsValidatedData = $this->validateDetails($validation, 'studentDetailsRules');
            $studentDetailsModel = model(StudentDetailsModel::class);
        }

        // if the validation fails for either checking, redirect back with error
        if (!$userDetailsValidatedData || ($isStudent && !$studentDetailsValidatedData)) {
            $updateSuccessMessage = 'Cannot update your profile.';
            $toastColor = 'warning';
            $toastHeader = 'Unsuccessful';
            return $redirect->withInput()
                ->with('update_successful', $updateSuccessMessage)
                ->with('toast_color', $toastColor)
                ->with('toast_icon', $toastIcon)
                ->with('toast_header', $toastHeader);
        }

        // if no errors found, fill the entities with their corresponding validated data
        $studentDetails = null;
        $userDetails = $this->user->getUserDetails() ?? new UserDetailsEntity();
        $userDetails->fill($userDetailsValidatedData);
        if ($isStudent) {
            $studentDetails = $this->user->getStudentDetails() ?? new StudentDetailsEntity();
            $studentDetails->fill($studentDetailsValidatedData);
        }

        // check if the initial values of the entity properties have changed after filling
        // them out with the validated data. if no changes, return with info alert
        if (!$userDetails->hasChanged() && ($isStudent && !$studentDetails->hasChanged())) {
            // if no changes, set the message to no changes
            $updateSuccessMessage = 'No changes were made.';
            $toastColor = 'info';
            $toastHeader = 'Info';

            return $redirect->withInput()
                ->with('update_successful', $updateSuccessMessage)
                ->with('toast_color', $toastColor)
                ->with('toast_icon', $toastIcon)
                ->with('toast_header', $toastHeader);
        }

        // else, save

        // if user details has changes, save
        $userDetailsSaved = false;
        $studentDetailsSaved = false;
        if ($userDetails->hasChanged()) {
            $userDetails->user_id = $userId;
            $userDetailsSaved = $userDetailsModel->save($userDetails);
        }

        // if student and has changes, save
        if ($isStudent && $studentDetails->hasChanged()) {
            $studentDetails->user_id = $userId;
            $studentDetailsSaved = $studentDetailsModel->save($studentDetails);
        }

        // if either one of them were successfully saved
        if ($userDetailsSaved || ($isStudent && $studentDetailsSaved)) {
            $updateSuccessMessage = 'Your profile details has been successfully updated!';
            $toastHeader = 'Success';
            $toastColor = 'success';
            $toastIcon = 'bxs-check-circle';
        } else { // if none
            $updateSuccessMessage = 'An error was encountered while updating your profile details.';
            $toastHeader = 'Error';
            $toastColor = 'danger';
            $toastIcon = 'bxs-x-circle';
        }

        return $redirect->withInput()
            ->with('update_successful', $updateSuccessMessage)
            ->with('toast_color', $toastColor)
            ->with('toast_icon', $toastIcon)
            ->with('toast_header', $toastHeader);
    }

    private function validateDetails(Validation $validation, string $ruleGroup): array
    {
        $validation->setRuleGroup($ruleGroup);
        $isValid = $validation->withRequest($this->request)->run();
        return $isValid ? $validation->getValidated() : [];
    }
}
