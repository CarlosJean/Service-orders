<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddItemsToOrderRequest;
use App\Http\Requests\AssignTechnicianToOrderRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\DisapproveServiceOrderRequest;
use App\Http\Requests\TechnicalReportRequest;
use App\Models\Order;
use App\Repositories\EmployeeRepository;
use App\Repositories\OrdersRepository;
use App\Repositories\ServicesRepository;
use App\Repositories\DepartmentsRepository;
use App\Repositories\ItemsRepository;
use Illuminate\Http\Request;

class ServiceOrdersController extends Controller
{

    protected $employeeRepository;
    protected $ordersRepository;
    protected $servicesRepository;
    protected $departmentsRepository;
    protected $itemsRepository;

    public function __construct(
        EmployeeRepository $employeeRepository,
        OrdersRepository $ordersRepository,
        ServicesRepository $servicesRepository,
        DepartmentsRepository $departmentsRepository,
        ItemsRepository $itemsRepository
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->ordersRepository = $ordersRepository;
        $this->servicesRepository = $servicesRepository;
        $this->departmentsRepository = $departmentsRepository;
        $this->itemsRepository = $itemsRepository;
    }

    public function index()
    {
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

    public function getOrders()
    {
        $userId = auth()->id();
        $serviceOrders = $this->ordersRepository->serviceOrdersByUserId($userId);
        return $serviceOrders;
    }

    public function assignTechnicianCreate($orderNumber)
    {

        try {
            $serviceOrder = $this->ordersRepository->serviceOrderByNumber($orderNumber);
            return view('orders.assign_technician')->with('order', $serviceOrder);
        } catch (\Throwable $th) {
            //throw $th;
            var_dump($th);
        }
    }

    public function getServices()
    {
        return $this->servicesRepository->services();
    }

    public function getDeparments()
    {
        return   $this->departmentsRepository->departments();
    }

    public function getEmployeesByService($idService)
    {
        return $this->employeeRepository->employeesByService($idService);
    }

    public function assignTechnicianUpdate(AssignTechnicianToOrderRequest $request)
    {
        try {
            $serviceOrderNumber  = $request->input('order_number');
            $technicianId = $request->input('technician_id');

            $this->ordersRepository->assignTechnician($serviceOrderNumber, $technicianId);

            $employee = $this->employeeRepository->employeeByUserId($technicianId);
            $technician = $employee['names'] . ' ' . $employee['last_names'];

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

    public function disapproveUpdate(DisapproveServiceOrderRequest $request)
    {
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

    public function show($orderNumber)
    {
        $userId = auth()->id();
        $employee = $this->employeeRepository
            ->employeeByUserId($userId);

        $roleId = $employee['role']->id;
        $departmentId = $employee['department']->id;

        $userRole = '';
        if ($departmentId = 2 && $roleId == 2) {
            $userRole = 'maintenanceSupervisor';
        } else if ($departmentId = 2 && $roleId == 3) {
            $userRole = 'technician';
        }

        $serviceOrder = $this->ordersRepository->serviceOrderByNumber($orderNumber);

        return view('orders.show')->with([
            'order' => $serviceOrder,
            'userRole' => $userRole
        ]);
    }

    public function materialsManagementCreate($orderNumber)
    {
        $serviceOrder = $this->ordersRepository->serviceOrderByNumber($orderNumber);
        return view('warehouse.management')->with('order', $serviceOrder->detail);
    }

    public function orderMaterialsStore(AddItemsToOrderRequest $request, $orderNumber)
    {
        try {
            $items = $request->input('items');
            $this->ordersRepository->storeItemsOrder($orderNumber, $items);

            return view('orders.order_items_created')->with('orderNumber', $orderNumber);
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }

    public function getServiceOrderByNumber(Request $request)
    {
        $orderNumber = $request->input("order_number");
        $order = $this->ordersRepository->serviceOrderByNumber($orderNumber);

        $order = json_encode([
            'requestor' => $order->requestor,
            'technician' => $order->technician,
        ]);

        return $order;
    }

    public function serviceOrderItems(Request $request)
    {
        $serviceOrderNumber = $request->input('service_order_number');
        return $this->itemsRepository
            ->serviceOrderItems($serviceOrderNumber);
    }

    public function storeTechnicalReport(TechnicalReportRequest $request)
    {
        try {
            $technicalReport = $request->input('technical_report');
            $startOrder = $request->boolean('start');
            $orderNumber = $request->get('order_number');

            $this->ordersRepository->technicianReport($orderNumber, $technicalReport, $startOrder);

            return view('orders.diagnosed_by_technician')->with(['orderNumber' => $orderNumber]);
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }

    public function startOrder(Request $request)
    {
        $serviceOrderNumber = $request->input('order_number');
        $this->ordersRepository->startOrder($serviceOrderNumber);
        return view('orders.started_order')->with('orderNumber', $serviceOrderNumber);
    }

    public function finishOrder(Request $request)
    {
        $serviceOrderNumber = $request->input('order_number');
        $this->ordersRepository->finishOrder($serviceOrderNumber);
        return view('orders.finished_order')->with('orderNumber', $serviceOrderNumber);
    }

    public function createItemsRequestApproval($serviceOrderNumber)
    {

        $order = $this->ordersRepository
            ->serviceOrderByNumber($serviceOrderNumber);

        return view('items.request_approval')->with(['order' => $order->detail, 'orderItems' => $order->items]);
    }

    public function updateItemsRequest(Request $request)
    {
        $orderNumber = $request->input('service_order_number');
        $orderItemApproved = $request->boolean('order_items_approved');

        $this->ordersRepository
            ->approveServiceOrderItemRequest($orderNumber, $orderItemApproved);

        return view('items.request_approval_submitted')
            ->with([
                'serviceOrderNumber' => $orderNumber,
                'approved' => $orderItemApproved
            ]);
    }
}