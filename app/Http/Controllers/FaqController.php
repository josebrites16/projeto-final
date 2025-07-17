<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq; // Import the Faq model

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $faqs = Faq::all();
        return view('faqs.faqs', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validar os dados
        $request->validate([
            'pergunta' => 'required|string|max:255',
            'resposta' => 'required|string',
        ]);

        // criacao do FAQ
        Faq::create($request->all());

        // redirecionar para a lista de FAQs
        return redirect()->route('faqs.index')->with('success', 'FAQ created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $faq = Faq::findOrFail($id);
        return view('faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validar os dados
        $request->validate([
            'pergunta' => 'required|string|max:255',
            'resposta' => 'required|string',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($request->only('pergunta', 'resposta'));

        // redirecionar para a lista
        return redirect()->route('faqs.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();
        // redirecionar para a lista
        return redirect()->route('faqs.index')->with('success', 'FAQ deleted successfully.');
    }

    //PARA A APLICAÇÃO ANDROID
    public function indexApi(Request $request)
    {
        $faqs = Faq::all();
        return response()->json($faqs);
    }

    public function showApi($id)
    {
    
        $faq = Faq::findOrFail($id);
        return response()->json($faq);
    }
}
