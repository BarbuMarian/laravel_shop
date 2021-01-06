@extends('public.master_public')
@section('continut')
    <div class="row">
        <div class="col-6 on_center">
            <p>checkout</p>
            <p>total de plata este {{ $total }}</p>
            <form method="POST" action="{{route('checkout')}}">
                @csrf
                <div class="{{!session()->has('error') ? 'hidden' : ''}}">
                        {{session()->get('error')}}
                </div>

                <div class="form-group">
                <label for="formGroupExampleInput">Numele Tau</label>
                <input type="text" name="name" class="form-control" id="formGroupExampleInput" placeholder="Numele Tau">
                <div class="">{{$errors->first('name')}} </div>
                </div>

                <div class="form-group">
                <label for="formGroupExampleInput2">Nr de telefon</label>
                <input type="text" name="phone" class="form-control" id="formGroupExampleInput3" placeholder="Nr de telefon">
                <div class="">{{$errors->first('phone')}} </div>
                </div>

                <div class="form-group">
                <label for="formGroupExampleInput2">Adresa</label>
                <input type="text" name="address" class="form-control" id="formGroupExampleInput2" placeholder="Adresa">
                <div class="">{{$errors->first('address')}} </div>
                </div>


                 <button type="submit" name="submit" class="btn btn-primary">comanda</button>
            </form>
        </div>
    </div>
@endsection
