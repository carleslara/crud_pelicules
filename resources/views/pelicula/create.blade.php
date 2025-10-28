@extends('layouts.app')

@section('title', 'Afegir Pel·lícula')

@section('content')
<div class="col-md-8 mx-auto">
  <h3>Afegir Pel·lícula</h3>

  <form method="POST" action="{{ route('web.pelicula.store') }}">
    @csrf

    {{-- TITOL --}}
    <div class="mb-3">
      <label for="titol" class="form-label">Títol *</label>
      <input id="titol" name="titol"
             class="form-control @error('titol') is-invalid @enderror"
             required
             value="{{ old('titol') }}">
      @error('titol')
        <div class="invalid-feedback">
          {{ $message }} — Introdueix un títol clar per la pel·lícula (per exemple, un nom distintiu).
        </div>
      @enderror
    </div>

    {{-- DIRECTOR --}}
    <div class="mb-3">
      <label for="director" class="form-label">Director</label>
      <input id="director" name="director"
             class="form-control @error('director') is-invalid @enderror"
             value="{{ old('director') }}">
      @error('director')
        <div class="invalid-feedback">
          {{ $message }} — Escriu el nom del director (nom complet o nom artístic).
        </div>
      @enderror
    </div>

    {{-- GENERE --}}
    <div class="mb-3">
      <label for="genere" class="form-label">Gènere</label>
      <input id="genere" name="genere"
             class="form-control @error('genere') is-invalid @enderror"
             value="{{ old('genere') }}">
      @error('genere')
        <div class="invalid-feedback">
          {{ $message }} — Indica un gènere (ex: Drama, Comèdia, Acció).
        </div>
      @enderror
    </div>

    {{-- ANY ESTRENA --}}
    <div class="mb-3">
      <label for="any_estrena" class="form-label">Any d'estrena</label>
      <input id="any_estrena" name="any_estrena" type="number"
             class="form-control @error('any_estrena') is-invalid @enderror"
             value="{{ old('any_estrena') }}">
      @error('any_estrena')
        <div class="invalid-feedback">
          {{ $message }} — Escriu un any de 4 xifres (ex: 1994).
        </div>
      @enderror
    </div>

    {{-- DURACIO --}}
    <div class="mb-3">
      <label for="duracio" class="form-label">Duració (min)</label>
      <input id="duracio" name="duracio" type="number"
             class="form-control @error('duracio') is-invalid @enderror"
             value="{{ old('duracio') }}">
      @error('duracio')
        <div class="invalid-feedback">
          {{ $message }} — Introdueix la duració en minuts (un nombre enter positiu).
        </div>
      @enderror
    </div>

    {{-- VALORACIO --}}
    <div class="mb-3">
      <label for="valoracio" class="form-label">Valoració (0-10)</label>
      <input id="valoracio" name="valoracio" type="number" step="0.1"
             class="form-control @error('valoracio') is-invalid @enderror"
             value="{{ old('valoracio') }}">
      @error('valoracio')
        <div class="invalid-feedback">
          {{ $message }} — Introdueix una nota entre 0 i 10 (pots usar decimals, ex: 7.5).
        </div>
      @enderror
    </div>

    <button class="btn btn-primary" type="submit">Guardar</button>
    <a href="{{ route('web.home') }}" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
@endsection
