<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    /**
     * Mostra la llista de recursos paginada (ordenat per id asc).
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $paginated = Pelicula::orderBy('id', 'asc')->paginate($perPage);

        // Laravel convertirà automàticament a JSON
        return response()->json($paginated);
    }

    /**
     * Emmagatzema una nova pel·lícula.
     */
    public function store(Request $request)
    {
        $rules = [
            'titol' => 'required|string|max:255',
            'director' => 'nullable|string|max:255',
            'genere' => 'nullable|string|max:100',
            'any_estrena' => 'nullable|digits:4|integer',
            'duracio' => 'nullable|integer|min:1',
            'valoracio' => 'nullable|numeric|min:0|max:10',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $data = $validator->validated();
        $movie = Pelicula::create($data);

        return response()->json(['created' => true, 'movie' => $movie], 201);
    }

    /**
     * Mostra un recurs específic.
     */
    public function show($id)
    {
        $movie = Pelicula::findOrFail($id);
        return response()->json($movie);
    }

    /**
     * Actualitza una pel·lícula.
     */
    public function update(Request $request, $id)
    {
        $pelicula = Pelicula::findOrFail($id);

        $rules = [
            'titol' => 'sometimes|required|string|max:255',
            'director' => 'sometimes|nullable|string|max:255',
            'genere' => 'sometimes|nullable|string|max:100',
            'any_estrena' => 'nullable|digits:4|integer',
            'duracio' => 'nullable|integer|min:1',
            'valoracio' => 'nullable|numeric|min:0|max:10',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'updated' => false,
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $data = $validator->validated();
        $pelicula->update($data);

        return response()->json(['updated' => true, 'movie' => $pelicula], 200);
    }

    /**
     * Elimina una pel·lícula.
     */
    public function destroy($id)
    {
        Pelicula::destroy($id);
        return response()->json(null, 204);
    }
}
