<?php

namespace App\Http\Controllers\Pages\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Add extends Controller
{

    private function validateCpf($cpf)
    {
        $cpf = preg_replace("/[^0-9]/", "", $cpf);

        if (strlen($cpf) !== 11 || !is_numeric($cpf)) {
            return false;
        }

        if (
            $cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999'
        ) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }



    protected function rules(): array
    {
        Validator::extend('validCpf', function ($attribute, $value) {
            return $this->validateCpf($value);
        });
        return [
            'nome' => 'required|min:5|max:36|string',
            'nascimento' => 'required|date',
            'sexo' => 'required|in:"M","F"',
            'endereco' => 'required|min:5|max:50|string',
            'estado' => 'required|max:2|string',
            'cidade' => 'required|min:5|max:50|string',
            'cpf' => 'required|max:14|string|validCpf|unique:clients,cpf'
        ];
    }

    protected function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O campo nome deve ter no mínimo 5 caracteres.',
            'nome.max' => 'O campo nome deve ter no máximo 36 caracteres.',
            'nome.string' => 'O campo nome deve ser uma string.',
            'nascimento.required' => 'O campo nascimento é obrigatório.',
            'nascimento.date' => 'O campo nascimento deve ser uma data válida.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'sexo.in' => 'O campo sexo deve ser "M" (masculino) ou "F" (feminino).',
            'endereco.required' => 'O campo endereço é obrigatório.',
            'endereco.min' => 'O campo endereço deve ter no mínimo 5 caracteres.',
            'endereco.max' => 'O campo endereço deve ter no máximo 50 caracteres.',
            'endereco.string' => 'O campo endereço deve ser uma string.',
            'estado.required' => 'O campo estado é obrigatório.',
            'estado.max' => 'O campo estado deve ter no máximo 2 caracteres.',
            'estado.string' => 'O campo estado deve ser uma string.',
            'cidade.required' => 'O campo cidade é obrigatório.',
            'cidade.min' => 'O campo cidade deve ter no mínimo 5 caracteres.',
            'cidade.max' => 'O campo cidade deve ter no máximo 50 caracteres.',
            'cidade.string' => 'O campo cidade deve ser uma string.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.max' => 'O campo CPF deve ter no máximo 14 caracteres.',
            'cpf.string' => 'O campo CPF deve ser uma string.',
            'cpf.unique' => 'O CPF fornecido já está em uso.',
            'cpf.valid_cpf' => 'O numero do CPF está invalido.',
        ];
    }

    public function addClientsPage()
    {
        return view('pages.client.add');
    }

    public function addClientsProcess(Request $response)
    {


        $validator = Validator::make($response->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $client = new Client();
        $client->name = $response['nome'];
        $client->date_birth = $response['nascimento'];
        $client->sex = $response['sexo'];
        $client->cpf = $response['cpf'];
        $client->address = $response['endereco'];
        $client->city = $response['cidade'];
        $client->state = $response['estado'];
        if ($client->save()) {
            return response()->json([
                'status' => true,
                'message' => "Cliente {$client->name}, foi cadastrado."
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => "Erro ao cadastrar cliente."
        ], 500);
    }
}
