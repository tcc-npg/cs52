<?php

namespace App\Models;

use App\Entities\StudentDetailsEntity;
use App\Entities\UserDetailsEntity;
use CodeIgniter\Model;
use Exception;
use ReflectionException;

class UserDetailsModel extends Model
{
    protected $table = 'user_details';
    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = false;

    protected $returnType = UserDetailsEntity::class;

    protected $allowedFields = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'phone_number',
        'address',
        'user_type',
        'updated_at'
    ];

    protected $beforeInsert = ['saveStudentDetails'];
    protected $beforeUpdate = ['saveStudentDetails'];

    private UserDetailsEntity $tempUserDetails;

    public function getUserDetails(int $id): object|array|null
    {
        return $this
            ->select(
                'user_details.*,
                student_details.student_number,
                student_details.year_level,
                student_details.program_code'
            )
            ->where('user_details.user_id', $id)
            ->join('student_details', 'student_details.user_id = user_details.user_id', 'left')
            ->first();
    }

    public function insert($row = null, bool $returnID = true): bool|int|string
    {
        $this->tempUserDetails = clone $row;

        $result = parent::insert($row, $returnID);

        return $returnID ? $this->insertID : $result;
    }

    public function update($id = null, $row = null): bool
    {
        $this->tempUserDetails = clone $row;

        $row->updated_at = date('Y-m-d H:i:s');

        return parent::update($id, $row);
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    protected function saveStudentDetails(array $data): array
    {
        $studentDetails = new StudentDetailsEntity();
        $studentDetails->fill([
            'user_id' => $this->tempUserDetails->user_id,
            'student_number' => $this->tempUserDetails->student_number,
            'year_level' => $this->tempUserDetails->year_level,
            'program_code' => $this->tempUserDetails->program_code,
        ]);

        $studentDetailsModel = model(StudentDetailsModel::class);

        if (!$studentDetailsModel->find($studentDetails->user_id)) {
            $studentDetailsModel->insert($studentDetails);
        } else {
            $studentDetails->updated_at = date('Y-m-d H:i:s');
            $studentDetailsModel->save($studentDetails);
        }

        return $data;
    }
}
