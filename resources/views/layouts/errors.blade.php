@if (isset($errors) && $errors->isNotEmpty())
    <div class="alert alert-danger">
        <div class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    </div>
@endif