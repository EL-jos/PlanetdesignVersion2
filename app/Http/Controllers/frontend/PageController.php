<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Availability;
use App\Models\Banner;
use App\Models\Catalog;
use App\Models\Category;
use App\Models\Color;
use App\Models\Deal;
use App\Models\Devis;
use App\Models\Favorite;
use App\Models\Material;
use App\Models\Offer;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Jorenvh\Share\Share;

class PageController extends Controller
{
    public function home(){
        //dd(Category::with('subcategories')->get());
        return view('home', [
            'categories' => Category::with('subcategories')->get(),
            'offers' => Offer::all(),
        ]);
    }

    public function category(Category $category){

        return view('category');
    }

    public function article(){
        return view('article');
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function catalog(User $user){
        if(!session()->has('user')){
            $user = new User();
            //return redirect()->route('identification.page')->with('warning', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }
        $share = new Share();
        $socialNetworks = $share->page(route('catalog.page', $user), "Catalogue de " .$user->lastname .' '. $user->firstname)
            ->facebook()
            ->twitter()
            ->pinterest()
            ->linkedin()
            ->whatsapp();

        return view('catalog', [
            'user' => $user,
            'socialNetworks' => $socialNetworks,
            'tab_catalogs' => Catalog::where('ip_address', $_SERVER['REMOTE_ADDR'])
                ->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])
                ->get(),
        ]);
    }

    /**
     * @param User $user
     */
    public function favorites(User $user){
        if(!session()->has('user')){
            $user = new User();
            //return redirect()->route('identification.page')->with('warning', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }

        $share = new Share();
        $socialNetworks = $share->page(route('favorites.page', $user), "Catalogue de " .$user->lastname .' '. $user->firstname)
            ->facebook()
            ->twitter()
            ->pinterest()
            ->linkedin()
            ->whatsapp();

        return view('favorites', [
            'user' => $user,
            'socialNetworks' => $socialNetworks,
            'tab_favorites' => Favorite::where('ip_address', $_SERVER['REMOTE_ADDR'])
                ->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])
                ->get(),
        ]);
    }

    /**
     *
     * @param User $user
     */

    public function quote(User $user){
        if(!session()->has('user')){
            $user = new User();
            //return redirect()->route('identification.page')->with('warning', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }

        return view('quote', [
            'user' => $user,
            'tab_devis' => Devis::where('ip_address', $_SERVER['REMOTE_ADDR'])
                ->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])
                ->get(),
        ]);
    }

    public function arrival(){
        $articles = Article::where('availability_id', '=', 1)->paginate(33);
        return view('arrival', [
            'title' => 'Nouvel arrivage',
            'description' => "<p>Voici notre sélection de notre nouvel arrivage</p>",
            'colors' => Color::all(),
            'materials' => Material::all(),
            'articles' => $articles
        ]);
    }

    public function destocking(){
        /**
         * @var Article $articles
         */
        $articles = Article::where('availability_id', '=', 5)->paginate(33);
        return view('arrival', [
            'title' => 'Déstockage',
            'description' => '<p>Des prix exceptionnels sur une sélection d’articles</p>',
            'colors' => Color::all(),
            'materials' => Material::all(),
            'articles' => $articles
        ]);
    }

    public function business(){
        return view('business', [
            'deals' => Deal::all()
        ]);
    }

    public function catalogs(){
        return view('catalogs', [
            'title' => 'Nos catalogues',
            'banners' => Banner::all()
        ]);
    }

    public function identification(){
        return view('identification');
    }

    /**
     * Search the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Article $article
     * @return \Illuminate\Http\Response
     */
    public function addQuote(Request $request, Article $article){

        if(!session()->has('user')){
            $user = new User();
            //return redirect()->route('identification.page')->with('warning', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }else{
            $user = User::find(session()->get('user'));
        }
        if($request->attributes->has('htmx')){
            return view('layouts.article.form', ['article' => $article, 'user' => $user]);
        }
        return response()->json(['article' => $article, 'user' => $user]);
    }

    /**
     * @param Request $request
     * @param Article $article
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function addCatalog(Request $request, Article $article){

        if(!session()->has('user')){
            return redirect()->route('identification.page')->with('warning', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }
        if($request->attributes->has('htmx')){

            if($article->variants && !$request->exists("variant_id")){
                return view('layouts.article.content', [
                    'article' => $article,
                    'code' => 1,
                    'message' => "Veillez choisir une variante du produit"
                ]);
            }elseif ($article->variants && $request->exists("variant_id")){

                return view('layouts.article.content', []);

            }elseif (!$article->variants && !$request->exists("variant_id")){
                return view('layouts.article.content', []);
            }
            //return view('layouts.article.form-catalog', ['article' => $article]);
        }
        return response()->json(['article' => $article]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function search(Request $request){
        //dd($request->all());
        $keyword = '%' . htmlentities($request->input('Keyword')) . '%';
        $articles = Article::where('reference', 'LIKE', $keyword)
            ->orWhere('description', 'LIKE', $keyword)
            ->get();
        //dd($keyword, $articles);
        return view('search', [
            'Keyword' => $request->input('Keyword'),
            'articles' => $articles
        ]);
    }

    public function show_category(string $categorySlug){

        // Récupérer la catégorie basée sur le slug
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        if ($category) {

            // Récupérez toutes les sous-catégories liées à cette catégorie
            $subcategoryIds = $category->subcategories->pluck('id')->toArray();

            // Maintenant, récupérez les articles de toutes les sous-catégories liées à cette catégorie
            $articles = Article::whereHas('subcategories', function ($query) use ($subcategoryIds) {
                $query->whereIn('subcategory_id', $subcategoryIds);
            })->paginate(32);
            //dd($articles);
            return view('category', [
                'category' => $category,
                'colors' => Color::all(),
                'materials' => Material::all(),
                'availabilities' => Availability::all(),
                'articles' => $articles
            ]);

        } else {
            // La catégorie n'a pas été trouvée, retournez une réponse appropriée
            return response()->json(['erreur' => 'Valeur invalide']);
        }
    }
    public function show_subcategory(string $categorySlug, string $subcategorySlug){
        // Récupérer la sous-catégorie basée sur le slug
        $subcategory = Subcategory::where('slug', $subcategorySlug)->firstOrFail();

        if ($subcategory){
            // Vérifie si la page provient directement d'une catégorie
            $referer = request()->server('HTTP_REFERER');
            $isFromCategoryPage = strpos($referer, route('category.show', $subcategory->category)) !== false;

            // Incrémente le nombre de vues de la catégorie si la page ne provient pas de la catégorie
            if (!$isFromCategoryPage) {
                $subcategory->category->increment('view');
            }

            $articles = $subcategory->articles()->paginate(32);
            return view('subcategory', [
                'subcategory' => $subcategory,
                'colors' => Color::all(),
                'materials' => Material::all(),
                'availabilities' => Availability::all(),
                'articles' => $articles
            ]);
        }

    }
    public function show_article(string $articleSlug, string $articleRef){
        $article = Article::where('reference', $articleRef)
                            ->where('slug', $articleSlug)->firstOrFail();

        return view('article',[
            'article' => $article
        ]);
    }
}
