<?php

declare(strict_types=1);

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected $returnType = UserEntity::class;
    protected $afterFind = ['fetchIdentities', 'getUserDetails', 'getStudentDetails'];

    protected function getStudentDetails(array $data): array
    {
        $userIds = $this->extractUserIds($data);

        if ($userIds === []) {
            return $data;
        }

        if ($data['data']->user_type !== STUDENT) {
            return $data;
        }

        /** @var StudentDetailsModel $studentDetailsModel */
        $studentDetailsModel = model(StudentDetailsModel::class);

        $studentDetailsArray = $studentDetailsModel->getStudentDetailsByUserIds($userIds);

        if (empty($studentDetailsArray)) {
            return $data;
        }

        $mappedUsers = $this->assignDetails($data, $studentDetailsArray, 'studentDetails');

        $data['data'] = $data['singleton'] ? $mappedUsers[$data['id']] : $mappedUsers;

        return $data;
    }

    protected function getUserDetails(array $data): array
    {
        $userIds = $this->extractUserIds($data);

        if ($userIds === []) {
            return $data;
        }

        /** @var UserDetailsModel $userDetailsModel */
        $userDetailsModel = model(UserDetailsModel::class);

        $userDetailsArray = $userDetailsModel->getUserDetailsByUserIds($userIds);

        if (empty($userDetailsArray)) {
            return $data;
        }

        $mappedUsers = $this->assignDetails($data, $userDetailsArray, 'userDetails');

        $data['data'] = $data['singleton'] ? $mappedUsers[$data['id']] : $mappedUsers;

        return $data;
    }

    private function assignDetails(array $data, array $detailsArrayParam, string $property): array
    {
        helper('inflector');
        $mappedUsers = [];
        $detailsArray = [];

        $users = $data['singleton'] ? [$data['data']] : $data['data'];

        foreach ($users as $user) {
            $mappedUsers[$user->id] = $user;
        }
        unset($users);

        foreach ($detailsArrayParam as $details) {
            $detailsArray[$details->user_id] = $details;
        }
        unset($detailsArrayParam);

        foreach ($detailsArray as $userId => $value) {
            $setter = 'set' . ucfirst(camelize($property));
            $mappedUsers[$userId]->$setter($value);
        }
        unset($detailsArray);

        return $mappedUsers;
    }

    private function extractUserIds(array $data): array
    {
        return $data['singleton']
            ? array_column($data, 'id')
            : array_column($data['data'], 'id');
    }
}
