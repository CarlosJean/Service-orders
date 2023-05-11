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

    public function create()
    {
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
        $issue = $request->input('issue');
        $orderNumber = $request->input('order_number');

        $this->ordersRepository->createOrder($issue,$orderNumber);
        return back();
    }
}
