@extends('layouts.default')

@section('content')

    <div class="page-loans create-edit">

        <h1>{{ $loan->id ? 'Editar Empréstimo' : 'Cadastrar Empréstimo' }}</h1>

        <form action="{{ $loan->id ? route('loans.update', $loan->id) : route('loans.insert') }}" method="POST">

            @csrf

            @if($loan->id)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="book_id">Selecione um livro</label>
                        <select name="book_id" id="book_id" class="form-control" required>
                            <option value="">Selecione uma opção</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->id }}" {{ $loan->book_id == $book->id ? 'selected' : '' }}>{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="user_id">Selecione um usuário</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $loan->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="return_date" style="margin-bottom: 5px;">Data de Devolução</label>
                        <input type="date" name="return_date" id="return_date" class="form-control" required {{ $loan->return_date ? 'value=' . $loan->return_date : '' }}>
                    </div>
                </div>

                @if ($loan->id)
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status_id" style="margin-bottom: 5px;">Selecione um status</label>
                            <select name="status_id" id="status_id" class="form-control" required>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $loan->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                    
                @endif

            </div>  

            <button type="submit" class="btn btn-primary">Salvar</button>

        </form>

    </div>

@endsection