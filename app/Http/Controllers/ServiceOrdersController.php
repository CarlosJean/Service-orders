<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignTechnicianToOrderRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\DisapproveServiceOrderRequest;
use App\Models\Order;
use App\Repositories\EmployeeRepository;
use App\Repositories\OrdersRepository;
use App\Repositories\ServicesRepository;
use Illuminate\Http\Request;

class ServiceOrdersController extends Controller
{

    protected $employeeRepository;
    protected $ordersRepository;
    protected $servicesRepository;

    public function __construct(
        EmployeeRepository $employeeRepository, 
        OrdersRepository $ordersRepository,
        ServicesRepository $servicesRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->ordersRepository = $ordersRepository;
        $this->servicesRepository = $servicesRepository;
    }

    public function index(){
        
        return view('orders.index');
    }

    public function create()
    {
        if (auth()->guest()) return redirect('login');

        $userId = auth()->user()->id;

        $orderNumber = $this->ordersRepository->orderNumber();

        $employee = $this->employeeRepository->employeeByUserId($userId);
        $departmentId =  $employee['department']->id;
        $roleId =  $employee['role']->id;

        return view('orders.create', [
            'orderNumber' => $orderNumber,
            'departmentId' => $departmentId,
            'roleId' => $roleId,
        ]);
    }

    public function store(CreateOrderRequest $request)
    {
        try {
            $issue = $request->input('issue');
            $orderNumber = $request->input('order_number');
    
            $this->ordersRepository->createOrder($issue, $orderNumber);
    
            return view('orders.created')->with('orderNumber', $orderNumber);
        } catch (\Throwable $th) {
            //throw $th;

            if ($th->getCode() == 1) {
                return back()->withErrors(['error' => $th->getMessage()]);
            }
        }
    }

    public function getOrders(){
        $userId = auth()->id();
        $serviceOrders = $this->ordersRepository->serviceOrdersByUserId($userId);
        return $serviceOrders;
    }

    public function assignTechnicianCreate($orderNumber){

        try {
            $serviceOrder = $this->ordersRepository->serviceOrderByNumber($orderNumber);
            return view('orders.assign_technician')->with('order',$serviceOrder);
        } catch (\Throwable $th) {
            //throw $th;
            var_dump($th);
        }
    }

    public function getServices() {
        return $this->servicesRepository->services();
    }

    public function getEmployeesByService($idService){
        return $this->employeeRepository->employeesByService($idService);
    }

    public function assignTechnicianUpdate(AssignTechnicianToOrderRequest $request){    
        try {            
            $serviceOrderNumber  = $request->input('order_number');
            $technicianId = $request->input('technician_id');


            $this->ordersRepository->assignTechnician($serviceOrderNumber, $technicianId);

            $employee = $this->employeeRepository->employeeByUserId($technicianId);
            $technician = $employee['names'].' '.$employee['last_names'];
            
            return view('orders.assigned_technician')
                ->with([
                    'orderNumber' => $serviceOrderNumber,
                    'technician' => $technician,
                ]);
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }    
    }   

    public function disapproveUpdate(DisapproveServiceOrderRequest $request){
        try {
            $serviceOrderNumber  = $request->input('order_number');
            $observations = $request->input('observations');          
            
            $this->ordersRepository->disapprove($serviceOrderNumber, $observations);
            
            return view('orders.disaproved')
                ->with([
                    'orderNumber' => $serviceOrderNumber,
                ]);
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }


    public function show($orderNumber){
        $userId = auth()->id();
        $employee = $this->employeeRepository
            ->employeeByUserId($userId);

        $roleId = $employee['role']->id;
        $departmentId = $employee['department']->id;
        
        $userRole = '';
        if($departmentId = 2 && $roleId == 2 ){
            $userRole = 'maintenanceSupervisor';
        }else if($departmentId = 2 && $roleId == 3 ){
            $userRole = 'technician';
        }

        $serviceOrder = $this->ordersRepository->serviceOrderByNumber($orderNumber);

        return view('orders.show')->with([
            'order' => $serviceOrder,
            'userRole' => $userRole
        ]);
    }
}