<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class UniformsModel extends Model
{
    protected $table = 'ms_uniforms';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',  
        'amount',
        'shirt_size',
        'pants_size',
        'status',
        'balance'

    ];


    public function listStudentUniform()
    {
        return $this->select('b.first_name, b.last_name, c.student_number, b.gender, c.user_id,
        ms_uniforms.shirt_size, ms_uniforms.pants_size,ms_uniforms.status, ms_uniforms.id, ms_uniforms.amount, ms_uniforms.balance')
            ->join('user_details b', 'ms_uniforms.user_id = b.user_id')
            ->join('student_details c', 'ms_uniforms.user_id = c.user_id')
            ->findAll();

    }

    public function listStudentUniformInfo($user_id){
        return $this->select('b.first_name, b.last_name, c.student_number, b.gender, c.user_id,
        ms_uniforms.shirt_size, ms_uniforms.pants_size,ms_uniforms.status, ms_uniforms.id, ms_uniforms.amount, ms_uniforms.balance,')
            ->join('user_details b', 'ms_uniforms.user_id = b.user_id')
            ->join('student_details c', 'ms_uniforms.user_id = c.user_id')
            ->where('ms_uniforms.user_id', $user_id)
            ->first();
    }
    public function updateStudentInformation($id, $data)
    {
        return $this->db->table($this->table)  // or 'ms_uniforms'
            ->where('id', $id)     // Use the $id parameter passed to the method
            ->update($data);       // Pass the data array for updating
    }

    

}





