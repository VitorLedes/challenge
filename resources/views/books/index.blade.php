@extends('layouts.default')

@section('content')

    <div class="page-books">

        <div class="filter-buttons d-flex gap-3 mb-2 justify-content-end mr-2">
            <div class="filter-btn">
                <button class="btn btn-primary">Exibir Filtros</button>
            </div>

            <div class="filter-btn">
                <a href="{{ route('books.create') }}" class="btn btn-primary">Cadastrar Livro</a>
            </div>

        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card mb-2 card-filters d-none">

            <form action="{{ route('books.index') }}" method="GET">

                <div class="filters">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search">Pesquise por autor ou título</label>
                                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}">
                            </div>
                        </div>
    
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="genre">Gênero</label>
                                <select class="form-control" id="genre" name="genre_id">
                                    <option value="">Selecione um gênero</option>
                                    @foreach ($genres as $genre)
                                        <option value="{{ $genre->id }}" {{ $genre->id == request('genre_id') ? 'selected' : '' }}>{{ $genre->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status_id">
                                    <option value="">Selecione um status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ $status->id == request('status_id') ? 'selected' : '' }}>{{ $status->name }}</option>
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
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Gênero</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ $book->id }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->genre_name }}</td>
                                <td>{{ $book->status_name }}</td>
                                <td>
                                    <div class="icons">
                                        <a href="{{ route('books.edit', $book->id) }}" 
                                           class="btn btn-icon btn-edit" 
                                           title="Editar Livro">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('books.delete', $book->id) }}" 
                                            method="POST" 
                                            class="delete-form" 
                                            onsubmit="return confirm('Tem certeza que deseja deletar este livro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-icon btn-delete" 
                                                    title="Deletar livro">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $books->links('pagination::bootstrap-4') }}

            </div>
        </div>

    </div>
    
@endsection