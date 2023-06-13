<?php

namespace App\Http\Controllers\Pages\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Edit extends Controller
{

  protected function rules(): array
  {
    return [
      'nome' => 'required|min:5|max:36|string',
      'nascimento' => 'required|date',
      'sexo' => 'required|in:"M","F"',
      'endereco' => 'required|min:5|max:50|string',
      'estado' => 'required|max:2|string',
      'cidade' => 'required|min:5|max:50|string',
      'cpf' => 'required|max:14|string'
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
    ];
  }

  public function editClientsPage(int $clientId)
  {
    $Cliente = Client::findOrFail($clientId);
    return view('pages.client.edit', compact('Cliente'));
  }

  public function editClientsProcess(Request $response)
  {
    $validator = Validator::make($response->all(), $this->rules(), $this->messages());

    if ($validator->fails()) {
      return response()->json([
        'status' => false,
        'message' => $validator->errors()->first()
      ], 422);
    }

    $client = Client::where('cpf', $response['cpf'])->first();

    if (!$client) {
      return response()->json([
        'status' => false,
        'message' => "Cliente não encontrado."
      ], 404);
    }

    $client->name = $response['nome'];
    $client->date_birth = $response['nascimento'];
    $client->sex = $response['sexo'];
    $client->address = $response['endereco'];
    $client->city = $response['cidade'];
    $client->state = $response['estado'];

    if ($client->save()) {
      return response()->json([
        'status' => true,
        'message' => "Cliente {$client->name} foi atualizado."
      ]);
    }

    return response()->json([
      'status' => false,
      'message' => "Erro ao atualizar cliente."
    ], 500);
  }
}
