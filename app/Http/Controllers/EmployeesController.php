<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index(){
        return view('employees.register');
    }    


    public function store(Request $request){
        var_dump($request->all());
        return view('employees.register');
    }
    
}
