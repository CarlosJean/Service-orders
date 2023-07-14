<?php

namespace App\View\Composers;

use App\Repositories\OrdersRepository;
use Illuminate\View\View;

class PendingItemsManagementComposer{
    
    public function __construct(protected OrdersRepository $ordersRepository){}

    public function compose(View $view):void{
        $view->with('serviceOrders', $this->ordersRepository->pendingItemsManagement());
    }
}