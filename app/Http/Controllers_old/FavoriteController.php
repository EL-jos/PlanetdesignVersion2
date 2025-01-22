<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Devis;
use App\Models\Favorite;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FavoriteController extends Controller
{
    /**
     * @param User $user
     * @param Article $article
     *
     */
    public function toggle(Article $article, User $user){
        //dd($user, $article, );

        if($user->exists){
            switch ($user->toggleFavorite($article->id)){
                case 'added':
                    return view('layouts.favorite.favorite', [
                        'article' => $article,
                        'user' => $user,
                    ]);
                    break;
                case 'removed':
                    return view('layouts.favorite.favorite', [
                        'article' => $article,
                        'user' => $user,
                    ]);
                    break;
            }
        }

        if (Favorite::where('article_id', $article->id)
            ->whereAnd('ip_address', $_SERVER['REMOTE_ADDR'])
            ->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])->exists()) {

            Favorite::where('article_id', $article->id)
                ->whereAnd('ip_address', $_SERVER['REMOTE_ADDR'])
                ->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])->delete();

            return view('layouts.favorite.favorite', [
                'article' => $article,
                'user' => $user,
                'nb' => Favorite::where('ip_address', $_SERVER['REMOTE_ADDR'])
                    ->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])
                    ->get()->count(),
                'code' => 1,
                'message' => "Article supprimé de vos favoris",
            ]);

        }else{

            Favorite::create([
                'id' => (string) Str::uuid(),
                'user_id' => $user->exists ? $user->id : null,
                'article_id' => $article->id,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            ]);

            return view('layouts.favorite.favorite', [
                'article' => $article,
                'user' => $user,
                'nb' => Favorite::where('ip_address', $_SERVER['REMOTE_ADDR'])
                    ->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])
                    ->get()->count(),
                'code' => 0,
                'message' => "Article ajouté à vos favoris",
            ]);

        }
        /*if ($this->toggleFavorite($article, $user) === 'added') {
            return view('layouts.favorite.favorite', [
                'article' => $article,
                'user' => $user,
                'nb' => Favorite::where('ip_address', $_SERVER['REMOTE_ADDR'])
                    ->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])
                    ->get()->count(),
                'code' => 0,
                'message' => "Article ajouté à vos favoris",
            ]);
        }elseif ($this->toggleFavorite($article, $user) === 'removed'){
            return view('layouts.favorite.favorite', [
                'article' => $article,
                'user' => $user,
                'nb' => Favorite::where('ip_address', $_SERVER['REMOTE_ADDR'])
                        ->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])
                        ->get()->count(),
                'code' => 1,
                'message' => "Article supprimé de vos favoris",
            ]);
        }*/
    }

    private function toggleFavorite(Article $article, User $user){
        if (Favorite::where('article_id', $article->id)
            ->whereAnd('ip_address', $_SERVER['REMOTE_ADDR'])
            ->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])->exists()) {

            Favorite::where('article_id', $article->id)
                ->whereAnd('ip_address', $_SERVER['REMOTE_ADDR'])
                ->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])->delete();
            return 'removed';
        } else {
            Favorite::create([
                'id' => (string) Str::uuid(),
                'user_id' => $user->exists ? $user->id : null,
                'article_id' => $article->id,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            ]);
            return 'added';
        }
    }

    /**
     * @param Favorite $favorite
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Favorite $favorite){
        if(!session()->has('user')){
            $user = new User();
            //return redirect()->route('identification.page')->with('warning', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }

        if($favorite->delete()){
            return back()->with('success', "Favoris supprimer avec succès");
        }
        return back()->with('error', "Impossible de supprimer cet favoris");
    }

    /**
     * @param User $user
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToQuote(Article $article, User $user){

        if(!session()->has('user')){
            $user = new User();
            //return redirect()->route('identification.page')->with('warnin', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }
        //dd($user, $article);

        if($user->exists){
            $quote = Quote::create([
                'id' => (string) Str::uuid(),
                'article_id' => $article->id,
                'user_id' => $user->id,
                'quantity' => 1
            ]);

            if($quote){
                Favorite::where([
                    'user_id' => $user->id,
                    'article_id' =>$article->id,
                ])->delete();
                return redirect()->route('quote.page', [
                    'user' => $user
                ])->with('success', "Favoris ajouté au devis avec success");
            }else{
                return back()->with('error', "Impossible d'ajouter cet favoris au devis");
            }
        }else{
            $devis = Devis::updateOrCreate(
                [
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                    'article_id' => $article->id,
                    'color_id' => null,
                    'size_id' => null,
                ],[
                'id' => (string) Str::uuid(),
                'article_id' => $article->id,
                'quantity' => 1,
                'color_id' => null,
                'size_id' => null,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            ]);

            if($devis){
                Favorite::where([
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                    'article_id' => $article->id,
                ])->delete();
                return redirect()->route('quote.page', [
                    'user' => $user
                ])->with('success', "Favoris ajouté au devis avec success");
            }else{
                return back()->with('error', "Impossible d'ajouter cet favoris au devis");
            }
        }

    }
}
