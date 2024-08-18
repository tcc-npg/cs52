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

        $update_successful_message = null;

        if ($validation->withRequest($this->request)->run()) {
            $userDetailsModel = model(UserDetailsModel::class);

            $userDetails = new UserDetailsEntity();
            $userDetails->fill($validation->getValidated());
            $userDetails->user_id = $userId;

            if (!$this->request->getPost('user_type')) {
                $userDetails->user_type = STUDENT;
            }

            $userDetailsModel->save($userDetails);
            $update_successful_message = 'Your profile details has been successfully updated!';
        }

        return $redirect->withInput()->with('update_successful', $update_successful_message);
    }
}
