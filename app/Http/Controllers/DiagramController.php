<?php

namespace App\Http\Controllers;

use App\Models\Diagram;
use App\Models\Invited;
use App\Models\User;
use Illuminate\Http\Request;

class DiagramController extends Controller
{

    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */

    // mostrar los diagramas
    public function index()
    {

        $diagramas = Diagram::where('user_id', auth()->user()->id)->get();
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

        $this->validate($request, $rules, $messages);
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

        $notificacion = 'El diagrama se creo correctamente.';

        return redirect('/diagramas')->with(compact('notificacion'));
    }

    // ir a la vista de editar
    public function edit(Diagram $diagram)
    {
        return view('diagrams.edit', compact('diagram'));
    }

    // editar un diagrama
    public function update(Request $request, Diagram $diagram)
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

        $this->validate($request, $rules, $messages);
        // Validar los datos de entrada
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'nullable',
            'contenido' => 'json|nullable',
        ]);


        $diagram->titulo = $request->input('titulo');
        $diagram->descripcion = $request->input('descripcion');
        $diagram->contenido = $request->input('contenido');
        $diagram->user_id = auth()->user()->id; // Guarda el ID del usuario autenticado como anfitrión
        $diagram->save();

        $notificacion = 'El diagrama se actualizo correctamente.';

        return redirect('/diagramas')->with(compact('notificacion'));
    }

    //Eliminar diagrama
    public function destroy(Diagram $diagram)
    {
        $tituloEliminar = $diagram->titulo;
        $diagram->delete();

        $notificacion = 'El diagrama ' . $tituloEliminar . ' se elimino correctamente.';
        return redirect('/diagramas')->with(compact('notificacion'));
    }

    // Invitar al diagrama
    public function invitar(Diagram $diagram)
    {
        // Obtener los IDs de los usuarios invitados al diagrama
        $invitedUserIds = $diagram->inviteds->pluck('user_id')->toArray();

        // Filtrar la lista de usuarios disponibles para excluir a los invitados
        $users = User::where('id', '!=', auth()->user()->id)
            ->whereNotIn('id', $invitedUserIds)
            ->get();

        return view('invitation.index', compact('diagram', 'users'));
    }

    // enviar datos para crear la invitacion
    public function sendInvitation(Request $request)
    {
        // Crear una nueva invitación
        $invitacion = new Invited();
        $invitacion->user_id = $request->user_id;
        $invitacion->diagram_id = $request->diagram_id;
        $invitacion->save();

        return redirect('/diagramas');
    }
}
