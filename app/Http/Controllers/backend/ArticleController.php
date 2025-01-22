<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Availability;
use App\Models\Document;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.resources.article.index', [
            'articles' => Article::all(),
            'title' => 'Liste des Articles'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.resources.article.form', [
            'article' => new Article(),
            'subcategories' => Subcategory::all(),
            'availabilities' => Availability::all(),
            'title' => "Ajoutez un Article",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'ugs' => 'required|unique:articles,ugs',
            'subcategory_id' => 'required|array',
            'subcategory_id.*' => 'exists:subcategories,id',
            'availability_id' => 'nullable|exists:availabilities,id',
            'content' => 'nullable|string',
            'document' => 'nullable|array',
            'document.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:1024',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        /**
         * @var Article $article
         */
        $article = Article::create([
            'name' => Str::lower($request->input('name')),
            'ugs' => $request->input('ugs', null),
            'slug' => Str::slug($request->input('mane'), '-'),
            'content' => $request->input('content', $request->input('name')),
            'availability_id' => $request->input('availability_id', null),
        ]);

        if($article){

            $article->subcategories()->sync($request->input('subcategory_id', []));

            if ($request->hasFile('document')) {
                $files = $request->file('document');
                $this->saveDocument($files, $article, 'image');
            }

            return redirect()->route('article.index')->with('success', "Action reusit");

        }

        return redirect()->route('article.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('backend.resources.article.form', [
            'article' => $article,
            'subcategories' => Subcategory::all(),
            'availabilities' => Availability::all(),
            'title' => "Modifiez un Article",
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'ugs' => 'required|string|max:10',
            'subcategory_id' => 'required|array',
            'subcategory_id.*' => 'exists:subcategories,id',
            'availability_id' => 'nullable|exists:availabilities,id',
            'content' => 'nullable|string',
            'document' => 'nullable|array',
            'document.*' => 'image|mimes:jpeg,jpg,png,gif,webp|max:1024',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        /**
         * @var Article $article
         */
        $isUpdate = $article->update([
            'name' => Str::lower($request->input('name')),
            'ugs' => $request->input('ugs', null),
            'slug' => Str::slug($request->input('mane'), '-'),
            'content' => $request->input('content', $request->input('name')),
            'availability_id' => $request->input('availability_id', null),
        ]);

        if($isUpdate){

            $article->subcategories()->sync($request->input('subcategory_id', []));

            if ($request->hasFile('document')) {
                $files = $request->file('document');
                $this->saveDocument($files, $article, 'image');
            }

            return redirect()->route('article.index')->with('success', "Action reusit");

        }

        return redirect()->route('article.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        foreach ($article->documents as $document) {
            $this->deleteImage($document);
        }

        if($article->delete()){
            return redirect()->route('article.index')->with('success', "Action reusit");
        }
        return redirect()->route('article.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    public function trashed(){
        $articles = Article::onlyTrashed()->get();

        return view('backend.resources.article.index', [
            'articles' => $articles,
            'title' => 'Liste des Articles supprimés'
        ]);

    }

    public function restore(string $id){

        $article = Article::withTrashed()->find($id);
        if($article->restore()){
            return redirect()->route('article.index')->with('success', 'Réstauration réussit');
        }
        return back()->with('error', 'Echec de réstauration');

    }

    private function moveImage($file)
    {
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('Ymd_His');

        $path_file = (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/resources/articles/'), $path_file);

        return "assets/resources/articles/" . $path_file;
    }

    // Méthode pour supprimer une image
    private function deleteImage($path)
    {
        if ( file_exists( public_path($path) ) ) {
            unlink(public_path($path));
        }
    }

    private function saveDocument($files, Article $article, string $type){

        if (is_array($files)) {

            foreach ($files as $file) {
                $documentPath = $this->moveImage($file);
                $document = new Document(['path' => $documentPath, 'type' => $type]);
                $article->documents()->save($document);
            }

        } else {

            $documentPath = $this->moveImage($files);
            $document = new Document(['path' => $documentPath, 'type' => $type]);
            $article->documents()->save($document);

        }
    }

    public function uploadDocument(Request $request, Article $article){

        if ($request->hasFile('document')) {
            $files = $request->file('document');
            //dd($files);
            if (is_array($files)) {
                foreach ($files as $file) {
                    $documentPath = $this->moveImage($file);
                    $document = new Document(['type' => 'image', 'path' => $documentPath]);
                    $article->documents()->save($document);
                    //dump($imagePath);
                }
            } else {
                $documentPath = $this->moveImage($files);
                $document = new Document(['type' => 'image', 'path' => $documentPath]);
                $article->documents()->save($document);
            }
            return response()->json(['message' => 'Votre Image a bien été mis à jour', 'code' => 0]);
        }
        return response()->json(['message' => 'Aucune image trouvée.', 'code' => 1]);
    }
}
