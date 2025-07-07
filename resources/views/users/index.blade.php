@extends('layouts.default')

@section('content')

    <div class="page-users">

        <div class="filter-buttons d-flex gap-3 mb-2 justify-content-end mr-2">
            <div class="filter-btn">
                <button class="btn btn-primary">Exibir Filtros</button>
            </div>

            <div class="filter-btn">
                <a href="{{ route('users.create') }}" class="btn btn-primary">Cadastrar Usuário</a>
            </div>

        </div>
        
        <div class="card mb-2 card-filters d-none">

            <form action="{{ route('users.index') }}" method="GET">

                <div class="filters">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search">Pesquise por nome ou email</label>
                                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}">
                            </div>
                        </div>
                    </div>
    
                    <div class="buttons">
                        <button class="btn btn-primary" type="submit">Filtrar</button>
                        <button class="btn btn-primary clear-filters">Limpar</button>
                    </div>
    
                </div>
            </form>


        </div>
            
        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="icons">
                                        <a href="{{ route('users.edit', $user->id) }}" 
                                           class="btn btn-icon btn-edit" 
                                           title="Editar usuário">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('users.delete', $user->id) }}" 
                                            method="POST" 
                                            class="delete-form" 
                                            onsubmit="return confirm('Tem certeza que deseja deletar este usuário?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-icon btn-delete" 
                                                    title="Deletar usuário">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $users->links('pagination::bootstrap-4') }}

            </div>
        </div>

    </div>
    
@endsection