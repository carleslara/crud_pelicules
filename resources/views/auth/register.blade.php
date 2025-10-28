@extends('layouts.app')

@section('title', 'Registrar-se')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2>Registrar-se</h2>
    <form method="POST" action="{{ route('register.post') }}">
      @csrf
      <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contrasenya</label>
        <input id="password" name="password" type="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirma contrasenya</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required>
      </div>
      <button class="btn btn-success" type="submit">Registrar-se</button>
    </form>
  </div>
</div>
@endsection
