<div class="px-3 py-2 bg-dark text-white page-header">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
            </a>

            <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                <li>
                    <a href="{{ route('books.index') }}" class="nav-link text-white">
                        <svg class="bi d-block mx-auto mb-1" width="24" height="24"></svg>
                        <span>Livros</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}" class="nav-link text-white">
                        <svg class="bi d-block mx-auto mb-1" width="24" height="24"></svg>
                        <span>Usuários</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('loans.index') }}" class="nav-link text-white">
                        <svg class="bi d-block mx-auto mb-1" width="24" height="24"></svg>
                        <span>Empréstimos</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

@extends('layouts.errors')