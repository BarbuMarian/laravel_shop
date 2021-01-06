@extends('admin.master_admin')
@section('produse')

<div class="container">
    <form  action="{{ route('logIn') }}" method="POST">
        @csrf
      <div class="form-group">
        <label>Utilizator</label>
        <input type="text" class="form-control" name="username" value="">
      </div>
      <div class="form-group">
        <label>Parola</label>
        <input type="password" class="form-control"  name="password">
      </div>

      <button type="submit" class="btn btn-primary" name="button">Logare</button>
    </form>

    @if(session('message'))
    <div class="red">
    {{session('message')}}
    </div>
    @endif
</div>


@endsection
