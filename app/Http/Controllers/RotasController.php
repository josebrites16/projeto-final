<?php

namespace App\Http\Controllers;

use App\Models\Rota;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RotasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obter parâmetros de pesquisa e filtro
        $search = $request->input('search');
        $zona = $request->input('zona');

        // Iniciar a consulta
        $query = Rota::query();

        // Aplicar filtro de pesquisa se fornecido
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                    ->orWhere('descricao', 'like', "%{$search}%");
            });
        }

        // Aplicar filtro por zona se fornecido
        if ($zona) {
            $query->where('zona', $zona);
        }

        // Executar a consulta
        $rotas = $query->get();

        // Obter todas as zonas para o dropdown do filtro
        $zonas = ['Sul', 'Centro', 'Norte'];

        return view('rotas', compact('rotas', 'zonas', 'search', 'zona'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obter todas as zonas para o dropdown
        $zonas = ['Sul', 'Centro', 'Norte'];
        // Retornar a view de criação com as zonas
        return view('create', compact('zonas'));
    }

    /**
     * Store a newly created resource in storage.
     * *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'distancia' => 'required|numeric|min:0',
            'coordenadas' => 'required|json',
            'zona' => 'required|in:Sul,Centro,Norte',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $rotaData = collect($validated)->except(['imagem'])->toArray();

        // Processar o upload da imagem se fornecida
        if ($request->hasFile('imagem')) {
            $imagemPath = $request->file('imagem')->store('rotas', 'public');
            $rotaData['imagem'] = $imagemPath;
        }

        Rota::create($rotaData);

        return redirect()->route('rotas.index')
            ->with('success', 'Rota criada com sucesso.');
    }

    /**
     * Display the specified resource.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(string $id)
    {
        $rota = Rota::findOrFail($id);
        return view('rota', compact('rota'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit(string $id)
    {
        $rota = Rota::findOrFail($id);
        $zonas = ['Sul', 'Centro', 'Norte'];
        return view('edit', compact('rota', 'zonas'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'distancia' => 'required|numeric|min:0',
            'zona' => 'required|in:Sul,Centro,Norte',
            'coordenadas' => 'required|json',
            'zona' => 'required|in:Sul,Centro,Norte',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $rotaData = collect($validated)->except(['imagem'])->toArray();

        $rota = Rota::findOrFail($id);

        
        $dadosAtualizados = collect($validated)->except(['imagem'])->toArray();

        // Substitui a imagem antiga, se uma nova for enviada
        if ($request->hasFile('imagem')) {
            // Apaga a imagem antiga
            if ($rota->imagem && Storage::disk('public')->exists($rota->imagem)) {
                Storage::disk('public')->delete($rota->imagem);
            }
    
            // Guarda a nova imagem
            $novaImagem = $request->file('imagem')->store('rotas', 'public');
            $dadosAtualizados['imagem'] = $novaImagem;
        }
    
        $rota->update($dadosAtualizados);

        return redirect()->route('rotas.show', $rota->id)
            ->with('success', 'Rota atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $rota = Rota::find($id);

        if (!$rota) {
            return redirect()->route('rotas.index')->with('error', 'Rota não encontrada.');
        }

        $rota->delete();

        return redirect()->route('rotas.index')->with('success', 'Rota eliminada com sucesso.');
    }
}
