<?php

namespace App\Http\Controllers;

use App\Models\Rota;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RotasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $zona = $request->input('zona');
        $query = Rota::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                    ->orWhere('descricao', 'like', "%{$search}%");
            });
        }
        if ($zona) {
            $query->where('zona', $zona);
        }
        $rotas = $query->get();
        $zonas = ['Sul', 'Centro', 'Norte'];

        return view('rotas', compact('rotas', 'zonas', 'search', 'zona'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $zonas = ['Sul', 'Centro', 'Norte'];
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
            'descricao_longa' => 'nullable|string',
            'distancia' => 'required|numeric|min:0',
            'coordenadas' => 'required|json',
            'zona' => 'required|in:Sul,Centro,Norte',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:102400',

            'pontos' => 'nullable|array',
            'pontos.*.titulo' => 'required|string|max:255',
            'pontos.*.descricao' => 'nullable|string',
            'pontos.*.coordenadas' => 'required|json',
            'pontos.*.midias.*' => 'file|mimes:mov,jpg,jpeg,png,mp4,mp3,wav,ogg,webm|max:102400',
        ]);

        $rotaData = collect($validated)->except(['imagem', 'pontos'])->toArray();

        $rotaData['descricaoLonga'] = $validated['descricao_longa'] ?? null;
        unset($rotaData['descricao_longa']);

        if ($request->hasFile('imagem')) {
            $rotaData['imagem'] = $request->file('imagem')->store('rotas', 'public');
        }

        $rota = Rota::create($rotaData);

        foreach ($request->input('pontos', []) as $index => $pontoData) {
            $ponto = $rota->pontos()->create([
                'titulo' => $pontoData['titulo'],
                'descricao' => $pontoData['descricao'] ?? '',
                'coordenadas' => $pontoData['coordenadas'],
            ]);

            if ($request->hasFile("pontos.{$index}.midias")) {
                foreach ($request->file("pontos.{$index}.midias") as $ficheiro) {
                    if (!$ficheiro->isValid()) continue;

                    $mime = $ficheiro->getMimeType();
                    $tipo = str_starts_with($mime, 'image/') ? 'imagem'
                        : (str_starts_with($mime, 'video/') ? 'video'
                            : (str_starts_with($mime, 'audio/') ? 'audio' : 'outro'));

                    $path = $ficheiro->store("pontos/{$tipo}s", 'public');

                    $ponto->midias()->create([
                        'tipo' => $tipo,
                        'caminho' => $path,
                    ]);
                }
            }
        }

        return redirect()->route('rotas.index')->with('success', 'Rota criada com sucesso.');
    }



    /**
     * Display the specified resource.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(string $id)
    {
        $rota = Rota::with('pontos')->findOrFail($id);
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
        'descricao_longa' => 'nullable|string',
        'distancia' => 'required|numeric|min:0',
        'zona' => 'required|in:Sul,Centro,Norte',
        'coordenadas' => 'required|json',
        'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:102400',
        'pontos' => 'nullable|array',
        'pontos.*.titulo' => 'required|string|max:255',
        'pontos.*.descricao' => 'nullable|string',
        'pontos.*.coordenadas' => 'required|json',
        'pontos.*.midias.*' => 'file|mimes:mov,jpg,jpeg,png,mp4,mp3,wav,ogg,webm|max:102400',
    ]);

    $rota = Rota::findOrFail($id);

    $dadosAtualizados = collect($validated)
        ->except(['imagem', 'pontos'])
        ->mapWithKeys(fn($v, $k) => [$k === 'descricao_longa' ? 'descricaoLonga' : $k => $v])
        ->toArray();

    if ($request->hasFile('imagem')) {
        if ($rota->imagem && Storage::disk('public')->exists($rota->imagem)) {
            Storage::disk('public')->delete($rota->imagem);
        }
        $dadosAtualizados['imagem'] = $request->file('imagem')->store('rotas', 'public');
    }

    $rota->update($dadosAtualizados);

    $idsRecebidos = [];

    foreach ($request->input('pontos', []) as $index => $pontoData) {
        if (isset($pontoData['id'])) {
            $ponto = $rota->pontos()->find($pontoData['id']);
            if ($ponto) {
                $ponto->update([
                    'titulo' => $pontoData['titulo'],
                    'descricao' => $pontoData['descricao'] ?? '',
                    'coordenadas' => $pontoData['coordenadas'],
                ]);
                $idsRecebidos[] = $ponto->id;
            }
        } else {
            $ponto = $rota->pontos()->create([
                'titulo' => $pontoData['titulo'],
                'descricao' => $pontoData['descricao'] ?? '',
                'coordenadas' => $pontoData['coordenadas'],
            ]);
            $idsRecebidos[] = $ponto->id;
        }

        if ($request->hasFile("pontos.{$index}.midias")) {
            foreach ($request->file("pontos.{$index}.midias") as $ficheiro) {
                if (!$ficheiro->isValid()) continue;

                $mime = $ficheiro->getMimeType();
                $tipo = str_starts_with($mime, 'image/') ? 'imagem'
                    : (str_starts_with($mime, 'video/') ? 'video'
                        : (str_starts_with($mime, 'audio/') ? 'audio' : 'outro'));

                $path = $ficheiro->store("pontos/{$tipo}s", 'public');

                $ponto->midias()->create([
                    'tipo' => $tipo,
                    'caminho' => $path,
                ]);
            }
        }
    }

    $rota->pontos()->whereNotIn('id', $idsRecebidos)->delete();

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


    //Para a aplicação Android

    public function getRotas()
    {
        $rotas = Rota::with('pontos')->get();
        return response()->json($rotas);
    }

    public function indexApi()
    {
        $search = request()->query('search');
        $query = Rota::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                    ->orWhere('descricao', 'like', "%{$search}%")
                    ->orWhere('zona', 'like', "%{$search}%");
            });
        }
        $rotas = $query->with('pontos')->get();
        return response()->json($rotas);
    }

    public function getRotaApi($id)
    {
        $rota = Rota::with('pontos')->find($id);
        if (!$rota) {
            return response()->json(['message' => 'Rota não encontrada'], 404);
        }
        return response()->json($rota);
    }

    public function getRotasByZona($zona)
    {
        $rotas = Rota::where('zona', $zona)->with('pontos')->get();
        return response()->json($rotas);
    }
}
