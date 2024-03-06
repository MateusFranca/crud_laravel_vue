<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function __construct(Cliente $cliente) {
        $this->cliente = $cliente;
    }

    public function index()
    {
        $clientes = $this->cliente->all();
        return response()->json($clientes, 200);
    }

    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        return  response()->json($cliente, 200);
    }

    public function store(Request $request)
    {
        $request->validate(Cliente::$rules, Cliente::$messages);

        $fotoURL = $request->file('foto')->store('public/fotos');
        $fotoURL = str_replace('public/', 'storage/', $fotoURL);

        $cliente = Cliente::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'sexo' => $request->sexo,
            'foto' => $fotoURL,
        ]);

        return response()->json($cliente, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate(Cliente::$rules, Cliente::$messages);
        
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        if ($request->hasFile('foto')) {
            $request->validate(['foto' => 'image']);
            
            if ($cliente->foto) {
                Storage::delete(str_replace('storage/', 'public/', $cliente->foto));
            }

            $fotoURL = $request->file('foto')->store('public/fotos');
            $fotoURL = str_replace('public/', 'storage/', $fotoURL);
            $cliente->foto = $fotoURL;
        }

        $cliente->update($request->except('foto'));

        return response()->json($cliente, 200);
    }

    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado'], 404);
        }

        if ($cliente->foto) {
            Storage::delete(str_replace('storage/', 'public/', $cliente->foto));
        }

        $cliente->delete();

        return response()->json(['message' => 'Cliente excluído com sucesso'], 200);
    }
}
