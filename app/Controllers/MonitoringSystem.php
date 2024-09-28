<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MonitoringSystem\ModulesModel;
use App\Models\MonitoringSystem\ModuleStudentsModel;
use App\Models\MonitoringSystem\OtherPayableModel;
use App\Models\MonitoringSystem\UniformsModel;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class MonitoringSystem extends BaseController
{
    public function uniform()
    {
        $model = model(UniformsModel::class);

        $data = $model->listStudentUniform();

        return view('monitoring/uniform', [
            'list' => $data

        ]);
    }


    public function modules(){
        
        $model = model(ModulesModel::class);

        $list = $model->findAll();

        foreach ($list as $key) {
            $data = $model->getModuleDetails($key['code']); 
        }

        return view('monitoring/modules', [
            'list' => $data
            ]);
    }


    public function studentsList(int|string $module_id, $name): string{

        $module = model(ModuleStudentsModel::class);

        $list = $module->getStudentList($module_id);

        return view('monitoring/student-list', [
            'module_list' => $list,
            'name' => $name

        ]);
  
    }


    public function otherPayables(){

        $model = model(OtherPayableModel::class);

        $data = $model->findAll();

        foreach ($data as $key) {
            $list = $model->getPayableDetails($key['payable_id']);
        }
    

        return view('monitoring/other-payable', [
            'list'=> $list
        ]);
    }
    
    public function payeeList(){

        $model = model(OtherPayableModel::class);

        $data = $model->findAll();

        foreach ($data as $key) {
            $list = $model->getPayableDetails($key['payable_id']);
            $name = $key['payable_name'];
        }

        return view('monitoring/payee-list', [
            'list'=> $list,
            'name' => $name
        ]);
    }
    



    public function addStudentInUniform(){
        
        $model = model(UniformsModel::class);   

        $data = $model->listStudentUniform();


        return redirect()->to('monitoring.uniform');

        
    }

    public function viewData(int|string $module_id){

        $module = model(ModuleStudentsModel::class);

        $data = $module->getStudentList($module_id);
        
        return view ('monitoring/analytics', [
            'module_details' => $data
            
        ]);
    }

    
}


