@extends('public.master_public')

@section('continut')

    <div class="col-3">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top img-thumbnail img-responsive myimg" src="{{asset('storage/'. $product->pic)}}">
            <div class="card-body">
                <h5 class="card-title">numele este :  {{$product->name}}</h5>
                <h5 class="card-title"><a href="{{route('single',['format' => 'json', 'id'=> $product->id])}}">Aici poti vedea produsul in Json</a></h5>
                <h5 class="card-title"><a href="{{route('single',['format' => 'xml', 'id'=> $product->id])}}">Aici poti vedea produsul in Xml</a></h5>
                <p class="card-text">descrirea produsului este : {{$product->description}}</p>
                <p class="card-text">pretul este: {{$product->price}}</p>
                <a href="{{route('product.addToCart', ['id' =>$product->id])}}" class="btn btn-primary" role='button'>Add to cart</a>
            </div>
        </div>
    </div>




@endsection
