@extends('admin.master_admin')
@section('produse')



<div class="container">
<p><a href="{{ route('adminEdit',['product'=>$product->id]) }}" class="btn btn-warning">edit product</a></p>

    <div class="row">
        {{--
        <ul>
            <li><div><h3>numele este :  {{$product->name}}</h3></div></li>
            <li><div><h3>descrirea produsului este : {{$product->description}}</h3></div></li>
            <li><div><h3>pretul este: {{$product->price}}</h3></div></li>
        </ul>
        --}}
        <div class="col-3">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top img-thumbnail img-responsive myimg" src="{{asset('storage/'. $product->pic)}}">
                <div class="card-body">
                    <h5 class="card-title">numele este :  {{$product->name}}</h5>
                    <p class="card-text">descrirea produsului este : {{$product->description}}</p>
                    <p class="card-text">pretul este: {{$product->price}}</p>
                </div>
            </div>
        </div>
        <hr>
        <form class="" action="{{ route('adminDestroy',['product'=>$product->id]) }}" method="post">

            @csrf
            @method('DELETE')
            <button type="submit" name="delete" class="btn btn-danger">DELETE</button>
        </form>
    </div>
</div>
@endsection
