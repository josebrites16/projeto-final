<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rota;
use App\Models\Ponto;

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
            'imagens.*' => 'image|mimes:jpg,png,jpeg|max:102400',
            'videos.*' => 'mimetypes:video/mp4,video/quicktime|max:204800',
            'audios.*' => 'mimetypes:audio/mpeg,audio/wav|max:102400'
        ]);

        $ponto = $rota->pontos()->create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'coordenadas' => $request->coordenadas,
        ]);

        // Verifica se foram enviadas imagens
        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imagem) {
                $path = $imagem->store('pontos', 'public');
                $ponto->imagens()->create(['caminho' => $path]);
            }
        }

        return redirect()->route('rotas.show', $rota)->with('success', 'Ponto adicionado!');
    }

    // Métodos para a API

    /**
     * Retorna todos os pontos de uma rota específica (para Android)
     */
    public function indexApi(Rota $rota)
    {
        $pontos = $rota->pontos()->with('midias')->get();
        return response()->json($pontos);
    }

    /**
     * Cria um novo ponto turístico via API (para Android)
     */
    public function storeApi(Request $request, Rota $rota)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'coordenadas' => 'required|json',
            'imagens.*' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'videos.*' => 'nullable|mimetypes:video/mp4,video/quicktime|max:20480',
            'audios.*' => 'nullable|mimetypes:audio/mpeg,audio/wav|max:10240'
        ]);

        $ponto = $rota->pontos()->create([
            'titulo' => $validated['titulo'],
            'descricao' => $validated['descricao'] ?? '',
            'coordenadas' => $validated['coordenadas'],
        ]);

        // Processa mídias agrupadas
        $tipos = [
            'imagens' => 'imagem',
            'videos' => 'video',
            'audios' => 'audio',
        ];

        foreach ($tipos as $campo => $tipo) {
            if ($request->hasFile($campo)) {
                foreach ($request->file($campo) as $ficheiro) {
                    $path = $ficheiro->store("pontos/{$tipo}s", 'public');
                    $ponto->midias()->create([
                        'tipo' => $tipo,
                        'caminho' => $path,
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'Ponto criado com sucesso',
            'ponto' => $ponto->load('midias')
        ], 201);
    }

    public function edit(Rota $rota, Ponto $ponto)
    {
        return view('pontos.edit', compact('rota', 'ponto'));
    }

    public function destroy(Ponto $ponto)
    {
        $ponto->midias()->delete();
        $ponto->delete();

        return back()->with('success', 'Ponto eliminado com sucesso!');
    }

    public function update(Request $request, Ponto $ponto)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'coordenadas' => 'required|json',
            'imagens.*' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'videos.*' => 'nullable|mimetypes:video/mp4,video/quicktime|max:20480',
            'audios.*' => 'nullable|mimetypes:audio/mpeg,audio/wav|max:10240',
        ]);

        $ponto->update([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'coordenadas' => $request->coordenadas,
        ]);

        // Remover mídias selecionadas
        if ($request->filled('remover_midias')) {
            foreach ($request->remover_midias as $midiaId) {
                $midia = $ponto->midias()->find($midiaId);
                if ($midia) {
                    \Storage::disk('public')->delete($midia->caminho);
                    $midia->delete();
                }
            }
        }

        // Processar novas mídias
        $tipos = [
            'imagens' => 'imagem',
            'videos' => 'video',
            'audios' => 'audio',
        ];

        foreach ($tipos as $campo => $tipo) {
            if ($request->hasFile($campo)) {
                foreach ($request->file($campo) as $ficheiro) {
                    if (!$ficheiro->isValid()) continue;

                    $path = $ficheiro->store("pontos/{$tipo}s", 'public');

                    $ponto->midias()->create([
                        'tipo' => $tipo,
                        'caminho' => $path,
                    ]);
                }
            }
        }

        // Verifica se ainda tem pelo menos uma imagem
        $temImagem = $ponto->midias()->where('tipo', 'imagem')->exists();
        if (!$temImagem) {
            return back()->withErrors(['imagens' => 'O ponto precisa ter pelo menos uma imagem.']);
        }

        return redirect()->route('rotas.show', $ponto->rota_id)->with('success', 'Ponto atualizado com sucesso!');
    }


    /**
     * Retorna um ponto específico via API (para Android)
     */
    public function showApi($id)
    {
        $ponto = Ponto::with('midias')->find($id);

        if (!$ponto) {
            return response()->json(['message' => 'Ponto não encontrado'], 404);
        }

        return response()->json($ponto);
    }



    //api
    public function getPontosByRotaId($rotaId)
    {
        $pontos = Ponto::with('midias')->where('rota_id', $rotaId)->get();

        $pontosTransformados = $pontos->map(function ($ponto) {
            return [
                'id' => $ponto->id,
                'titulo' => $ponto->titulo,
                'descricao' => $ponto->descricao,
                'coordenadas' => $ponto->coordenadas,
                'rotaId' => $ponto->rota_id,
                'midias' => $ponto->midias->map(function ($midia) {
                    return [
                        'id' => $midia->id,
                        'tipo' => $midia->tipo,
                        'caminho' => secure_asset('storage/' . $midia->caminho)
                    ];
                }),
            ];
        });

        return response()->json($pontosTransformados);
    }
}
