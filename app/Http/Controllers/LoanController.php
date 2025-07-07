<?php

namespace App\Http\Controllers;

use App\BookStatusEnum;
use App\LoanStatusEnum;
use App\Models\Book;
use App\Models\Loan;
use App\Models\LoanStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Validator;
/*
 * LoanController
 *
 * Controller for managing loans.
 */
class LoanController extends Controller
{
    /**
     * Exibe a lista de empréstimos.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $limit = 10;
        $loans = Loan::search($request)->paginate($limit);
            
        $statuses = LoanStatus::all();

        $data = [   
            'loans' => $loans,
            'statuses' => $statuses,
        ];

        return view('loans.index', $data);
    }

    /**
     * Exibe o formulário para criar ou editar um empréstimo.
     *
     * @param Loan $loan
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->form(new Loan());
    }

    /**
     * Exibe o formulário para criar ou editar um empréstimo.
     *
     * @param Loan $loan
     * @return \Illuminate\View\View
     */
    public function edit($id) {

        if ($id && is_numeric($id)) {

            $loan = Loan::find($id);

            if ($loan) {
                return $this->form($loan);
            } else {
                return redirect()->route('loans.index')->with('error', 'Empréstimo não encontrado.');
            }

        } else {
            return redirect()->route('loans.index')->with('error', 'ID inválido.');

        }


    }

    /**
     * Insere um novo empréstimo.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request) {
        return $this->save($request, new Loan());
    }

    /**
     * Edita um empréstimo já existente.
     *
     * @param Request $request
     * @param Loan $loan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request) {

        $loan = Loan::find($request->id);

        if ($loan) {
            return $this->save($request, $loan);
        }

        return redirect()->route('loans.index')->with('error', 'Empréstimo não encontrado.');
    }

    public function delete(Request $request) {

        $loan = Loan::find($request->id);

        if ($loan) {
            $loan->delete();
            return redirect()->route('loans.index')->with('success', 'Empréstimo excluído com sucesso.');
        }

        return redirect()->route('loans.index')->with('error', 'Empréstimo não encontrado.');

    }

    /**
     * Exibe o formulário para criar ou editar um empréstimo.
     * @param \App\Models\Loan $loan
     * @return \Illuminate\Contracts\View\View
     */
    private function form(Loan $loan)
    {
        $books = Book::getAvailableBooks($loan)->get();
        $users = User::all();

        $data = [
            'loan' => $loan,
            'statuses' => $this->getLoanStatusOptions($loan),
            'books' => $books,
            'users' => $users,
        ];

        return view('loans.create-edit', $data);
    }
    
    /**
     * Pega os status disponíveis para exibir no formulário
     * @param mixed $loan
     * @return Collection
     */
    private function getLoanStatusOptions($loan): Collection
    {
        $statuses = LoanStatus::all();

        // Caso esteja editando remova a opção "Pendente", e se a data do empréstimo for ANTES de hoje, remove o status "Atrasado"
        if ($loan->id) {
            foreach($statuses as $status) {
                $statuses = $statuses->reject(function ($s) {
                    return $s->id == LoanStatusEnum::PENDING;
                });

                if ($loan->return_date > now() && $status->id == LoanStatusEnum::DELAYED) {
                    $statuses = $statuses->reject(function ($s) {
                        return $s->id == LoanStatusEnum::DELAYED;
                    });
                }
            }
        }

        return $statuses;
    }
    
    /**
     * Salva um empréstimo (criação ou atualização).
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    private function save(Request $request, $loan)
    {
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $loan->user_id = $request->user_id;
            $loan->book_id = $request->book_id;
            $loan->return_date = $request->return_date;
            $loan->status_id = $request->status_id ?? LoanStatusEnum::PENDING;
            $loan->loan_date = now();
            $loan->save();

            $book = Book::find($loan->book_id);
            
            if ($loan->status_id == LoanStatusEnum::RETURNED) {
                $book->status_id = BookStatusEnum::AVAILABLE;
                $book->save();
                return redirect()->route('loans.index')->with('success', 'Empréstimo atualizado com sucesso.');
            }

            $book->status_id = BookStatusEnum::BORROWED;
            $book->save();

            return redirect()->route('loans.index')->with('success', 'Empréstimo salvo com sucesso.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao salvar empréstimo: ' . $e->getMessage());
        }
    }

    /**
     * Valida os dados do empréstimo.
     *
     * @return void
     */
    private function validation(Request $request): \Illuminate\Contracts\Validation\Validator {
        return Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'return_date' => 'required|date'
        ],[
            'user_id.required' => 'O campo usuário é obrigatório.',
            'user_id.exists' => 'O usuário selecionado não existe.',
            'book_id.required' => 'O campo livro é obrigatório.',
            'book_id.exists' => 'O livro selecionado não existe.',
            'return_date.required' => 'O campo data de devolução é obrigatório.',
            'return_date.date' => 'O campo data de devolução deve ser uma data válida.',
        ]);
    }

}
