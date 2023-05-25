<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuoteRequest;
use App\Repositories\QuotesRepository;
use Illuminate\Http\Request;

class QuoteController extends Controller
{

    protected $quotesRepository;
    public function __construct(QuotesRepository $quotesRepository)
    {
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
    public function create()
    {
        $quoteNumber = $this->quotesRepository->quoteNumber();
        return view('quotes.create')->with('quoteNumber', $quoteNumber);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuoteRequest $request)
    {
        try {
            $quoteNumber = $request->input('quote_number');
            $serviceOrderNumber = $request->input('service_order_number');
            $quotes = $request->input('quotes');

            if ($quotes == null) {
                return back()
                    ->withErrors(['no_items' => 'Debe especificar los artículos a comprar.'])
                    ->withInput();
            }
            $this->quotesRepository->storeQuote($quoteNumber, $serviceOrderNumber, $quotes);

            return view('quotes.created')->with('quoteNumber', $quoteNumber);
        } catch (\Throwable $th) {
            return back()
                ->withErrors(['exceptions' => $th->getMessage()])
                ->withInput();
        }
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
