<?php

namespace App\Http\Controllers;

use App\BookStatusEnum;
use App\Models\Book;
use App\Models\BookStatus;
use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class BookController extends Controller
{
    /**
     * Exibe a lista de livros.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        
        $limit = 10;
        $books = Book::search($request)->paginate($limit);
        
        $genres = Genre::all();
        $statuses = BookStatus::all();

        $data = [
            'books' => $books,
            'genres' => $genres,
            'statuses' => $statuses,
        ];

        return view('books.index', $data);
    }

    /**
     * Exibe o formulário para criar um novo livro.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return $this->form(new Book());
    }

    /**
     * Exibe o formulário para editar um livro existente.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id): RedirectResponse|View
    {
        
        if ($id && is_numeric($id)) {
            
            $book = Book::find($id);

            if ($book) {
                return $this->form($book);
            }

            return redirect()->route('books.index')->with('error', 'Livro não encontrado!');

        } else {
            return redirect()->route('books.index')->with('error', 'Id inválido!');
        }
    }
    
    /**
     * Insere um novo livro.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request): RedirectResponse
    {
        $book = new Book();
        return $this->save($request, $book);
    }

    /**
     * Atualiza um livro existente.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $book = Book::find($request->id);

        if ($book) {
            return $this->save($request, $book);
        }

        return redirect()->route('books.index')->with('error', 'Livro não encontrado!');
    }

    /**
     * Exclui um livro.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request): RedirectResponse {
        $book = Book::find($request->id);

        if ($book) {
            $book->delete();
            return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso!');
        } 

        return redirect()->route('books.index')->with('error', 'Livro não encontrado!');
    }

    public function saveStatus(Request $request): RedirectResponse
    {
        $book = Book::find($request->id);

        if ($book) {

            $book->status_id = $request->status_id;
            $book->save();

            return redirect()->route('books.index')->with('success', 'Status do livro atualizado com sucesso!');
        }

        return redirect()->route('books.index')->with('error', 'Livro não encontrado!');
    }

    /**
     * Exibe o formulário de criação/edição de livro.
     *
     * @param Book $book
     * @return \Illuminate\Contracts\View\View
     */
    private function form($book): View
    {
        $genres = Genre::all();
        $statuses = BookStatus::all();

        $data = [
            'book' => $book,
            'genres' => $genres,
            'statuses' => $statuses,
        ];

        return view('books.create-edit', $data);
    }

    /**
     * Salva os dados do livro.
     *
     * @param Request $request
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    private function save(Request $request, Book $book): RedirectResponse
    {

        $validator = $this->validation($request);

        if ($validator->fails()) {
            return redirect()->route('books.index')->with('error', $validator->errors()->first());
        }

        $book->title = $request->title;
        $book->author = $request->author;
        $book->genre_id = $request->genre_id;
        $book->status_id = $request->status_id ?? BookStatusEnum::AVAILABLE;
        $book->save();

        return redirect()->route('books.index')->with('success', 'Livro salvo com sucesso!');
    }

    /**
     * Valida os dados do livro.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validation(Request $request)
    {
        return validator($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre_id' => 'required|integer|exists:genres,id',
        ],[
            'title.required' => 'O título é obrigatório.',
            'author.required' => 'O autor é obrigatório.',
        ]);
    }
}
