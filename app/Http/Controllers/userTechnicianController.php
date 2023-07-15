<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\setServicesEmpl;

use App\Http\Requests\ServicesEmpl;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterServicesRequest;
use App\Repositories\userTechnicianRepository;

class userTechnicianController extends Controller
{

    protected $userTechnicianRepository;

    public function __construct(
        userTechnicianRepository $userTechnicianRepository,
    ) 
    
    {
        $this->userTechnicianRepository = $userTechnicianRepository;
    }
    


    public function index(){
        return view('employees.userTechnician');
    }


    

    
    public function setServices (ServicesEmpl $request){    
        try {            
            $id = $request->input('EmpId');
            $services = $request->input('slcServices');


            $resp=$this->userTechnicianRepository->setServices($id, $services);      

         //   echo json_encode(['$services ' => $services , '$id ' =>  $id  ]);

           // return redirect('userTechnician')->with('success', 'success');
           echo json_encode(['type' => 'success','message' => 'Cambios aplicados correctamente!']);

        } catch (\Throwable $th) {
            echo json_encode(['type' => 'error','message' => $th->getMessage()]);

            //throw $th;
        }    


    }

    public function getServicesByIdEmployee (ServicesEmpl  $request){    
        try {            
            $IdEmployee = $request->input('IdEmployee');

            $data=$this->userTechnicianRepository->getServicesByIdEmployee($IdEmployee);
           // echo json_encode( $IdEmployee);

           echo json_encode($data);

            
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }    
    }

    public function store (RegisterServicesRequest $request){    
        try {            
            $description = $request->input('descripcion');
            $nombre = $request->input('nombre');


            $this->userTechnicianRepository->create($description, $nombre);
            

            return redirect('services');
            
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }    
    }
      
    public function update ($id){    
        try {            

            $this->userTechnicianRepository->update($id);
           
            return redirect('services');


        } catch (\Throwable $th) {          
            var_dump($th);
            //throw $th;
        }    
    } 

    public function getServices()
    {
        $userTechnicianRepository = $this->userTechnicianRepository
            ->getUserTen();

        echo json_encode($userTechnicianRepository);
    }


  
}
