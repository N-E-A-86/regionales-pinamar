<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    // Guardar una nueva promoción
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100',
            'description' => 'required|max:255',
            'image' => 'required|image|max:5120', // Máx 5MB
        ]);

        // Guardar imagen
        $path = $request->file('image')->store('promotions', 'public');

        Promotion::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $path,
            'is_active' => true
        ]);

        return back()->with('status', '¡Promoción creada exitosamente!');
    }

    // Borrar una promoción
    public function destroy($id)
    {
        $promo = Promotion::findOrFail($id);
        
        // (Opcional) Aquí se podría borrar también el archivo de imagen del disco
        
        $promo->delete();

        return back()->with('status', 'Promoción eliminada.');
    }
}