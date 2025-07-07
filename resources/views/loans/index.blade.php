@extends('layouts.default')

@section('content')

    <div class="page-loans">

        <div class="filter-buttons d-flex gap-3 mb-2 justify-content-end mr-2">
            <div class="filter-btn">
                <button class="btn btn-primary">Exibir Filtros</button>
            </div>

            <div class="filter-btn">
                <a href="{{ route('loans.create') }}" class="btn btn-primary">Cadastrar Empréstimo</a>
            </div>

        </div>
        
        <div class="card mb-2 card-filters d-none">

            <form action="{{ route('loans.index') }}" method="GET">

                <div class="filters">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="user_search">Pesquise por nome ou email</label>
                                <input type="text" class="form-control" id="user_search" name="user_search" value="{{ request('user_search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="book_search">Pesquise por título ou autor de livro</label>
                                <input type="text" class="form-control" id="book_search" name="book_search" value="{{ request('book_search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status_id">Status</label>
                                <select class="form-control" id="status_id" name="status_id">
                                    <option value="">Selecione um status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
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
                            <th>Livro</th>
                            <th>Autor do livro</th>
                            <th>Status</th>
                            <th>Devolução</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $loan)
                            <tr>
                                <td>{{ $loan->id }}</td>
                                <td>{{ $loan->user_name }}</td>
                                <td>{{ $loan->user_email }}</td>
                                <td>{{ $loan->book_title }}</td>
                                <td>{{ $loan->book_author }}</td>
                                <td>{{ $loan->status_name }}</td>
                                <td>{{ $loan->return_date }}</td>
                                <td>
                                    <div class="icons">
                                        <a href="{{ route('loans.edit', $loan->id) }}" 
                                           class="btn btn-icon btn-edit" 
                                           title="Editar Empréstimo">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('loans.delete', $loan->id) }}" 
                                            method="POST" 
                                            class="delete-form" 
                                            onsubmit="return confirm('Tem certeza que deseja deletar este Empréstimo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-icon btn-delete" 
                                                    title="Deletar Empréstimo">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $loans->links('pagination::bootstrap-4') }}

            </div>
        </div>

    </div>
    
@endsection