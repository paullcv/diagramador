@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Diagramas</h3>
                </div>
                <div class="col text-right">
                    <a href="{{ url('/diagramas/create') }}" class="btn btn-sm btn-primary">Nuevo Diagrama</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if (session('notificacion'))
                <div class="alert alert-success" role="alert">
                    {{ session('notificacion') }}
                </div>
            @endif
        </div>

        <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Anfitrion</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($diagramas as $diagrama)
                        <tr>
                            <th scope="row">
                                {{ $diagrama->id }}
                            </th>
                            <td>
                                {{ $diagrama->titulo }}
                            </td>
                            <td>
                                {{ $diagrama->descripcion }}
                            </td>
                            <td>
                                {{ $diagrama->user->name }}
                            </td>
                            <td>
                                <form action="{{ url('/diagramas/' . $diagrama->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ url('/diagramas/' . $diagrama->id . '/edit') }}"
                                        class="btn btn-sm btn-primary">Editar</a>
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    <a href="url" class="btn btn-sm btn-info">Ir al Diagrama</a>
                                    <a href="url" class="btn btn-sm btn-warning">Invitar</a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
