<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class UniformsModel extends Model
{
    protected $table            = 'ms_uniforms';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'user_id'
    ];


    public function listStudentUniform(){
        return $this->select('b.first_name, b.last_name, c.student_number, b.gender, 
        ms_uniforms.shirt_size, ms_uniforms.pants_size, ms_uniforms.balance, ms_uniforms.status, ms_uniforms.id')
            ->join('user_details b', 'ms_uniforms.user_id = b.user_id')
            ->join('student_details c', 'ms_uniforms.user_id = c.user_id')
            ->findAll();
    
    }

    public function updateStudentInformation($id, $data){
        return $this->update($id , $data);
    }



 
}
