<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected $returnType = UserEntity::class;
    protected $afterFind = ['fetchIdentities', 'getUserInfo'];

    protected function getUserInfo(array $data): array
    {
        if (!isset($data['id'])) {
            return $data;
        }
        /** @var UserDetailsModel $userInfoModel */
        $userInfoModel = model(UserDetailsModel::class);

        $data['data']->setUserDetails($userInfoModel->getUserDetails($data['id']));

        return $data;
    }
}
