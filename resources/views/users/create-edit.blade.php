@extends('layouts.default')

@section('content')

    <div class="page-users create-edit">

        <h1>{{ $user->id ? 'Editar Usuário' : 'Cadastrar Usuário' }}</h1>

        <form action="{{ $user->id ? route('users.update', $user->id) : route('users.insert') }}" method="POST">

            @csrf

            @if($user->id)
                @method('PUT')
            @endif
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="genre">Email</label>
                        <input type="text" value="{{ $user->email }}" class="form-control" id="email" name="email" required placeholder="Email do usuário">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required placeholder="Nome do usuário">
                    </div>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>

        </form>

    </div>

@endsection