@extends('layouts.app')

@section('title', 'Taula de Pel·lícules')

@section('content')

@if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Bon dia</h2>
  <button id="btnNew" class="btn btn-primary">Afegir Pel·lícula</button>
</div>

<table class="table table-striped" id="moviesTable">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Títol</th>
      <th>Director</th>
      <th>Gènere</th>
      <th>Any</th>
      <th>Duració (min)</th>
      <th>Valoració</th>
      <th>Accions</th>
    </tr>
  </thead>
  <tbody>
    <!-- omplert per JS -->
  </tbody>
</table>

<!-- Contenidor per a la paginació -->
<nav aria-label="Paginació" id="paginationNav" class="mt-3"></nav>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  if (!document.querySelector('#moviesTable')) return;
  const apiBase = '/api/pelicula';
  let currentPage = 1;
  let lastPage = 1;

  // --- Fetch de pel·lícules per pàgina ---
  async function fetchMovies(page = 1) {
    try {
      const res = await fetch(apiBase + '?page=' + page);
      const body = await res.json();

      const movies = Array.isArray(body) ? body : (body.data ?? []);
      currentPage = body.current_page ?? page;
      lastPage = body.last_page ?? 1;

      // Ordenar per ID (de petit a gran)
      movies.sort((a, b) => a.id - b.id);

      renderTable(movies);
      renderPagination();
    } catch (err) {
      console.error('Error carregant pel·lícules', err);
      alert('Error carregant pel·lícules');
    }
  }

  // --- Render de la taula ---
  function renderTable(movies) {
    const tbody = document.querySelector('#moviesTable tbody');
    tbody.innerHTML = '';
    movies.forEach(m => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${m.id}</td>
        <td>${m.titol ?? ''}</td>
        <td>${m.director ?? ''}</td>
        <td>${m.genere ?? ''}</td>
        <td>${m.any_estrena ?? ''}</td>
        <td>${m.duracio ?? ''}</td>
        <td>${m.valoracio ?? ''}</td>
        <td>
          <button class="btn btn-sm btn-info" onclick="window.location.href='/pelicula/${m.id}/edit'">Editar</button>
          <button class="btn btn-sm btn-danger" onclick="deleteMovie(${m.id})">Eliminar</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  }

  // --- Render de controls de paginació (Inici | Anterior | 3 números | Següent | Final) ---
  function renderPagination() {
    const nav = document.getElementById('paginationNav');
    nav.innerHTML = '';

    const ul = document.createElement('ul');
    ul.className = 'pagination';

    // Inici
    const startLi = document.createElement('li');
    startLi.className = 'page-item ' + (currentPage <= 1 ? 'disabled' : '');
    startLi.innerHTML = `<a class="page-link" href="#" tabindex="-1">Inici</a>`;
    startLi.addEventListener('click', (e) => {
      e.preventDefault();
      if (currentPage > 1) fetchMovies(1);
    });
    ul.appendChild(startLi);

    // Previous
    const prevLi = document.createElement('li');
    prevLi.className = 'page-item ' + (currentPage <= 1 ? 'disabled' : '');
    prevLi.innerHTML = `<a class="page-link" href="#" tabindex="-1">Anterior</a>`;
    prevLi.addEventListener('click', (e) => {
      e.preventDefault();
      if (currentPage > 1) fetchMovies(currentPage - 1);
    });
    ul.appendChild(prevLi);

    // Calcular start per als 3 números mòbils
    let start = currentPage;
    if (start > lastPage - 2) {
      start = Math.max(1, lastPage - 2);
    }

    const pages = [];
    for (let p = start; p <= Math.min(start + 2, lastPage); p++) {
      pages.push(p);
    }

    pages.forEach(p => {
      const li = document.createElement('li');
      li.className = 'page-item ' + (p === currentPage ? 'active' : '');
      li.innerHTML = `<a class="page-link" href="#">${p}</a>`;
      li.addEventListener('click', (e) => {
        e.preventDefault();
        if (p !== currentPage) fetchMovies(p);
      });
      ul.appendChild(li);
    });

    // Next
    const nextLi = document.createElement('li');
    nextLi.className = 'page-item ' + (currentPage >= lastPage ? 'disabled' : '');
    nextLi.innerHTML = `<a class="page-link" href="#">Següent</a>`;
    nextLi.addEventListener('click', (e) => {
      e.preventDefault();
      if (currentPage < lastPage) fetchMovies(currentPage + 1);
    });
    ul.appendChild(nextLi);

    // Final
    const finalLi = document.createElement('li');
    finalLi.className = 'page-item ' + (currentPage >= lastPage ? 'disabled' : '');
    finalLi.innerHTML = `<a class="page-link" href="#">Final</a>`;
    finalLi.addEventListener('click', (e) => {
      e.preventDefault();
      if (currentPage < lastPage) fetchMovies(lastPage);
    });
    ul.appendChild(finalLi);

    nav.appendChild(ul);
  }

  // --- Eliminar pel·lícula ---
  window.deleteMovie = async function(id) {
    if (!confirm('Segur que vols eliminar aquesta pel·lícula?')) return;
    const resp = await fetch(apiBase + '/' + id, { method: 'DELETE' });
    if (resp.ok) {
      fetchMovies(currentPage);
    } else {
      alert('Error eliminant');
    }
  };

  // --- Botó "Afegir Pel·lícula" redirigeix a /pelicula/create ---
  document.getElementById('btnNew').addEventListener('click', () => {
    window.location.href = '/pelicula/create';
  });

  // Carreguem la pàgina inicial
  fetchMovies(1);
});
</script>
@endpush
