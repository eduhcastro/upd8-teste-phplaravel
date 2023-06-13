<?php

namespace App\Http\Controllers\Pages\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class Login extends Controller
{
    protected function rules(): array
    {
        return [
            'username' => 'required|min:5|max:16|exists:users,username',
            'password' => 'required|min:3|max:16',
        ];
    }

    protected function messages(): array
    {
        return [
            'username.required' => 'Informe um usuario.',
            'username.min' => 'Informe um usuario valido de no minimo :min caracteres.',
            'username.max' => 'O usuario deve ter no maximo :max caracteres.',
            'username.exists' => 'O usuario não existente',
            'password.required' => 'Informe uma senha.',
            'password.min' => 'Informe uma senha valida de no minimo :min caracteres.',
            'password.max' => 'A senha deve ter no maximo :max caracteres.',
        ];
    }

    public function loginPage()
    {
        // dd(bcrypt('12345'));
        return view('pages.auth.login');
    }

    public function loginProcess(Request $request)
    {
        $validateForm = $request->validate($this->rules(), $this->messages());
        $user = User::where('username', $validateForm['username'])->firstOrFail();
        if (Hash::check($validateForm['password'], $user->password)) {
            Auth::loginUsingId($user->id);
            
            return response()->json([
                'status' => true,
                'message' => 'Login bem sucedido',
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Usuário ou senha inválidos'
        ], 401);
    }

    public function logoutProcess()
    {
        Auth::logout();
        Alert::toast('Você foi desconectado', 'info');
        return redirect()->route('loginPage');
    }
}
