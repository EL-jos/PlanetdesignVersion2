<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.resources.category.index', [
            'categories' => Category::all(),
            'title' => 'Liste des Categories'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.resources.category.form', [
            'category' => new Category(),
            'title' => "Ajoutez une catégorie",
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
            'document' => 'required|image|mimes:jpeg,jpg,png|max:1024',
            'content' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $category = Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('mane'), '-'),
            'content' => $request->input('content'),
        ]);

        if ($category){

            if ($request->hasFile('document')) {
                $files = $request->file('document');
                $this->saveDocument($files, $category, 'image');
            }

            return redirect()->route('category.index')->with('success', "Action reusit");

        }

        return redirect()->route('category.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('backend.resources.category.form', [
            'category' => $category,
            'title' => "Modifiez une catégorie",
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'document' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'content' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $isUpdate = $category->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-'),
            'content' => $request->input('content'),
        ]);

        if ($isUpdate){

            if ($request->hasFile('document')) {
                $files = $request->file('document');
                $this->saveDocument($files, $category, 'image');
            }

            return redirect()->route('category.index')->with('success', "Action reusit");

        }

        return redirect()->route('category.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->delete()){
            return redirect()->route('category.index')->with('success', "Action reusit");
        }
        return redirect()->route('category.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    public function trashed(){
        $categories = Category::onlyTrashed()->get();

        return view('backend.resources.category.index', [
            'categories' => $categories,
            'title' => 'Liste des Categories supprimées'
        ]);

    }

    public function restore(string $id){

        $category = Category::withTrashed()->find($id);
        if($category->restore()){
            return redirect()->route('category.index')->with('success', 'Réstauration réussit');
        }
        return back()->with('error', 'Echec de réstauration');

    }

    private function moveImage($file)
    {
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('Ymd_His');

        $path_file = (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/resources/categories/'), $path_file);

        return "assets/resources/categories/" . $path_file;
    }
    private function deleteImage($path)
    {
        if ( file_exists( public_path($path) ) ) {
            unlink(public_path($path));
        }
    }

    private function saveDocument($files, Category $category, string $type){

        if (is_array($files)) {

            foreach ($files as $file) {
                $documentPath = $this->moveImage($file);
                $document = new Document(['path' => $documentPath, 'type' => $type]);
                $category->document()->save($document);
            }

        } else {

            $documentPath = $this->moveImage($files);
            $document = new Document(['path' => $documentPath, 'type' => $type]);
            $category->document()->save($document);

        }
    }
}
