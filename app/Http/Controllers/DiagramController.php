<?php

namespace App\Http\Controllers;

use App\Models\Diagram;
use Illuminate\Http\Request;

class DiagramController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // mostrar los diagramas
    public function index()
    {

        $diagramas = Diagram::all();
        return view('diagrams.index', compact('diagramas'));
    }

    // ir al formulario de creacion
    public function create()
    {
        return view('diagrams.create');
    }

    // crear el diagrama en la bd
    public function sendData(Request $request)
    {
        $rules = [
            'titulo' => 'required|max:255',
            'descripcion' => 'nullable',
            'contenido' => 'json|nullable',
        ];

        $messages = [
            'titulo.required' => 'El titulo del Diagrama es obligatorio.',
            'contenido.json'  => 'El contenido debe ser un json'

        ];

        $this->validate($request,$rules,$messages);
        // Validar los datos de entrada
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'nullable',
            'contenido' => 'json|nullable',
        ]);
        $diagram = new Diagram();
        $diagram->titulo = $request->input('titulo');
        $diagram->descripcion = $request->input('descripcion');
        $diagram->contenido = $request->input('contenido');
        $diagram->user_id = auth()->user()->id; // Guarda el ID del usuario autenticado como anfitrión
        $diagram->save();

        return redirect('/diagramas');
    }
}
