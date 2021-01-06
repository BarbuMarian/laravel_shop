@extends('admin.master_admin')
@section('produse')

<div class="container">

    <div class="row">
        <form method="POST" action="{{ route('adminStore') }}" enctype="multipart/form-data" class="on_center">
            @csrf

            <div class="form-group">
            <label for="formGroupExampleInput">Numele produsului</label>
            <input type="text" name="name" class="form-control" id="formGroupExampleInput" placeholder="Numele produsului">
            <div class="">{{$errors->first('name')}} </div>
            </div>

            <div class="form-group">
            <label for="formGroupExampleInput2">Descrierea produsului</label>
            <input type="text" name="description" class="form-control" id="formGroupExampleInput2" placeholder="Descrierea produsului">
            <div class="">{{$errors->first('description')}} </div>
            </div>

            <div class="form-group">
            <label for="formGroupExampleInput2">Pretul produsului</label>
            <input type="text" name="price" class="form-control" id="formGroupExampleInput3" placeholder="Pretul produsului">
            <div class="">{{$errors->first('price')}} </div>
            </div>

            <div class="custom-file">
            <input type="file" name="pic" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Choose file</label>
            <div class="">{{$errors->first('pic')}} </div>
            </div>

             <button type="submit" name="submit" class="btn btn-primary">Adauga Produs</button>
        </form>
    </div>
</div>
@endsection
