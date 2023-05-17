<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuotesController extends Controller
{

    public function create(Request $request){
        $orderNumber = $request->input('numero_orden');

        return view('quotes.create');
    }
}
