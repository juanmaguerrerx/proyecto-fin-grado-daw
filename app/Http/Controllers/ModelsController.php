<?php

namespace App\Http\Controllers;

use App\Models\Models; // Asumiendo que el modelo se llama Models
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModelsController extends Controller
{
    public function index()
    {
        $items = Models::where('id', '!=', 0)->get(); // Obtener todos los modelos
        return Inertia::render('Index', [
            'items' => $items,
            'titulo' => 'Modelos',
            'tableName' => 'models'
        ]);
    }

    public function indexUser()
    {
        $items = Models::where('id', '!=', 0)->get(); // Obtener todos los modelos
        return Inertia::render('Catalogue', [
            'items' => $items,
            'titulo' => 'Modelos',
            'tableName' => 'models'
        ]);
    }

    public function store(Request $request)
    {
        // Valida y guarda el nuevo modelo
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // Agrega más validaciones según tus necesidades
        ]);
        Models::create($validatedData);
        return redirect()->back();
    }

    public function update(Request $request, Models $model)
    {
        // Valida y actualiza el modelo
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // Agrega más validaciones según tus necesidades
        ]);

        $model->update($validatedData);

        return redirect()->back();
    }

    public function destroy(Models $model)
    {
        // Elimina el modelo
        $model->delete();
        return redirect()->back();
    }
}
