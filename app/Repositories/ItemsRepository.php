<?php

namespace App\Repositories;

use App\Enums\InventoryType;
use App\Exceptions\NotFoundModelException;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemsDetail;
use App\Models\PurchaseOrder;
use App\Models\Quote;
use App\Notifications\ServiceOrderItemsDispatch;
use Exception;
use Illuminate\Support\Facades\Notification;

class ItemsRepository
{

    protected $inventoriesRepository;
    public function __construct(InventoriesRepository $inventoriesRepository)
    {
        $this->inventoriesRepository = $inventoriesRepository;
    }

    public function all($all=false)
    {
    $model = Item::select('items.id', 'items.name','items.description','measurement_unit','price','quantity','reference','items.active','categories.name as category')
    ->leftjoin('categories','categories.id','items.id_category');
  
    if(!$all) {       
        $model = $model ->where('active',1);
    }
      
    return $model->get();
    }

    public function available()
    {
        $items = Item::where('quantity', '>', '0')
            ->get();

        return $items;
    }

    public function item($itemId)
    {
        return Item::find($itemId);
    }

    public function itemsByServiceOrderNumber($serviceOrderNumber)
    {

        try {
            $serviceOrder = Order::where('number', $serviceOrderNumber)
                ->first();

            $orderItems = OrderItem::where('service_order_id', $serviceOrder->id)
                ->first();

            $details = $orderItems->detail;

            $items =  [];
            foreach ($details as $detail) {
                $item = $detail->item;
                //echo json_encode($item);
            }

            $quote = Quote::where('order_id', $serviceOrder->id)
                ->first();

            $purchaseOrder = PurchaseOrder::where('quote_id', $quote->id)
                ->first();

            foreach (/*$quote->purchaseOrderDetail*/$purchaseOrder->detail as $detail) {
                $item = $detail->item;
                echo json_encode($detail);
            }
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }

    public function serviceOrderItems($serviceOrderNumber)
    {
        try {
            $serviceOrder = Order::where('number', $serviceOrderNumber)->first();
    
            if ($serviceOrder == null) {
                throw new NotFoundModelException('No se encontró la orden de servicio número '.$serviceOrderNumber.'.');
            }
    
            $details = $serviceOrder
                ?->orderItem
                ?->orderItemDetail
                ->where('dispatched', false);
    
            $items = ['data' => []];
            if ($details == null) {
                return $items;
            }
            foreach ($details as $detail) {
                array_push($items['data'], [
                    'id' => $detail->id,
                    'name' => $detail->item->name,
                    'reference' => $detail->item->reference,
                    'quantity' => $detail->quantity,
                ]);
            }
    
            return $items;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function dispatch($itemsId)
    {

        try {

            $orderItem = OrderItemsDetail::find($itemsId[0])
                ->orderItem;

            $serviceOrderNumber = $orderItem
                ->serviceOrder
                ->number;

            foreach ($itemsId as $itemId) {
                $orderItemDetail = OrderItemsDetail::find($itemId);
                $orderItemDetail->dispatched = true;
                $orderItemDetail->save();

                $item = Item::find($itemId);
                $item->quantity = $orderItemDetail->quantity;

                $this->inventoriesRepository
                    ->historical($item, InventoryType::Dispatch);
            }

            $maintenanceSupervisorAndManager = Employee::get()
                ->whereIn('role_id', [2, 3])
                ->where('department_id', 2);

            $users = [];
            foreach ($maintenanceSupervisorAndManager as $employee) {
                array_push($users, $employee->user);
            }
            Notification::send($users, new ServiceOrderItemsDispatch($serviceOrderNumber));

            $orderItem->dispatched_by = auth()?->id();
            $orderItem->save();
            
            $serviceOrder = Order::where('number', $serviceOrderNumber)
                ->first();

            $serviceOrder->status = "en espera de resolucion";
            $serviceOrder->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($id)
    {
        try {

            $model =  Item::find($id);

            if ($model->active == 1)
                $model->active = 0;
            else
                $model->active = 1;

            $model->save();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',  $th->getMessage());
        }
    }

    public function create($description, $nombre, $medida, $precio, $cantidad, $referencia,$categoria)
    {
        try {

            if ($description == null) {
                throw new Exception('Debe especificar una descripcion.', 1);
            }

            if ($nombre == null) {
                throw new Exception('Debe especificar un nombre.', 1);
            }

            if ($categoria == null) {
                throw new Exception('Debe especificar una categoria.', 1);
            }


            $model = new Item([
                'description' => $description,
                'name' => $nombre,
                'measurement_unit' => $medida,
                'price' => $precio,
                'quantity' => $cantidad,
                'reference' => $referencia,
                'id_category' =>  $categoria
            ]);

            $model->save();

        } catch (\Throwable $th) {
            return redirect()->back()->with('error',  $th->getMessage());
        }
    }
}
