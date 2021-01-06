<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Product;
use App\Cart;
use App\Order;
use Session;
use SimpleXMLElement;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
            $products = Product::all()->sortBy("name");
            if ($request->session()->get('admin') === null) {
                return view('public.produse',compact('products'));
            }else {
                return view('admin.produse',compact('products'));
            }
    }

    public function getorders(){
        $orders = \App\Order::with('products')->get();
        return view('admin.comenzi',compact('orders'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $product = Product::create($this->validateRequest());
        $this->storeImage($product);
        return redirect('admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $product)
    {
        $product = Product::where('id', $product)->firstOrFail();


    if ($request->session()->get('admin') === null) {
        return view('public.detalii',compact('product'));
    }else {
        return view('admin.show',compact('product'));
    }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
        $product = Product::where('id', $product)->firstOrFail();
        return view('admin.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( $product)
    {
        $product = Product::where('id', $product)->firstOrFail();
        $product->update($this->validateRequest());
        $this->storeImage($product);
        return redirect('admin/'. $product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        $product = Product::where('id', $product)->firstOrFail();
        $product->delete();
        return redirect('admin');
    }

    public function validateRequest()
    {

        return request()->validate([

            'name' => 'required|min:3',
            'description' => 'required',
            'price' => 'required',
            'pic' =>'required|file|image|max:5000',
        ]);

    }

    public function storeImage( $product){
/*
        if (request()->has('pic')) {
            $product->update([
                'pic' => request()->pic->store('public/paint'),

            ]);

        }

*/

            if (request()->has('pic')){
                $filename = time().'.'.request()->pic->getClientOriginalExtension();
                request()->pic->move(public_path('images'), $filename);

                $product->pic=$filename;
                $product->save();

            }

    }

    public function getAddToCart(Request $request, $id){
        $product = Product::find($id);
        $oldCart = session()->has('cart') ? session()->get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
    //    return back();
    return redirect()->route('product.shoppingCart');
    }

    public function getReduceByOne($id){
        $oldCart = session()->has('cart') ? session()->get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);

        if (count($cart->items) > 0) {
            session()->put('cart', $cart);
        }else {
            session()->forget('cart');
        }

        return redirect()->route('product.shoppingCart');
    }

    public function getRemoveItem($id){
        $oldCart = session()->has('cart') ? session()->get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);

        if (count($cart->items) > 0) {
            session()->put('cart', $cart);
        }else {
            session()->forget('cart');
        }


        return redirect()->route('product.shoppingCart');
    }

    public function getCart(){
        if (!session()->has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = session()->get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    public function getCheckout(){
        if (!session()->has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = session()->get('cart');
        $cart = new Cart($oldCart);
        $total= $cart->totalPrice;

        return view('shop.checkout', ['total'=> $total]);
    }

    public function postCheckout(Request $request){
        $order = new Order();


        $data = request()->validate([
               'name' => 'required|min:3',
               'phone' => 'required|numeric|min:4',
               'address' =>'required|min:5',
           ]);

        $order->name = $request->input('name');
        $order->phone = $request->input('phone');
        $order->address = $request->input('address');

        if (!session()->has('cart')) {

            return redirect('admin');
        }
        $oldCart = session()->get('cart');
        $cart = new Cart($oldCart);

        $product_list = array_keys($cart->items);

        $cart->items;
        $cart->totalQty;
        $cart->totalPrice;

        $order->save();

        $last_order = $order->id;

        foreach ($cart->items as $key => $list) {
            $order->products()->attach([
                    $last_order => ['product_id' => $key,
                                    'product_amount' => $list['qty']
                                     ],
            ]);

        }

        session()->forget('cart');
        return redirect('/')->with('success', 'Successfuly prurchased');
    }

    public function sort(){

        $products = new Product();
        $sort = request('sort');

        if ($sort == 'desc') {
            $products = Product::all()->sortByDesc("name");

        }else {
            $products = Product::all()->sortBy("name");

        }

        return view('public.produse',[
            'sort' => $sort,
            ])->with('products', $products);
    }

    public function formatSingle($format, $id){

        $products = new Product();
        $products = Product::where('id', $id)->firstOrFail();

        $products_array = [];
            $data = [
            'name' => $products->name,
            'description' => $products->description,
            'price' => $products->price,
        ];

        $products_array[] =$data;

        function array_to_xml($products_array, &$xml_product_info) {
            foreach($products_array as $key => $value) {
                if(is_array($value)) {
                    if(!is_numeric($key)){
                        $subnode = $xml_product_info->addChild("$key");
                        array_to_xml($value, $subnode);
                    }else{
                        $subnode = $xml_product_info->addChild("item$key");
                        array_to_xml($value, $subnode);
                    }
                }else {
                $xml_product_info->addChild("$key",htmlspecialchars("$value"));
                }
            }
        }

        $random = Str::random(15);
        $xml_product_info = new SimpleXMLElement("<?xml version=\"1.0\"?><product_info></product_info>");
        array_to_xml($products_array,$xml_product_info);
        $xml_file = $xml_product_info->asXML('xml/'.$random.'.xml');
        $location ='xml/'.$random.'.xml';

        $get_location = file_get_contents($location);

        if($format == "json"){
            return response()->json($products);
        }elseif ($format == "xml") {
            return response($get_location)->header('Content-Type', 'application/xml');
        }
        else{
            return "formatul selectat nu este disponibil";
        }

    }

    public function formatAll($format){
        $products = new Product();
        $sort = request('sort');

        if ($sort == 'desc') {
            $products = Product::all()->sortByDesc("name");

        }else {
            $products = Product::all()->sortBy("name");

        }

        foreach ($products as $product) {

            $data = [
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
            ];


        $products_array[] =$data;
        }


        function array_to_xml($products_array, &$xml_product_info) {
            foreach($products_array as $key => $value) {
                if(is_array($value)) {
                    if(!is_numeric($key)){
                        $subnode = $xml_product_info->addChild("$key");
                        array_to_xml($value, $subnode);
                    }else{
                        $subnode = $xml_product_info->addChild("item$key");
                        array_to_xml($value, $subnode);
                    }
                }else {
                $xml_product_info->addChild("$key",htmlspecialchars("$value"));
                }
            }
        }

        $random = Str::random(15);
        $xml_product_info = new SimpleXMLElement("<?xml version=\"1.0\"?><product_info></product_info>");
        array_to_xml($products_array,$xml_product_info);
        $xml_file = $xml_product_info->asXML('xml/'.$random.'.xml');
        $location ='xml/'.$random.'.xml';

        $get_location = file_get_contents($location);

        if($format == "json"){
            return response()->json($products);
        }elseif ($format == "xml") {
            return response($get_location)->header('Content-Type', 'application/xml');
        }
        else{
            return "formatul selectat nu este disponibil";
        }

    }


}
