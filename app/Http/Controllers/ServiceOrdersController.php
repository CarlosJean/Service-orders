<?php

namespace App\Http\Controllers;

use App\Enums\SystemRoles;
use App\Exceptions\NoServiceOrderItemsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddItemsToOrderRequest;
use App\Http\Requests\AssignTechnicianToOrderRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\DisapproveServiceOrderRequest;
use App\Http\Requests\TechnicalReportRequest;
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
        $employee = $this->employeeRepository
            ->employeeByUserId(auth()->id());

        $canCreateNewOrder = (!($employee['system_role'] == SystemRoles::MaintenanceSupervisor
            || $employee['system_role'] == SystemRoles::MaintenanceManager
            || $employee['system_role'] == SystemRoles::MaintenanceTechnician));

        return view('orders.index')->with('canCreateNewOrder', $canCreateNewOrder);
    }

    public function create()
    {
        if (auth()->guest()) return redirect('login');

        $userId = auth()->user()->id;

        $orderNumber = $this->ordersRepository->orderNumber();

        $employee = $this->employeeRepository->employeeByUserId($userId);

        $isDepartmentSupervisor = (!($employee['system_role'] == SystemRoles::MaintenanceSupervisor
            || $employee['system_role'] == SystemRoles::MaintenanceManager || $employee['system_role'] == SystemRoles::MaintenanceTechnician));

        return view('orders.create', [
            'orderNumber' => $orderNumber,
            'isDepartmentSupervisor' => $isDepartmentSupervisor,
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
            if ($th->getCode() == 1) {
                return back()->withErrors(['error' => $th->getMessage()]);
            }
        }
    }

    public function getOrders()
    {
        $userId = auth()->id();
        $serviceOrders = $this->ordersRepository->serviceOrdersByUserId($userId);

        foreach ($serviceOrders['data'] as $index => $serviceOrder) {
            if (isset($serviceOrders['data'][$index]->status)) {
                $serviceOrders['data'][$index]->status = strtoupper($serviceOrder->status);
            }
        }

        return $serviceOrders;
    }

    public function assignTechnicianCreate($orderNumber)
    {

        try {
            $serviceOrder = $this->ordersRepository->serviceOrderByNumber($orderNumber);
            return view('orders.assign_technician')->with('order', $serviceOrder->detail);
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

            $employee = $this->employeeRepository->employeeById($technicianId);
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
        if ($employee['system_role'] == SystemRoles::MaintenanceSupervisor || $employee['system_role'] == SystemRoles::MaintenanceManager) {
            $userRole = 'maintenanceSupervisor';
        } else if ($employee['system_role'] == SystemRoles::MaintenanceTechnician) {
            $userRole = 'technician';
        }

        $serviceOrder = $this->ordersRepository->serviceOrderByNumber($orderNumber);

        return view('orders.show')->with([
            'order' => $serviceOrder->detail,
            'userRole' => $userRole
        ]);
    }

    public function materialsManagementCreate($orderNumber)
    {
        $serviceOrder = $this->ordersRepository->serviceOrderByNumber($orderNumber);
        $serviceOrderItems =  $this->ordersRepository
            ->orderItems($orderNumber);

        return view('warehouse.management')->with([
            'order' => $serviceOrder->detail,
            'orderItems' => $serviceOrderItems['items'],
        ]);
    }

    public function orderMaterialsStore(AddItemsToOrderRequest $request, $orderNumber)
    {
        try {
            $items = $request->input('items');
            $this->ordersRepository->storeItemsOrder($orderNumber, $items);

            return view('orders.order_items_created')->with('orderNumber', $orderNumber);
        } catch (NoServiceOrderItemsException $ex) {
            return back()->withErrors($ex->getMessage());
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
            'requestor' => $order->detail->requestor,
            'technician' => $order->detail->technician,
        ]);

        return $order;
    }

    public function serviceOrderItems(Request $request)
    {
        try {
            $serviceOrderNumber = $request->input('service_order_number');
            return $this->itemsRepository
                ->serviceOrderItems($serviceOrderNumber);
        } catch (\Throwable $th) {
            throw $th;
        }
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
