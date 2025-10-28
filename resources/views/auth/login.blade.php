@extends('layouts.app')

@section('title', 'Entrar')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2>Entrar</h2>
    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contrasenya</label>
        <input id="password" name="password" type="password" class="form-control" required>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" name="remember" id="remember" class="form-check-input">
        <label for="remember" class="form-check-label">Recorda'm</label>
      </div>
      <button class="btn btn-primary" type="submit">Entrar</button>
    </form>
  </div>
</div>
@endsection
