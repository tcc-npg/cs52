<?php

namespace App\Controllers;

use App\Entities\StudentDetailsEntity;
use App\Entities\UserDetailsEntity;
use App\Models\IrregStudentSubjectsModel;
use App\Models\SettingsModel;
use App\Models\StudentCurriculumModel;
use App\Models\StudentDetailsModel;
use App\Models\UserDetailsModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Validation\Validation;
use ReflectionException;

class UserController extends BaseController
{
    protected $helpers = ['form', '_url'];

    public function index(int $id = null): string
    {
        helper('_toast');
        $studentDetails = null;

        if (is_null($id)) {
            $user = $this->user;
            $isStudent = $user->inGroup('student');
            if ($isStudent) {
                $studentDetails = $user->getStudentDetails();
            }
            $userDetails = $user->getUserDetails();
        } else {
            $user = auth()->getProvider()->findById($id);
            $isStudent = $user->inGroup('student');
            if ($isStudent) {
                $studentDetails = $user->getStudentDetails();
            }
            $userDetails = $user->getUserDetails();
        }

        return view('user/profile', [
            'userDetails' => $userDetails,
            'studentDetails' => $studentDetails,
            'user' => $user,
            'userId' => $user->id,
            'belongsToStudentGroup' => $isStudent ? 'true' : 'false',
            'isProfileComplete' => $user->isProfileComplete()
        ]);
    }

    public function subjectsEnrolled(): string
    {
        $studentDetails = $this->user->getStudentDetails();
        $isEnrolled = $studentDetails->is_enrolled;

        if ($isEnrolled) {
            $model = !$studentDetails->is_irreg ? model(StudentCurriculumModel::class) : model(IrregStudentSubjectsModel::class);
            $settingsModel = model(SettingsModel::class);
            $subjects = $model->getEnrolledSubjects(
                $this->user->getStudentDetails(),
                $settingsModel->findByKey('current_curriculum')->value,
                $settingsModel->findByKey('current_semester')->value
            );
        }

        $view = 'user/student/subjects-enrolled';

        if (!$isEnrolled) {
            $view = 'user/student/not-enrolled';
        }

        $data = [
            'pageTitle' => 'Subjects Enrolled'
        ];

        return view($view, $isEnrolled ? [
            ...$data,
            'subjects' => $subjects,
        ] : $data);
    }

    /**
     * @throws ReflectionException
     */
    public function update(int $userId): RedirectResponse
    {
        /** @var Validation $validation */
        $validation = service('validation');
        $isStudent = $this->request->getVar('is_student') ?? false;
        $fromList = $this->request->getVar('from_list') ?? false;
        $studentDetailsValidatedData = [];
        $studentDetailsModel = [];
        $toastIcon = 'bxs-info-circle';

        if ($fromList) {
            $user = auth()->getProvider()->findById($userId);
        } else {
            $user = $this->user;
        }

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
            $updateSuccessMessage = 'Fail to update profile.';
            $toastColor = 'warning';
            $toastHeader = 'Unsuccessful';
            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
        }

        // if no errors found, fill the entities with their corresponding validated data
        $studentDetails = null;
        $userDetails = $user->getUserDetails() ?? new UserDetailsEntity();
        $userDetails->fill($userDetailsValidatedData);
        if ($isStudent) {
            $studentDetails = $user->getStudentDetails() ?? new StudentDetailsEntity();
            $studentDetails->fill($studentDetailsValidatedData);
        }

        // check if the initial values of the entity properties have changed after filling
        // them out with the validated data. if no changes, return with info alert
        if ((!$userDetails->hasChanged() && ($isStudent && !$studentDetails->hasChanged())) || (!$userDetails->hasChanged() && !$isStudent)) {
            // if no changes, set the message to no changes
            $updateSuccessMessage = 'No changes were made.';
            $toastColor = 'info';
            $toastHeader = 'Info';

            return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
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
            $updateSuccessMessage = 'Profile details has been successfully updated!';
            $toastHeader = 'Success';
            $toastColor = 'success';
            $toastIcon = 'bxs-check-circle';
        } else { // if none
            $updateSuccessMessage = 'An error was encountered while saving profile details.';
            $toastHeader = 'Error';
            $toastColor = 'danger';
            $toastIcon = 'bxs-x-circle';
        }

        return redirectBackWithToast($updateSuccessMessage, $toastColor, $toastHeader, $toastIcon);
    }

    private function validateDetails(Validation $validation, string $ruleGroup): array
    {
        $validation->setRuleGroup($ruleGroup);
        $isValid = $validation->withRequest($this->request)->run();
        return $isValid ? $validation->getValidated() : [];
    }
}
