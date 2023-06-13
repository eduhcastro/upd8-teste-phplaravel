<?php

namespace App\Http\Controllers\Pages\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Show extends Controller
{



    private function formatDate($date): string
    {
        if (!is_null($date)) {
            $dateParts = explode("-", $date);
            $formattedDate = sprintf("%s/%s/%s", $dateParts[2], $dateParts[1], $dateParts[0]);
            return $formattedDate;
        }
        return "";
    }

    // public function showClientsPage(Request $request)
    // {
    //     return view('pages.client.show', [
    //         'clients' =>
    //             Client::query()
    //                 ->when($request->response, fn ($q) => $q
    //                 ->where('name', 'like', '%' . $request->response . '%'))

    //                 ->orderByDesc('created_at')
    //                 ->paginate(10)
    //     ]);
    // }

    public function showClientsPage(Request $request)
    {
        $validator = Validator::make($request->only(['cpf', 'nome', 'data_nascimento', 'sexo', 'endereco', 'estado', 'cidade']), [
            'cpf' => 'nullable|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
            'nome' => 'nullable|string',
            'data_nascimento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F',
            'endereco' => 'nullable|string',
            'estado' => 'nullable|string',
            'cidade' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            dd($validator);
            //return redirect()->back()->withErrors($validator)->withInput();
        }

        $cpf = $request->input('cpf');
        $nome = $request->input('nome');
        $dataNascimento = $request->input('data_nascimento');
        $sexo = $request->input('sexo');
        $endereco = $request->input('endereco');
        $estado = $request->input('estado');
        $cidade = $request->input('cidade');

        $clients = Client::query()
            ->when($cpf, fn ($query, $cpf) => $query->where('cpf', 'like', $cpf))
            ->when($nome, fn ($query, $nome) => $query->whereRaw('LOWER(name) like ?', ["%" . strtolower($nome) . "%"]))
            ->when($dataNascimento, fn ($query, $dataNascimento) => $query->where('date_birth', 'like', $dataNascimento))
            ->when($sexo, fn ($query, $sexo) => $query->where('sex', 'like', $sexo))
            ->when($endereco, fn ($query, $endereco) => $query->whereRaw('LOWER(address) like ?', ["%" . strtolower($endereco) . "%"]))
            ->when($estado, fn ($query, $estado) => $query->where('state', 'like', ["%$estado%"]))
            ->when($cidade, fn ($query, $cidade) => $query->where('city', 'like', ["%$cidade%"]))
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('pages.client.show', ['clients' => $clients]);
    }

    public function showClientsPageApi(Request $request)
    {
        $validator = Validator::make($request->only(['cpf', 'nome', 'data_nascimento', 'sexo', 'endereco', 'estado', 'cidade']), [
            'cpf' => 'nullable|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
            'nome' => 'nullable|string',
            'data_nascimento' => 'nullable|date',
            'sexo' => 'nullable|in:M,F',
            'endereco' => 'nullable|string',
            'estado' => 'nullable|string',
            'cidade' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $cpf = $request->input('cpf');
        $nome = $request->input('nome');
        $dataNascimento = $this->formatDate($request->input('data_nascimento'));
        $sexo = $request->input('sexo');
        $endereco = $request->input('endereco');
        $estado = $request->input('estado');
        $cidade = $request->input('cidade');


        $clients = Client::query()
            ->when($cpf, fn ($query, $cpf) => $query->where('cpf', 'like', $cpf))
            ->when($nome, fn ($query, $nome) => $query->whereRaw('LOWER(name) like ?', ["%" . strtolower($nome) . "%"]))
            ->when($dataNascimento, fn ($query, $dataNascimento) => $query->where('date_birth', 'like', $dataNascimento))
            ->when($sexo, fn ($query, $sexo) => $query->where('sex', 'like', $sexo))
            ->when($endereco, fn ($query, $endereco) => $query->whereRaw('LOWER(address) like ?', ["%" . strtolower($endereco) . "%"]))
            ->when($estado, fn ($query, $estado) => $query->where('state', 'like', ["%$estado%"]))
            ->when($cidade, fn ($query, $cidade) => $query->where('city', 'like', ["%$cidade%"]))
            ->orderByDesc('created_at')
            ->paginate(10);
        return ["data" => $clients];
    }




    public function deleteClientProcess(int $clientId)
    {
        try {
            $client = Client::findOrFail($clientId);
            $client->delete();

            return response()->json(null, 204);
        } catch (ModelNotFoundException $exception) {
            return response()->json(null, 500);
        }
    }
}
