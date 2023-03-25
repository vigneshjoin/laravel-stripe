<?php

namespace App\Http\Controllers;

use App\service\productsService;
use Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public $productsService;

    public function __construct(productsService $productsService)
    {
        $this->productsService = $productsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //product-details.blade.php
        $intent = auth()->user()->createSetupIntent();
        $productLists = $this->productsService->getAll();
        return view('products', ["products" => $productLists, 'product', 'intent']);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $intent = auth()->user()->createSetupIntent();
        return view('show', compact('product', 'intent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function charge(String $product, $price)
    {
        return view('product-details',
            ['user' => $user,
                'intent' => $user->createSetupIntent(),
                'product' => $product, 'price' => $price]);
    }

    public function productDetail($id){
        
        $productDetails = $this->productsService->getProductById($id);
        $user = Auth::user();
        return view('product-details',['product'=>$productDetails,'user' => $user,'intent' => $user->createSetupIntent()]);
    }
    public function processPayment(Request $request, String $product, $price)
    {
        $user = Auth::user();
        $paymentMethod = $request->input('payment_method');
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);
        try { 
            $user->charge($price * 100 , $paymentMethod,
             [
            'off_session' => true,
             'description' => $product,
             'shipping' => [
                'name' => $user->name,
                'address' => [
                  'line1' => '510 Townsend St',
                  'postal_code' => '98140',
                  'city' => 'San Francisco',
                  'state' => 'CA',
                  'country' => 'US',
                ],
              ]
            ]);
        } 
        catch (\Exception $e) {
            return back()->withErrors(['message' => 'Error . ' . $e->getMessage()]);
        }
        return redirect('/payment-successful');
    }

    public function paymentComplete()
    {
        $user = Auth::user();
        // dd($user->name);
        return view('payment-successful');
    }
}
