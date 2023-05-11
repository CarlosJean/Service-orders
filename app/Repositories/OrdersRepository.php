<?php

namespace App\Repositories;

use App\Models\Order;

class OrdersRepository{

    public function orderNumber(){
        //Determinar si el número de orden está repetido.

        return $this->generateOrderNumber();
    }
    
    private function generateOrderNumber(){
        $minOrderNumber = 000000;
        $maxOrderNumber = 999999;
        
        return rand($minOrderNumber, $maxOrderNumber);
    }

    public function createOrder($issue,$orderNumber){
        try {
            $order = new Order([
                'requestor' => auth()->id(),
                'number' => $orderNumber,
                'issue' => $issue,
                'status' => 'pendiente de asignar'
            ]);

            $order->save();

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}