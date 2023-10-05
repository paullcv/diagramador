<?php

namespace App\Http\Controllers;

use App\Models\Diagram;
use Illuminate\Http\Request;

class PizarraController extends Controller
{

    public function index(Diagram $diagram)
    {
        $contenidoJson = $diagram->contenido;
        return view('pizarra.index', compact('contenidoJson','diagram'));
    }

    public function savePizarra(Request $request)
    {

        $diagramaID = $request->diagram_id;
        // Obtén el contenido JSON del diagrama desde la solicitud
        $contenidoJson = $request->input('contenidoJson');

        // Encuentra o crea un registro en la tabla "diagram" (ajusta el nombre del modelo según corresponda)
        $diagram = Diagram::firstOrNew(['id' => 1]); // Puedes cambiar el criterio de búsqueda según tu aplicación

        // Actualiza el atributo "contenido" con el nuevo contenido JSON
        $diagram->contenido = $contenidoJson;

        // Guarda el registro en la base de datos
        $diagram->save();

        // Redirige al usuario a la página deseada después de guardar el diagrama
        return redirect('/diagramas');
    }
}
