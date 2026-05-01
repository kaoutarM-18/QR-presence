@extends('layouts.app')

@section('title', 'Liste des Filières')

@section('content')
<div class="container">
    <h2 class="mb-4">Filières</h2>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Filière</th>
                <th>Nombre d'étudiants</th>
            </tr>
        </thead>
        <tbody>
            @foreach($filieres as $filiere)
            <tr>
                <td>{{ $filiere->id_filiere }}</td>
                <td>{{ $filiere->nom_filiere }}</td>
                <td>{{ $filiere->etudiants_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection