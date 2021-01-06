@extends('admin.master_admin')
@section('produse')

@if(session()->has('success'))
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                {{session()->get('success')}}
            </div>
        </div>
    </div>
@endif

<table class="table">
  <thead>
    <tr>
      <th >ID produs</th>
      <th >Nume</th>
      <th >Descriere</th>
      <th >Pret</th>
    </tr>
  </thead>
  <tbody>



      @foreach($products as $product)
    <tr>
      <th>{{$product->id}}</th>
      <td><a href="{{ route('adminShow',['product'=>$product->id]) }}">{{$product->name}}</a></td>
      <td>{{$product->description}}</td>
      <td>{{$product->price}}</td>
    </tr>
     @endforeach


  </tbody>
</table>
@endsection
