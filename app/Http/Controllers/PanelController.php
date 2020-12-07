<?php

namespace App\Http\Controllers;
use App\Product;
use App\Panel;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function __construct() {
        $this->middleware('auth') ;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     $duplicata = Panel::search(function ($cartItem, $rowId) use ($request){
         return $cartItem->id == $request->product_id;
     });
     if($duplicata->isNotEmpty()){
        return redirect()->route('products.index')->with('success', 'Le produit a deja été ajouté.');
    }
      $product = Product::find($request->product_id);
      Panel::add($product->id, $product->title, 1, $product->price)
      ->associate('App\Product');
      return redirect()->route('products.show')->with('success', 'Le produit a bien été ajouté.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Panel  $panel
     * @return \Illuminate\Http\Response
     */
    public function show(Panel $panel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Panel  $panel
     * @return \Illuminate\Http\Response
     */
    public function edit(Panel $panel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Panel  $panel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Panel $panel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Panel  $panel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Panel $panel)
    {
        //
    }
}
