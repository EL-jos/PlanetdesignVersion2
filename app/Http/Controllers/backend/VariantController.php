<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Availability;
use App\Models\Category;
use App\Models\Color;
use App\Models\Document;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.resources.variant.index', [
            'variants' => Variant::all(),
            'title' => 'Liste des Variables'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.resources.variant.form', [
            'variant' => new Variant(),
            'articles' => Article::all(),
            'title' => "Ajoutez une variante",
            'colors' => Color::all(),
            'sizes' => Size::all(),
            'availabilities' => Availability::all(),
            'subcategories' => Subcategory::all(),
            'categories' => Category::all()
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

        $validators = Validator::make($request->all(), [
            //'ugs' => 'required|unique:variants,ugs',
            'article_id' => 'required|exists:articles,id',
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
            'availability_id' => 'nullable|exists:availabilities,id',
            'document' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
        ]);

        if ($validators->fails()) {
            return redirect()->back()->withErrors($validators)->withInput();
        }

        $variant = Variant::create([
            'article_id' => $request->get('article_id'),
            'availability_id' => $request->input('availability_id', null),
            'color_id' => $request->input('color_id', null),
            'size_id' => $request->input('size_id', null),
        ]);

        if ($variant) {

            if($request->hasFile('document')){

                $files = $request->file('document');
                $this->saveDocument($files, $variant, 'image');

            }

            return redirect()->route('variant.index')->with('success', "Action reussit");
        }

        return redirect()->route('variant.index')->with('error', "Une erreur est survenue")->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function edit(Variant $variant)
    {
        return view('backend.resources.variant.form', [
            'variant' => $variant,
            'articles' => Article::all(),
            'title' => "Modifiez la variante",
            'colors' => Color::all(),
            'sizes' => Size::all(),
            'availabilities' => Availability::all(),
            'subcategories' => Subcategory::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variant $variant)
    {
        //dd($request->all());

        $validators = Validator::make($request->all(), [
            //'ugs' => 'required|unique:variants,ugs',
            'article_id' => 'required|exists:articles,id',
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
            'availability_id' => 'nullable|exists:availabilities,id',
            'document' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
        ]);

        if ($validators->fails()) {
            return redirect()->back()->withErrors($validators)->withInput();
        }

        $isUpdate = $variant->update([
            'article_id' => $request->get('article_id'),
            'availability_id' => $request->input('availability_id', null),
            'color_id' => $request->input('color_id', null),
            'size_id' => $request->input('size_id', null),
        ]);

        if ($isUpdate) {

            if($request->hasFile('document')){

                $files = $request->file('document');
                $this->saveDocument($files, $variant, 'image');

            }

            return redirect()->route('variant.index')->with('success', "Action reussit");
        }

        return redirect()->route('variant.index')->with('error', "Une erreur est survenue")->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variant $variant)
    {
        //
    }

    private function moveImage($file)
    {
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('Ymd_His');

        $path_file = (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/resources/variants/'), $path_file);

        return "assets/resources/variants/" . $path_file;
    }

    // Méthode pour supprimer une image
    private function deleteImage($path)
    {
        if ( file_exists( public_path($path) ) ) {
            unlink(public_path($path));
        }
    }

    private function saveDocument($files, Variant $variant, string $type){

        if (is_array($files)) {

            foreach ($files as $file) {
                $documentPath = $this->moveImage($file);
                $document = new Document(['path' => $documentPath, 'type' => $type]);
                $variant->document()->save($document);
            }

        } else {

            $documentPath = $this->moveImage($files);
            $document = new Document(['path' => $documentPath, 'type' => $type]);
            $variant->document()->save($document);

        }
    }

    public function uploadDocument(Request $request, Variant $variant){

        if ($request->hasFile('document')) {
            $files = $request->file('document');
            //dd($files);
            if (is_array($files)) {
                foreach ($files as $file) {
                    $documentPath = $this->moveImage($file);
                    $document = new Document(['type' => 'image', 'path' => $documentPath]);
                    $variant->document()->save($document);
                    //dump($imagePath);
                }
            } else {
                $documentPath = $this->moveImage($files);
                $document = new Document(['type' => 'image', 'path' => $documentPath]);
                $variant->document()->save($document);
            }
            return response()->json(['message' => 'Votre Image a bien été mis à jour', 'code' => 0]);
        }
        return response()->json(['message' => 'Aucune image trouvée.', 'code' => 1]);
    }

    public function trashed(){
        $variants = Variant::onlyTrashed()->get();

        return view('backend.resources.variant.index', [
            'variants' => $variants,
            'title' => 'Liste des Variables'
        ]);

    }

    public function restore(string $id){

        $variant = Variant::withTrashed()->find($id);
        if($variant->restore()){
            return redirect()->route('variant.index')->with('success', 'Réstauration réussit');
        }
        return back()->with('error', 'Echec de réstauration');

    }
}
