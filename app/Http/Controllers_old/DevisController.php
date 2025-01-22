<?php

namespace App\Http\Controllers;

use App\Mail\DevisSend;
use App\Models\Article;
use App\Models\Devis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DevisController extends Controller
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
        //dd($request->header('HX-Request'));
        /**
         * @var Devis $devis
         */
        $devis = Devis::updateOrCreate(
            [
                'ip_address' => $request->input('ip_address', null),
                'user_agent' => $request->input('user_agent', null),
                'article_id' => $request->input('article_id', null),
                'color_id' => $request->input('color_id', null),
                'size_id' => $request->input('size_id', null),
            ],[
            'id' => (string) Str::uuid(),
            'lastname' => $request->input('lastname', null),
            'firstname' => $request->input('firstname', null),
            'email' => $request->input('email', null),
            'company' => $request->input('company', null),
            'content' => $request->input('content', null),
            'color_id' => $request->input('color_id', null),
            'size_id' => $request->input('size_id', null),
            'quantity' => $request->input('quantity', null),
            'article_id' => $request->input('article_id', null),
            'ip_address' => $request->input('ip_address', null),
            'user_agent' => $request->input('user_agent', null),
        ]);

        if($devis){
            if($request->header('HX-Request')){
                return view('layouts.article.content', [
                    'article' => Article::find($request->input('article_id', null)),
                    'user' => new User(),
                    'message' => "Ajouté au devis avec succès",
                    'code' => 0,
                    'nb' => Devis::where('ip_address', $request->input('ip_address', null))->whereAnd('user_agent', $request->input('user_agent', null))->get()->count(),
                    'is' => 'devis'
                ]);
            }else{
                return response()->json([
                    'message' => "Ajouté au devis avec succès",
                    'code' => 0,
                    'nb' => Devis::where('ip_address', $request->input('ip_address', null))->get()->count(),
                ]);
            }

        }

        return view('layouts.article.form', [
                'article' => Article::find($request->input('article_id', null)),
                'user' => new User()]
        )->with("error", "Impossible d'ajouter cet article à votre Devis");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $devis
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $devis)
    {
        $devis = Devis::find($devis);

        if(!session()->has('user')){
            $user = new User();
            //return redirect()->route('identification.page')->with('warnin', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }

        if($devis->delete()){
            return back()->with('success', "Devis supprimer avec succès");
        }
        return back()->with('error', "Impossible de supprimer devis");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $user_agent
     * @param  string $ip_address
     * @return \Illuminate\Http\Response
     */
    public function destroyAllQuoteOfThisUser(string $user_agent, string $ip_address)
    {
        if(!session()->has('user')){
            $user = new User();
            //return redirect()->route('identification.page')->with('warning', "Veillez vous connecter pour bénéficier pleinnement de nos fonctionnalités");
        }

        $devis = Devis::where('user_agent', $user_agent)
                        ->whereAnd('ip_address', $ip_address)
                        ->delete();
        if($devis){
            return back()->with('success', "Les Devis ont été supprimés avec succès");
        }
        return back()->with('error', "Impossible de supprimer les devis");

    }

    /**
     * @param Request $request
     * @param Devis $devis
     * @return Response
     */
    public function modifyQuantityOfQuote(Request $request, Devis $devis){
        //dd($quote);
        $newQuantity = $request->input('quantity');
        //dd($newQuantity, $quote);
        if ($newQuantity !== null) {
            if($devis->update(['quantity' => $newQuantity])){
                if($request->attributes->has('htmx')){
                    return view('layouts.quote.quantity', ['devis' => $devis, 'is' => 'devis', 'message' => "Quantité modifié avec succès", 'code' => 0]);
                }
            }else{
                return view('layouts.quote.quantity', ['devis' => $devis, 'is' => 'devis', 'message' => "Impossible de mettre à jour la quantité de ce devis", 'code' => 1]);
            }
        }else{
            return view('layouts.quote.quantity', ['devis' => $devis, 'is' => 'devis', 'message' => "Impossible de mettre à jour la quantité de ce devis", 'code' => 1]);
        }
    }

    public function sendDevis(Request $request){
        //dd($request->all());
        $validators = Validator::make($request->all(), [
            'lastname' => 'required|min:3',
            'firstname' => 'required|min:3',
            'email' => 'required|email:rfc,dns',
            'company' => 'nullable|min:3|max:255',
            'content' => 'required|min:3'
        ]);
        $errors = $validators->errors();
        if($validators->fails()){
            return back()->withErrors($errors)->withInput();
        }

        $resultats = Devis::where('ip_address', $request->input('ip_address'))
            ->whereAnd('user_agent', $request->input('user_agent'))
            ->get();
        $data = (object) [
            'lastname' => $request->input('lastname', null),
            'firstname' => $request->input('firstname', null),
            'email' => $request->input('email', null),
            'company' => $request->input('company', null),
            'content' => $request->input('content', null),
        ];
        Mail::to(env('MAIL_TO_ADDRESS'))->send(new DevisSend($resultats, $data));
        //Mail::to("commerciale@planetdesign.ma")->send(new DevisSend($devis));
        $resultats = Devis::where('ip_address', $request->input('ip_address'))
            ->whereAnd('user_agent', $request->input('user_agent'))
            ->delete();
        return redirect()->back()->with('success', 'Votre devis a été soumi avec succès');
        //}

        /*return response()->json([
            'message' => 'Une erreur se produite lors de la soumition de votre devis',
            'code' => 1,
        ]);*/

    }
}
