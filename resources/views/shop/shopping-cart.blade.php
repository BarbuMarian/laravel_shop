@extends('public.master_public')
@section('continut')

    @if(session()->has('cart'))
        <div class="row">
            <div class="col-12">
                <table  class="table">
                    <thead>
                      <tr>
                        <th>Cantitatea acestui produs este de:</th>
                        <th>Numele produsului este:</th>
                        <th>Pretul pentru acest produs este</th>
                        <th>Mai adauga produs</th>
                        <th>Sterge un produs</th>
                        <th>Sterge produsele</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td> {{$product['qty']}}</td>
                        <td> {{$product['item']['name']}}</td>
                        <td> {{$product['price']}}</td>
                        <td><a href="{{route('product.addToCart', ['id' => $product['item']['id']])}}" class="btn btn-primary" role='button'>adauga un produs</a></td>
                        <td><a href="{{route('product.reduceByOne', ['id' => $product['item']['id']])}}">sterge 1</a></td>
                        <td><a href="{{route('product.remove', ['id' => $product['item']['id']])}}">sterge tot</a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-6">
                <strong>Total: {{$totalPrice}}</strong>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-6">
                <a href="{{ route('checkout')}}" class="btn btn-success">Checkout</a>
            </div>
        </div>
    @else
    <div class="row">
        <div class="col-6">
            <h2>Cosul este gol!</h2>
        </div>
    </div>
    @endif
@endsection
