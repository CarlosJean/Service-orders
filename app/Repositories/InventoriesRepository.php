<?php

namespace App\Repositories;

use App\Enums\InventoryType;
use App\Models\Inventory;
use App\Models\Item;
use Exception;
use Illuminate\Support\Facades\DB;

class InventoriesRepository
{
    public function historical(Item $item, InventoryType $inventoryType)
    {

        try {

            $itemFound = (Item::find($item->id));

            if (!$itemFound) {
                throw new Exception('No se encontró el artículo con el id ' . $item->id);
            }

            //Si es un despacho de artículos entonces la cantidad se coloca en negativo
            if ($inventoryType::Dispatch) {
                $item->quantity *=  -1;
            }

            $inventory = new Inventory([
                'item_id' => $item->id,
                'price' => $item->price,
                'quantity' => $item->quantity,
            ]);

            $inventory->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getByDate($fromDate, $toDate)
    {

        $from = date($fromDate);
        $to = date($toDate);

        $inventories = DB::table('inventories')
            ->whereDate('inventories.created_at', '>=', $from)
            ->whereDate('inventories.created_at', '<=', $to)
            ->join('items', 'inventories.item_id', '=', 'items.id')
            ->select(
                'items.id',
                'items.name',
                'items.reference',
                DB::raw('round(sum(inventories.quantity),2) quantity'),
                DB::raw('round(avg(inventories.price),2) price'),
                'inventories.created_at',
            )
            ->groupBy('items.id', 'items.name', 'items.reference', 'inventories.created_at')
            ->get();
        
        $inventoryValue = collect($inventories)->sum('price');

        $inventories = ['items' => $inventories, 'total_value' => $inventoryValue];

        return $inventories;
    }
}
