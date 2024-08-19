<?php

namespace App\Controllers;

use App\Entities\UserDetailsEntity;
use App\Models\UserDetailsModel;
use CodeIgniter\HTTP\RedirectResponse;
use ReflectionException;

class ProfileController extends BaseController
{
    protected $helpers = ['form'];

    public function index(): string
    {
        $userDetails = $this->user->getUserDetails();

        return view('user/profile', [
            'userDetails' => $userDetails,
            'userId' => $this->user->id,
            'profileIsComplete' => $userDetails->isProfileComplete()
        ]);
    }

    /**
     * @throws ReflectionException
     */
    public function update(int $userId): RedirectResponse
    {
        $validation = service('validation');

        $validation->setRuleGroup('studentProfileDetailsRule');

        $redirect = redirect()->back();

        $updateSuccessMessage = null;
        $toastColor = 'info';

        if ($validation->withRequest($this->request)->run()) {
            $userDetailsModel = model(UserDetailsModel::class);

            $userDetails = new UserDetailsEntity();
            $userDetails->fill($validation->getValidated());

            $updateSuccessMessage = 'No changes were made.';
            if (!$this->checkIfUserDetailsHasChanges($userDetails)) {
                $userDetails->user_id = $userId;

                if (!$this->request->getPost('user_type')) {
                    $userDetails->user_type = STUDENT;
                }
                $userDetailsModel->save($userDetails);
                $updateSuccessMessage = 'Your profile details has been successfully updated!';
                $toastColor = 'success';
            }
        }

        return $redirect->withInput()
            ->with('update_successful', $updateSuccessMessage)
            ->with('toast_color', $toastColor);
    }

    // TODO convert to helper method
    private function checkIfUserDetailsHasChanges(UserDetailsEntity $userDetails): bool
    {
        $userDetailsOrig = $this->user->getUserDetails()->toArray();
        $keys = array_keys($userDetailsOrig);
        for ($i = 0; $i < count($userDetailsOrig); $i++) {
            if (!in_array($keys[$i], ['user_id', 'created_at', 'updated_at', 'user_type'])) {
                if ($userDetailsOrig[$keys[$i]] != $userDetails->{$keys[$i]}) return false;
            }
        }
        return true;
    }
}
