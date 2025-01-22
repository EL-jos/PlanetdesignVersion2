<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Document;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.resources.subcategory.index', [
            'subcategories' => Subcategory::all(),
            'title' => 'Liste des Sous-Categories'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.resources.subcategory.form', [
            'categories' => Category::all(),
            'title' => "Ajoutez une catégorie",
            'subcategory' => new Subcategory()
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
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'document' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $subcategory = Subcategory::create([
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'slug' => Str::slug($request->input('mane'), '-'),
        ]);

        if ($subcategory){

            if ($request->hasFile('document')) {
                $files = $request->file('document');
                $this->saveDocument($files, $subcategory, 'image');
            }

            return redirect()->route('subcategory.index')->with('success', "Action reusit");

        }

        return redirect()->route('subcategory.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $subcategory)
    {
        return view('backend.resources.subcategory.form', [
            'categories' => Category::all(),
            'title' => "Modifiez une Sous-catégorie",
            'subcategory' => $subcategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id' ,
            'document' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $isUpdate = $subcategory->update([
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'slug' => Str::slug($request->input('name'), '-'),
        ]);

        if ($isUpdate){

            if ($request->hasFile('document')) {
                $files = $request->file('document');
                $this->saveDocument($files, $subcategory, 'image');
            }

            return redirect()->route('subcategory.index')->with('success', "Action reusit");

        }

        return redirect()->route('subcategory.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        $this->deleteImage($subcategory->document()->where('type', 'image')->first()->path);
        $subcategory->document()->delete();

        if($subcategory->delete()){
            return redirect()->route('subcategory.index')->with('success', "Action reusit");
        }
        return redirect()->route('subcategory.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    private function moveImage($file)
    {
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('Ymd_His');

        $path_file = (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/resources/subcategories/'), $path_file);

        return "assets/resources/subcategories/" . $path_file;
    }

    // Méthode pour supprimer une image
    private function deleteImage($path)
    {
        if ( file_exists( public_path($path) ) ) {
            unlink(public_path($path));
        }
    }

    private function saveDocument($files, Subcategory $subcategory, string $type){

        if (is_array($files)) {

            foreach ($files as $file) {
                $documentPath = $this->moveImage($file);
                $document = new Document(['path' => $documentPath, 'type' => $type]);
                $subcategory->document()->save($document);
            }

        } else {

            $documentPath = $this->moveImage($files);
            $document = new Document(['path' => $documentPath, 'type' => $type]);
            $subcategory->document()->save($document);

        }
    }

    public function uploadDocument(Request $request, Subcategory $subcategory){

        if ($request->hasFile('document')) {
            $files = $request->file('document');
            //dd($files);
            if (is_array($files)) {
                foreach ($files as $file) {
                    $documentPath = $this->moveImage($file);
                    $document = new Document(['type' => 'image', 'path' => $documentPath]);
                    $subcategory->document()->save($document);
                    //dump($imagePath);
                }
            } else {
                $documentPath = $this->moveImage($files);
                $document = new Document(['type' => 'image', 'path' => $documentPath]);
                $subcategory->document()->save($document);
            }
            return response()->json(['message' => 'Votre Image a bien été mis à jour', 'code' => 0]);
        }
        return response()->json(['message' => 'Aucune image trouvée.', 'code' => 1]);
    }

    public function getSubCategories(Request $request){

        $categoryId = $request->input('category_id');

        /**
         * @var Category $category
         */
        $category = Category::find($categoryId);

        $subcategories = $category->subcategories;

        return response()->json($subcategories);

    }

    public function getArticles(Request $request){

        $subcategoryId = $request->input('subcategory_id');

        /**
         * @var Subcategory $subcategory
         */
        $subcategory = Subcategory::find($subcategoryId);

        $articles = $subcategory->articles;

        return response()->json($articles);

    }
}
