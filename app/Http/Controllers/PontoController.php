<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rota;


class PontoController extends Controller
{
    public function create(Rota $rota)
    {
        return view('pontos.create', compact('rota'));
    }

    public function store(Request $request, Rota $rota)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'coordenadas' => 'required|json',
            'imagens.*' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $ponto = $rota->pontos()->create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'coordenadas' => $request->coordenadas,
        ]);

        // Verifica se foram enviadas imagens
        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imagem) {
                $path = $imagem->store('pontos', 'public'); // Guardar na pasta 'storage/app/public/pontos'
                $ponto->imagens()->create(['caminho' => $path]);
            }
        }

        return redirect()->route('rotas.show', $rota)->with('success', 'Ponto adicionado!');
    }
}
