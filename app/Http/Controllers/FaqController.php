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
        // Fetch all FAQs from the database
        $faqs = Faq::all();

        // Return the view with the FAQs
        return view('faqs.faqs', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new FAQ
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

        // redirecionar para a lista de FAQs com uma mensagem de sucesso
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
        // procurar o FAQ pelo ID
        $faq = Faq::findOrFail($id);

        // retornar a view de edição com o FAQ encontrado
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

        // procurar o FAQ pelo ID e atualizar
        $faq = Faq::findOrFail($id);
        $faq->update($request->only('pergunta', 'resposta'));

        // redirecionar para a lista de FAQs com uma mensagem de sucesso
        return redirect()->route('faqs.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // procurar o FAQ pelo ID e apagar
        $faq = Faq::findOrFail($id);
        $faq->delete();
        // redirecionar para a lista de FAQs com uma mensagem de sucesso
        return redirect()->route('faqs.index')->with('success', 'FAQ deleted successfully.');
        //
    }

    //PARA A APLICAÇÃO ANDROID
    public function indexApi(Request $request)
    {
        // Fetch all FAQs from the database
        $faqs = Faq::all();

        // Return the FAQs as JSON
        return response()->json($faqs);
    }

    public function showApi($id)
    {
        // Find the FAQ by ID
        $faq = Faq::findOrFail($id);

        // Return the FAQ as JSON
        return response()->json($faq);
    }
}
