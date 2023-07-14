<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Models\employee_service;

use App\Models\Service;
use Exception;
use Illuminate\Support\Facades\DB;

class userTechnicianRepository{
    public function getUserTen(){      
        //return Service::get();
        // $services = Employee::select('employees.id',
        // DB::raw('CONCAT(employees.names," ",employees.last_names) names'))
        // ->join('users','employees.id','users.id')
        // ->where('users.active',1)->where('employees.role_id',4)
        // ->get();
        $services = Employee::select('employees.id',
         DB::raw('CONCAT(employees.names," ",employees.last_names) names'), DB::raw('GROUP_CONCAT(services.name) services'))
         ->leftjoin('users','employees.user_id','users.id')
         ->leftjoin('employee_service','employees.id','employee_service.employee_id')
         ->leftjoin('services','services.id','employee_service.service_id')
         ->where('users.active',1)->where('employees.role_id',4)->groupBy('employees.id',DB::raw('CONCAT(employees.names," ",employees.last_names)'))
         ->get();
        
    return $services;

    }


    

    public function setServices($id,$services)
    {
      

            employee_service::where('employee_id',$id)->delete();
       
            foreach ($services as &$value) {
                $model =  employee_service::firstOrCreate([
                    'employee_id' => $id,
                    'service_id' => $value
                ]);

            }
            $model->save();


       
    }

    public function update($id)
    {
        try {

            $model =  Service::find($id);

            if ($model->active == 1)
            $model->active = 0;
                else 
            $model->active = 1;

            $model->save();
        } catch (\Throwable $th) {
                       return redirect()->back() ->with('error',  $th->getMessage());

        }
    }

    


    public function getServicesByIdEmployee($id){
        //return Service::get();
        try {
        $services = Employee::select('services.id')
       // DB::raw('CONCAT(employees.names," ",employees.last_names) names'))
        ->leftjoin('users','employees.user_id','users.id')
        ->leftjoin('employee_service','employees.id','employee_service.employee_id')
        ->leftjoin('services','services.id','employee_service.service_id')
        ->where('users.active',1)->where('employees.id',$id)
        ->get();
        

} catch (\Throwable $th) {
    return redirect()->back() ->with('error',  $th->getMessage());

}

return $services;


    }
    
    public function create($description, $nombre)
    {
        try {

            if ($description == null) {
                throw new Exception('Debe especificar una descripcion.', 1);
            }

            if ($nombre == null) {
                throw new Exception('Debe especificar un nombre.', 1);
            }

            $model = new Service([
                'description' => $description,
                'name' => $nombre

            ]);

            $model->save();

        } catch (\Throwable $th) {
                       return redirect()->back() ->with('error',  $th->getMessage());

        }
    }


}
