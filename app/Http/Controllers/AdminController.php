<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Mostrar panel con fotos pendientes
    public function index()
    {
        // Buscamos SOLO las fotos que están 'pending'
        $pendingPhotos = Photo::where('status', 'pending')->latest()->get();
        
        return view('admin.index', compact('pendingPhotos'));
    }

    // Aprobar una foto
    public function approve($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->status = 'approved';
        $photo->save();

        return back()->with('status', '¡Foto aprobada y publicada!');
    }

    // Rechazar una foto
    public function reject($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->status = 'rejected';
        $photo->save();

        return back()->with('status', 'Foto rechazada.');
    }
}