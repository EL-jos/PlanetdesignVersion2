<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * @param Catalog $catalog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Catalog $catalog){
        //dd($catalog);
        if(!session()->has('user')){
            $user = new User();
            //return redirect()->route('identification.page')->with('warning', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }
        //dd($catalog);
        if($catalog->delete()){
            return back()->with('success', "Article supprimé de votre catalogue avec succès");
        }
        return back()->with('error', "Impossible de supprimer cet article de votre catalogue");
    }

    /**
     *
     */
    public function generateCatalogPdf(){
        if(!session()->has('user')){
            $user = new User();
            //return redirect()->route('identification.page')->with('warning', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }else{
            $user = User::find(session()->get('user'));
        }

        if($user->exists){
            return Pdf::loadView('generate-pdf-catalog', [
                //'articles' => $articles
                'catalogs' => $user->catalogs
            ])->stream('mon_catalogue.pdf');
        }

        return Pdf::loadView('generate-pdf-catalog', [
            //'articles' => $articles
            'catalogs' => Catalog::where('ip_address', $_SERVER['REMOTE_ADDR'])
                ->whereAnd('user_agent', $_SERVER['HTTP_USER_AGENT'])
                ->get(),
        ])->stream('mon_catalogue.pdf');

    }
}
