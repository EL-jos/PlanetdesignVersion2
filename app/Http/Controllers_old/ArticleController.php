<?php

namespace App\Http\Controllers;

use App\Exports\ArticleExport;
use App\Models\Article;
use App\Models\Availability;
use App\Models\Catalog;
use App\Models\Category;
use App\Models\Color;
use App\Models\Image;
use App\Models\Material;
use App\Models\Quote;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.article.index', [
            'articles' => Article::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.article.form', [
            'article' => new Article(),
            'colors' => Color::all(),
            'materials' => Material::all(),
            'availabilities' => Availability::all(),
            'subcategories' => Subcategory::all(),
            'sizes' => Size::all()
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
            'name' => 'required|string|min:3',
            'reference' => 'required|string|min:3|unique:articles',
            'subcategory_id' => 'required|array',
            'subcategory_id.*' => 'required|min:1|numeric|exists:subcategories,id',
            'color_id' => 'nullable|array',
            'color_id.*' => 'required|numeric|exists:colors,id',
            'material_id' => 'nullable|array',
            'material_id.*' => 'required|numeric|exists:materials,id',
            'availability_id' => 'nullable|numeric|min:1|exists:availabilities,id',
            'picture' => 'required|array',
            'picture.*' => 'image',
            'size_id' => 'nullable|array',
            'description' => 'nullable|string',
            'priority' => 'nullable|numeric|min:0',
        ]);
        $errors = $validators->errors();
        if($validators->fails()){
            return back()->withErrors($errors)->withInput();
        }
        //dd($request->all());
        /**
         * @var Article $article
         */
        //$article = Article::create($request->except(['subcategory_id', 'color_id', 'material_id', 'picture', 'size_id']));
        
        $article = Article::create([
            'name' => $request->input('name'),
            'reference' => $request->input('reference'),
            'description' => $request->input('description', null),
            'availability_id' => $request->input('availability_id', null),
            'slug' =>  Str::slug($request->input('name')),
            'priority' => $request->input('priority', 0),
        ]);
        
        //$article = Article::find(5);
        if($article){
            $article->subcategories()->sync($request->input('subcategory_id', []));
            $article->colors()->sync($request->input('color_id', []));
            $article->materials()->sync($request->input('material_id', []));
            $article->sizes()->sync($request->input('size_id', []));

            if ($request->hasFile('picture')) {
                $files = $request->file('picture');
                //dd($files);
                if (is_array($files)) {
                    foreach ($files as $file) {
                        $imagePath = $this->moveImage($file);
                        $image = new Image(['id' => (string) Str::uuid(), 'path' => $imagePath]);
                        $article->images()->save($image);
                        //dump($imagePath);
                    }
                } else {
                    $imagePath = $this->moveImage($files);
                    $image = new Image(['id' => (string) Str::uuid(), 'path' => $imagePath]);
                    $article->images()->save($image);
                }
            }

            return redirect()->route('article.index')->with('success', 'L\'article a été créé avec succès.');
        }

        return back()->with('error', 'Impossible d\'ajouter l\'article.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        /*// Vérifie si la page provient directement d'une catégorie ou d'une sous-catégorie
        $referer = request()->server('HTTP_REFERER');
        $isFromCategoryPage = strpos($referer, route('category.show', $article->subcategory->category)) !== false;
        $isFromSubcategoryPage = strpos($referer, route('subcategory.show', $article->subcategory)) !== false;

        // Incrémente le nombre de vues de la catégorie si la page ne provient ni de la catégorie ni de la sous-catégorie
        if (!$isFromCategoryPage && !$isFromSubcategoryPage) {
            $article->subcategory->category->increment('view');
        }*/

        return view('article',[
            'article' => $article
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view('admin.article.form', [
            'article' => $article,
            'colors' => Color::all(),
            'materials' => Material::all(),
            'availabilities' => Availability::all(),
            'subcategories' => Subcategory::all(),
            'sizes' => Size::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //dd($request->all(), $article);
        //dd($request->all());
        $validators = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'reference' => 'required|string|min:3',
            'subcategory_id' => 'required|array',
            'subcategory_id.*' => 'required|min:1|numeric|exists:subcategories,id',
            'priority' => 'nullable|numeric|min:0',
            'color_id' => 'nullable|array',
            'color_id.*' => 'required|numeric|exists:colors,id',
            'material_id' => 'nullable|array',
            'material_id.*' => 'required|numeric|exists:materials,id',
            'availability_id' => 'nullable|numeric|min:1|exists:availabilities,id',
            //'picture' => 'required|image',
            'size_id' => 'nullable|array',
            'description' => 'nullable|string'
        ]);
        $errors = $validators->errors();
        if($validators->fails()){
            return back()->withErrors($errors)->withInput();
        }
        //dd($request->all());
        $article->update([
            'name' => $request->input('name'),
            'reference' => $request->input('reference'),
            'description' => $request->input('description'),
            'availability_id' => $request->input('availability_id'),
            'priority' => $request->input('priority', 0)
        ]);

        $article->subcategories()->sync($request->input('subcategory_id', []));
        $article->colors()->sync($request->input('color_id', []));
        $article->materials()->sync($request->input('material_id', []));
        $article->sizes()->sync($request->input('size_id', []));

        return redirect()->route('article.index')->with('success', 'L\'article a été créé avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if($article->delete()){
            return redirect()->route('article.index')->with('success', "Article supprimé avec succès");
        }

        return back()->with('error', "Impossible de supprimer cet article");
    }

    public function deleted(){
        //dd(Category::onlyTrashed());
        return view('admin.article.index', [
            'articles' => Article::onlyTrashed()->get()
        ]);
    }

    public function restore(int $id){

        $article = Article::withTrashed()->find($id);
        if($article->restore()){
            return redirect()->route('article.index')->with('success', 'Réstauration réussit');
        }
        return back()->with('error', 'Echec de réstauration');
    }

    public function remove(int $id){

        $article = Article::withTrashed()->find($id);

        foreach ($article->images as $image){
            $this->deleteImage($image->path);
        }
        
        if($article->forceDelete()){
            return redirect()->route('article.index', [
                'articles' => Color::all()
            ])->with('success', 'Suppression définitive réussit');
        }
        return back()->with('error', 'Echec lors de la suppression définitive');
    }

    // Méthode pour déplacer l'image et retourner l'URL de l'image déplacée
    private function moveImage($file)
    {
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('Ymd_His');

        //$path_file = $formattedDateTime . '.' . $file->getClientOriginalExtension();
        $path_file = (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/articles/'), $path_file);

        return "assets/articles/" . $path_file;
    }

    // Méthode pour supprimer une image
    private function deleteImage($path)
    {
        if (file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }

    public function uploadPhoto(Request $request, Article $article){

        if ($request->hasFile('picture')) {
            $files = $request->file('picture');
            //dd($files);
            if (is_array($files)) {
                foreach ($files as $file) {
                    $imagePath = $this->moveImage($file);
                    $image = new Image(['id' => (string) Str::uuid(), 'path' => $imagePath]);
                    $article->images()->save($image);
                    //dump($imagePath);
                }
            } else {
                $imagePath = $this->moveImage($files);
                $image = new Image(['id' => (string) Str::uuid(), 'path' => $imagePath]);
                $article->images()->save($image);
            }
            return response()->json(['message' => 'Votre Image a bien été mis à jour', 'code' => 0]);
        }
        return response()->json(['message' => 'Aucune image trouvée.', 'code' => 1]);
    }

    /**
     * Search the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  User $user
     * @param  Article $article
     * @return \Illuminate\Http\Response
     */
    public function addQuote(Request $request, Article $article){

        //dd($request->all(), $article);
        if(!session()->has('user')){
            return redirect()->route('identification.page')->with('warning', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }
        $user = User::find(session('user'));
        $validators = Validator::make($request->all(), [
            //'color_id' => 'required|array',
            //'color_id.*' => 'required|numeric',
            'color_id' => 'nullable|numeric|min:1',
            'size_id' => 'nullable|numeric|min:1',
            'quantity' => 'required|numeric|min:1',
        ]);
        $errors = $validators->errors();
        if($validators->fails()){
            //return back()->withErrors($errors)->withInput();
            return view('layouts.article.form', [
                'article' => $article,
                'code' => 1,
                'message' => "Veillez renseigner les informations obligaoir"
            ]);
        }

        $quote = Quote::updateOrCreate(['article_id' => $article->id, 'user_id' => $user->id] , [
            'id' => (string) Str::uuid(),
            'article_id' => $article->id,
            'quantity' => $request->input('quantity'),
            'user_id' => $user->id
        ]);

        if($quote){
            $quote->colors()->sync($request->input('color_id', []));
            $quote->sizes()->sync($request->input('size_id', []));

            if($request->attributes->has('htmx') && $request->attributes->get('htmx')){
                return view('layouts.article.content', ['article' => $article, 'user' => $user, 'message' => "Ajouté au devis avec succès", 'code' => 0, 'nb' => $user->quotes->count(), 'is' => 'devis']);
            }
            return response()->json(['article' => $article, 'user' => $user, 'message' => "Ajouté au devis avec succès", 'code' => 0, 'nb' => $user->quotes->count(), 'is' => 'devis']);

        }

        return response()->json(['message' => "Une erreur se produite lors de la soumission de votre devis", 'code' => 1]);

    }

    /**
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function addCatalog(Request $request, Article $article){

        /*dd(
            $request->all(),
            $article,
            $request->attributes,
            $request->attributes->has('htmx'), $request->attributes->get('htmx'),
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_USER_AGENT'],
        );*/
        if(!session()->has('user')){
            $user = new User();
            //return redirect()->route('identification.page')->with('warning', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }else{
            $user = User::find(session('user'));
        }

        /*$validators = Validator::make($request->all(), [
            //'color_id' => 'required|array',
            //'color_id.*' => 'required|numeric',
            //'color_id' => 'required|numeric|min:1',
        ]);
        $errors = $validators->errors();
        if($validators->fails()){
            //return back()->withErrors($errors)->withInput();
            return view('layouts.article.form-catalog', [
                'article' => $article,
                'code' => 1,
                'message' => "Veillez renseigner les informations obligaoir"
            ]);
        }*/

        $catalog = Catalog::updateOrCreate([
            'article_id' => $article->id,
            'user_id' => $user->exists ? $user->id : null,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        ] , [
            'id' => (string) Str::uuid(),
            'article_id' => $article->id,
            'user_id' => $user->exists ? $user->id : null,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        ]);

        if($catalog){
            //$catalog->colors()->sync($request->input('color_id', []));

            //dd($request->attributes->has('htmx'), $request->headers->has('htmx'), $request->attributes->);
            if($request->attributes->has('htmx') && $request->attributes->get('htmx')){
                return view('layouts.article.content', ['article' => $article, 'user' => $user, 'message' => "Ajouté au catalogue avec succès", 'code' => 0, 'nb' => Catalog::where('ip_address', $_SERVER['REMOTE_ADDR'])->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])->get()->count(), 'is' => 'catalog']);
            }
            return response()->json(['article' => $article, 'message' => "Ajouté au catalogue avec succès", 'code' => 0, 'nb' => Catalog::where('ip_address', $_SERVER['REMOTE_ADDR'])->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])->get()->count(), 'is' => 'catalog']);

        }

        return response()->json(['message' => "Une erreur se produite lors de l'ajout de votre article au catalogue", 'code' => 1]);

    }

    /**
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function generateCatalogPdf(Article $article){

        return Pdf::loadView('layouts.article.generate-pdf-catalog', [
            'article' => $article
        ])->stream('mon_catalogue.pdf');
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function filterArticles(Request $request)
    {

        //dd($request->all());
        //$subcategory = Subcategory::findOrFail($request->subcategory_id);
        //$articles = $subcategory->articles;

        if(session()->has('user')){
            $user = User::find(session()->get('user'));
        }else{
            $user = new User();
        }

        // Récupérez les données du filtre
        $colorIds = $request->input('color_ids', []);
        $materialIds = $request->input('material_ids', []);
        $availabilityIds = $request->input('availability_ids', []);
        $categoryId = $request->input('category_id', null);
        $subcategoryId = $request->input('subcategory_id', null);
        $status = $request->input('statut', null);

        // Commencez par récupérer tous les articles associés à la sous-catégorie actuelle
        $articlesQuery = Article::query();

        if ($categoryId) {
            // Filtrer les articles en fonction de l'ID de la catégorie
            $subcategoryIds = Subcategory::where('category_id', $categoryId)->pluck('id');
            //$articlesQuery->whereIn('subcategory_id', $subcategoryIds);
            $articlesQuery->whereHas('subcategories', function ($query) use ($subcategoryIds) {
                $query->whereIn('subcategory_id', $subcategoryIds);
            });
        } elseif ($subcategoryId) {
            // Filtrer les articles en fonction de l'ID de la sous-catégorie
            $articlesQuery->whereHas('subcategories', function ($query) use ($subcategoryId) {
                $query->where('subcategory_id', $subcategoryId);
            });
        }elseif ($status){

            $articlesQuery->where('availability_id', $status);
            //dd($status);
        }

        // Appliquez les filtres si des identifiants sont sélectionnés
        if (!empty($colorIds)) {
            $articlesQuery->whereHas('colors', function ($query) use ($colorIds) {
                $query->whereIn('color_id', $colorIds);
            });
        }

        if (!empty($materialIds)) {
            $articlesQuery->whereHas('materials', function ($query) use ($materialIds) {
                $query->whereIn('material_id', $materialIds);
            });
        }

        if (!empty($availabilityIds)) {
            $articlesQuery->whereIn('availability_id', $availabilityIds);
        }

        // Récupérez les articles filtrés
        $filteredArticles = $articlesQuery->get();

        //dd($request->all(), $filteredArticles);

        return view('layouts.article.component', ['articles' => $filteredArticles, 'user' => $user])->render();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function search(Request $request){
        //dd($request->all());
        $keyword = '%' . htmlentities($request->input('Keyword')) . '%';
        $article = Article::where('reference', 'LIKE', $keyword)
            ->orWhere('description', 'LIKE', $keyword)
            ->first();
        //dd($article);
        //dd($keyword, $articles);
        if($article){
            return redirect()->route('article.edit', $article);
        }
        return back()->with('error', 'Référence non attribuée');
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function updateOrder(Request $request){
        //dd($request->all());
        $itemsIds = json_decode($request->input('itemsIds'));

        // Mettez à jour l'ordre des images en fonction des identifiants triés
        foreach ($itemsIds as $index => $itemId) {
            $article = Article::where('id', $itemId)->first();
            if ($article) {
                $article->update(['priority' => $index + 1]);
            }
        }
        // Retournez une réponse appropriée (par exemple, un message de succès)
        return response()->json(['message' => 'L\'ordre des articles a été mis à jour avec succès.', 'code' => 0]);
    }
    
    public function export(){

        return Excel::download(new ArticleExport, 'articles.xlsx');

    }
}
