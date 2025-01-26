<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Mail\QuoteSend;
use App\Models\Article;
use App\Models\Availability;
use App\Models\Banner;
use App\Models\Cart;
use App\Models\cart_item;
use App\Models\Catalog;
use App\Models\Category;
use App\Models\Color;
use App\Models\Deal;
use App\Models\Devis;
use App\Models\Favorite;
use App\Models\Material;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Subcategory;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
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

    public function cart(User $user){
        if(!session()->has('user')){
            $user = new User();
            //return redirect()->route('identification.page')->with('warning', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }

        return view('quote', [
            'user' => $user,
            'tab_devis' => Cart::all(),
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
    public function addCart(Request $request, string $id, string $model){

        //dd($request->all(), $id, $model, session('user'));

        /**
         * @var User $user
         */
        $user = User::findOrfail(session('user'));
        // Récupération de la wishlist de l'utilisateur
        $cart = $user->cart ?? $user->cart()->save(new Cart());

        if ($model === Article::class) {

            // Récupérer l'article par son ID
            $article = Article::findOrFail($id);

            // Vérifier si l'article a des variantes
            if ($article->variants()->exists()) {

                return redirect()->back()->with('warning', "Veuillez sélectionner une variante avant d'ajouter l'article au devis.");

            }
        }

        // Vérifier si l'élément existe déjà dans la wishlist
        $existingItem = $cart->items()
            ->where('cartable_id', $id)
            ->where('cartable_type', $model)
            ->first();

        if ($existingItem) {
            // Si l'élément existe déjà, vous pouvez décider de l'augmenter ou de ne rien faire
            return redirect()->route('cart.page')->with('info', "Cet article est déjà dans votre devis.");
        }

        // Ajout d'un nouvel élément dans la wishlist
        $isAdd = $cart->items()->create([
            'cartable_id' => $id,
            'cartable_type' => $model,
        ]);


        if($isAdd){
            return redirect()->route('cart.page')->with('success', "Article ajouté dans votre devis avec succès");
        }

        return redirect()->back()->with('error', "Impossible d'ajouter cet article dans votre devis");

    }

    public function updateCartQuantity(Request $request, cart_item $cartItem)
    {
        //dd($request->all(), $wishlistItemId);
        /**
         * @var User $user
         */
        $user = User::findOrFail(session('user'));

        // Récupérer la wishlist de l'utilisateur
        $cart = $user->cart;

        if (!$cart) {
            return redirect()->route('cart.page')->with('error', "Votre devis est vide.");
        }

        // Rechercher l'élément de wishlist correspondant
        //$wishlistItem = $wishlist->items()->findOrFail($wishlistItemId);

        // Vérifier que la quantité est fournie et est un nombre positif
        $newQuantity = $request->input('quantity');
        if (!$newQuantity || $newQuantity < 1) {
            return redirect()->route('cart.page')->with('error', "Quantité invalide.");
        }

        // Mettre à jour la quantité de l'élément
        $cartItem->update(['quantity' => $newQuantity]);

        return redirect()->route('cart.page')->with('success', "Quantité mise à jour avec succès.");
    }

    public function removeFromCart(string $cartItem)
    {
        /**
         * @var User $user
         */
        $user = User::findOrFail(session('user'));

        /**
         * @var Cart $cart
         */
        $cart = $user->cart;


        // Vérifiez si l'élément est dans le panier
        $item = $cart->items()->find($cartItem);

        if ($item) {
            // Supprimer l'élément du wishlist
            $item->delete();

            // Redirige vers la page wishlist avec un message de succès
            return redirect()->route('cart.page')->with('success', "Article supprimé de votre devis avec succès");
        }

        // Si l'élément n'est pas trouvé, redirige avec un message d'erreur
        return redirect()->back()->with('error', "L'article n'a pas été trouvé dans votre devis.");
    }

    public function addCatalog(Request $request, string $id, string $model){

        //dd($request->all(), $id, $model, session('user'));

        /**
         * @var User $user
         */
        $user = User::findOrfail(session('user'));
        // Récupération de la wishlist de l'utilisateur
        $catalog = $user->catalog ?? $user->catalog()->save(new Catalog());

        if ($model === Article::class) {

            // Récupérer l'article par son ID
            $article = Article::findOrFail($id);

            // Vérifier si l'article a des variantes
            if ($article->variants()->exists()) {

                return redirect()->back()->with('warning', "Veuillez sélectionner une variante avant d'ajouter l'article à votre catalogue.");

            }
        }

        // Vérifier si l'élément existe déjà dans la wishlist
        $existingItem = $catalog->items()
            ->where('catalogable_id', $id)
            ->where('catalogable_type', $model)
            ->first();

        if ($existingItem) {
            // Si l'élément existe déjà, vous pouvez décider de l'augmenter ou de ne rien faire
            return redirect()->route('catalog.page')->with('info', "Cet article est déjà dans votre catalogue.");
        }

        // Ajout d'un nouvel élément dans la wishlist
        $isAdd = $catalog->items()->create([
            'catalogable_id' => $id,
            'catalogable_type' => $model,
        ]);


        if($isAdd){
            return redirect()->route('catalog.page')->with('success', "Article ajouté dans votre catalogue avec succès");
        }

        return redirect()->back()->with('error', "Impossible d'ajouter cet article dans votre catalogue");

    }

    public function removeFromCatalog(string $catalogItem)
    {
        /**
         * @var User $user
         */
        $user = User::findOrFail(session('user'));

        /**
         * @var Catalog $catalog
         */
        $catalog = $user->catalog;


        // Vérifiez si l'élément est dans le panier
        $item = $catalog->items()->find($catalogItem);

        if ($item) {
            // Supprimer l'élément du wishlist
            $item->delete();

            // Redirige vers la page wishlist avec un message de succès
            return redirect()->route('catalog.page')->with('success', "Article supprimé de votre catalogue avec succès");
        }

        // Si l'élément n'est pas trouvé, redirige avec un message d'erreur
        return redirect()->back()->with('error', "L'article n'a pas été trouvé dans votre catalogue.");
    }

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
        $article = Article::where('ugs', $articleRef)
                            ->where('slug', $articleSlug)->firstOrFail();

        return view('article',[
            'article' => $article
        ]);
    }

    public function generateCatalogPdf(){

        /**
         * @var User $user
         */
        $user = User::findOrFail(session('user'));

        if($user->exists){
            return Pdf::loadView('generate-pdf-catalog', [
                //'articles' => $articles
                'catalog' => $user->catalog
            ])->stream('mon_catalogue.pdf');
        }

    }


    public function sendDevis(Request $request){
        /**
         * @var User $user
         */
        $user = User::findOrFail(session('user'));

        $validators = Validator::make($request->all(), [
            'lastname' => 'required|min:3|exists:users,lastname',
            'firstname' => 'required|min:3|exists:users,firstname',
            'email' => 'required|email:rfc,dns|exists:users,email',
            'company' => 'nullable|min:10|max:50',
            'content' => 'required|min:3'
        ]);
        $errors = $validators->errors();
        if($validators->fails()){
            return back()->withErrors($errors)->withInput();
        }

        $isUpdate = $user->update([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
        ]);

        if(!$isUpdate){
            return redirect()->back()->with('error', "Impossible de soumettre votre devis")->withInput();
        }

        // Récupérer la wishlist de l'utilisateur
        /**
         * @var Cart $cart
         */
        $cart = $user->cart;

        // Vérifier si la wishlist n'est pas vide
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.page')->with('error', 'Votre devis est vide.');
        }

        //Creation de la commande
        /**
         * @var Order $order
         */
        $order = $cart->createOrderFromCart();

        if($order){

            $order->content = $request->input('content');
            if($order->save()){
                Mail::to(env('MAIL_TO_ADDRESS'))->send(new QuoteSend($order));
                return redirect()->back()->with('success', "Votre devis a été soumi avec succès");
            }
            return redirect()->back()->with('error', "Impossible de soumettre votre devis");
        }
        return redirect()->back()->with('error', "Impossible de soumettre votre devis");
    }

    public function destroyAllCartOfThisUser()
    {
        /**
         * @var User $user
         */
        $user = User::findOrFail(session('user'));

        if($user->cart()->delete()){
            return redirect()->back()->with('success', "Le Devis a été supprimé avec succès");
        }
        return redirect()->back()->with('error', "Impossible de supprimer le devis");

    }
}
