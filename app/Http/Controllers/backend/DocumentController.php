<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document, bool $isMultiple)
    {
        //dd($document, $isMultiple);


        if($document->documentable_type === 'App\Models\Article'){
            $this->deleteImage($document->path);
            $document->delete();
        }else{

            $this->deleteImage($document->path);

            if($document->delete()){
                return view('backend.layouts.file', ['isMultiple' => $isMultiple])->render();
            }else{
                return response()->json(['message' => "Impossible de supprimer l'image", 'code' => 1]);
            }
        }

    }

    private function deleteImage($path)
    {
        if ( file_exists( public_path($path) ) ) {
            unlink(public_path($path));
        }
    }

    public function updateDocumentOrder(Request $request){
        //dd($request->all());
        $imageIds = json_decode($request->input('imageIds'));
        $articleId = $request->input('article_id');

        // Récupérez l'article associé
        $article = Article::findOrFail($articleId);

        // Récupérez les images liées à l'article dans l'ordre actuel
        $images = $article->documents()->where('type', 'image')->get();


        // Mettez à jour l'ordre des images en fonction des identifiants triés
        foreach ($imageIds as $index => $imageId) {
            $image = $images->where('id', $imageId)->first();

            if ($image) {
                $image->update(['priority' => $index + 1]);
            }
        }
        // Retournez une réponse appropriée (par exemple, un message de succès)
        return response()->json(['message' => 'L\'ordre des images a été mis à jour avec succès.', 'code' => 0]);
    }
    public function updateDocumentQuote(Request $request){
        //dd($request->all());
        $imageIds = json_decode($request->input('imageIds'));
        $articleId = $request->input('article_id');

        // Récupérez l'article associé
        $article = Article::findOrFail($articleId);

        // Récupérez les images liées à l'article dans l'ordre actuel
        $images = $article->documents()->where('type', 'image')->get();

        // Mettez à jour l'ordre des images en fonction des identifiants triés
        foreach ($imageIds as $index => $imageId) {
            $image = $images->where('id', $imageId)->first();
            if ($image) {
                $image->update(['priority' => $index + 1]);
            }
        }
        // Retournez une réponse appropriée (par exemple, un message de succès)
        return response()->json(['message' => 'L\'ordre des images a été mis à jour avec succès.', 'code' => 0]);
    }
}
