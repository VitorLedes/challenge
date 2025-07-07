@extends('layouts.default')

@section('content')

    <div class="page-books create-edit">

        <h1>{{ $book->id ? 'Editar Livro' : 'Cadastrar Livro' }}</h1>

        <form action="{{ $book->id ? route('books.update', $book->id) : route('books.insert') }}" method="POST">

            @csrf

            @if($book->id)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Título</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $book->title }}" required placeholder="Título do livro">
                    </div>
                </div>
            </div>

            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="genre">Gênero</label>
                        <select name="genre_id" id="genre" class="form-control">
                            <option value="">Selecione um gênero</option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->id }}" {{ $book->genre_id == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="author">Autor</label>
                        <input type="text" class="form-control" id="author" name="author" value="{{ $book->author }}" required placeholder="Nome do autor">
                    </div>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>

        </form>

    </div>

@endsection