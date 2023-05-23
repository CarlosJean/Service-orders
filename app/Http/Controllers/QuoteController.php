<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Http\Controllers\Controller;
use App\Repositories\QuotesRepository;
use Illuminate\Http\Request;

class QuoteController extends Controller
{

    protected $quotesRepository;
    public function __construct(QuotesRepository $quotesRepository){
        $this->quotesRepository = $quotesRepository;
    }
    
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        $quoteNumber = $this->quotesRepository->quoteNumber();
        return view('quotes.create')->with('quoteNumber', $quoteNumber);        
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $orderNumber = $request->input('numero_orden');

        return view('quotes.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        //
    }
}
