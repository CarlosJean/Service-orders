<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Repositories\EmployeeRepository;
use App\Repositories\OrdersRepository;
use Illuminate\Http\Request;

class ServiceOrdersController extends Controller
{

    protected $employeeRepository;
    protected $ordersRepository;

    public function __construct(EmployeeRepository $employeeRepository, OrdersRepository $ordersRepository)
    {
        $this->employeeRepository = $employeeRepository;
        $this->ordersRepository = $ordersRepository;
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

    public function assignTechnician($orderNumber){
        return view('orders.assign_technician');
    }
}