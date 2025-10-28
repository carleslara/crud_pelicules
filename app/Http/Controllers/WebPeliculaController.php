<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelicula;
use Illuminate\Support\Facades\Validator;

class WebPeliculaController extends Controller
{
    public function index()
    {
        return view('home');
    }
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
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Crear amb només els camps valids
        $data = $validator->validated();

        Pelicula::create($data);

        return redirect()->route('web.home')->with('success', 'Pel·lícula creada correctament.');;
    }

    public function update(Request $request, $id)
    {
        $pelicula = Pelicula::findOrFail($id);

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
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        $pelicula->update($data);

        return redirect()
            ->route('web.home')
            ->with('success', 'Pel·lícula actualitzada correctament.');
    }
}
