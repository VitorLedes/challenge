<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Session;

/**
 * UserController
 * 
 * Controller for managing user creation and editing.
 */
class UserController extends Controller
{
    /**
     * Exibe a lista de usuários.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        
        $limit = 10;
        $users = User::search($request)->paginate($limit);

        $data = [
            'users' => $users,
        ];

        return view('users.index', $data);

    }

    /**
     * Exibe o formulário para criar um novo usuário.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View {
        return $this->form(new User());
    }

    /**
     * Exibe o formulário para editar um usuário existente.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id): RedirectResponse|View {
        
        $user = User::find($id);

        if ($id && is_numeric($id)) {

            if ($user) {
                return $this->form($user);
            }

            return redirect()->route('users.index')->with('error', 'Usuário não encontrado!');

        } else {
            return redirect()->route('users.index')->with('error', 'Id inválido!');
        }
        

    }

    /**
     * Insere um novo usuário.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function insert(Request $request): RedirectResponse {
        return $this->save($request, new User());
    }

    /**
     * Atualiza um usuário existente.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse {

        $user = User::find($request->id);

        if ($user) {
            return $this->save($request, $user);
        }

        return redirect()->route('users.index')->with('error', 'Usuário não encontrado!');

    }

    /**
     * Exclui um usuário.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request): RedirectResponse {
        $user = User::find($request->id);

        if ($user) {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
        } 

        return redirect()->route('users.index')->with('error', 'Usuário não encontrado!');

    }

    /**
     * Exibe o formulário de criação/edição de usuário.
     *
     * @param $user
     * @return \Illuminate\View\View
     */
    private function form($user): \Illuminate\View\View {

        $data = [
            'user' => $user,
        ];

        return view('users.create-edit', $data);
    }

    /**
     * Salva os dados do usuário.
     *
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function save(Request $request, $user): RedirectResponse {

        // Validando antes de  procurar o usuário pois caso falhe, não há necessidade de procurar no banco.
        $validator = $this->validation($request);
        
        if ($validator->fails()) {
            // Se a validação falhar, redireciona de volta com os erros.
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuário salvo com sucesso!');
    }

    /**
     * Valida os dados do usuário.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validation(Request $request): \Illuminate\Contracts\Validation\Validator {

        // Validando o e-mail, mas ignorando o usuário atual na validação de unicidade.
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . ($request->id ?? 'NULL') . ',id',
        ],[
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso.',
        ]);

        return $validator;
    }
}
