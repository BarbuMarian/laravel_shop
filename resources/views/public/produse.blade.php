@extends('public.master_public')

@section('continut')
@if(session()->has('success'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                {{session()->get('success')}}
            </div>
        </div>
    </div>
@endif
@if(session('message'))
    <div class="red">
    {{session('message')}}
    </div>
@endif
<div class="row">
    <div class="col-4">
        <span>Sorteaza:</span>
        <ul class="list-group list-group-horizontal-lg">
            <li class=""><a href="{{route('sorting',['sort'=> 'asc'])}}" class="btn btn btn-outline-secondary">asc</a></li>
            <li class=""><a href="{{route('sorting',['sort'=> 'desc'])}}" class="btn btn btn-outline-secondary">desc</a></li>
        </ul>
    </div>
    <div class="col-4">
        <span>Format Jason:</span>
        <ul class="list-group list-group-horizontal-lg">
            <li class=""><a href="{{route('all',['format' => 'json','sort'=> 'asc'])}}" class="btn btn btn-outline-secondary">asc json</a></li>
            <li class=""><a href="{{route('all',['format' => 'json', 'sort'=> 'desc'])}}" class="btn btn btn-outline-secondary">desc json</a></li>
        </ul>
    </div>
    <div class="col-4">
        <span>Format XML:</span>
        <ul class="list-group list-group-horizontal-lg">
            <li class=""><a href="{{route('all',['format' => 'xml','sort'=> 'asc'])}}" class="btn btn btn-outline-secondary">asc xml</a></li>
            <li class=""><a href="{{route('all',['format' => 'xml', 'sort'=> 'desc'])}}" class="btn btn btn-outline-secondary">desc xml</a></li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="row">

        @foreach($products as $product)
            <div class="col-3">
                <div class="card" style="width: 18rem;">
                    {{--  <a href="/guest/{{$product->id}}"><img class="card-img-top img-thumbnail img-responsive myimg" src="{{asset('storage/'. $product->pic)}}"></a>--}}
                    <a href="{{route('showSelectProduct', ['product' =>$product->id])}}"><img class="card-img-top img-thumbnail img-responsive myimg" src="{{asset('images/'.$product->pic)}}"></a>
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">{{$product->description}}</p>
                        <p class="card-text">{{$product->price}}</p>
                        <a href="{{route('product.addToCart', ['id' =>$product->id])}}" class="btn btn-primary" role='button'>Add to cart</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
