<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.offer.index', [
            'offers' => Offer::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.offer.form', [
            'offer' => new Offer()
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
            'url' => 'required|url|unique:offers',
            'title' => 'required|min:3|unique:offers',
            'description' => 'nullable',
            'picture' => 'required|image'
        ]);
        $errors = $validators->errors();
        if($validators->fails()){
            return back()->withErrors($errors)->withInput();
        }

        $offer = Offer::create($request->only(['url', 'title', 'description']));
        if ($offer){

            $image = new Image();
            $image->id = (string) Str::uuid();
            $image->path = $this->moveImage($request->picture); // Enregistre la nouvelle image
            $offer->image()->save($image);

            return redirect()->route('offer.index')->with('success', "Offre ajoutée avec succès");
        }else{
            return  back()->with('error', "Impossible d'ajouter cette catalogue")->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        dd($offer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        return view('admin.offer.form', [
            'offer' => $offer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        $validators = Validator::make($request->all(), [
            'url' => 'required|url',
            'title' => 'required',
            'description' => 'nullable'
        ]);
        $errors = $validators->errors();
        if($validators->fails()){
            return back()->withErrors($errors)->withInput();
        }

        if( $offer->update([
            'url' => $request->input('url'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            ]) ){
            return redirect()->route('offer.index')->with('success', "Mise à jour réussit");
        }
        return back()->with('error', "Impossible de mettre à jour")->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Offer $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        $this->deleteImage($offer->image->path);
        if($offer->delete()){
            return redirect()->route('offer.index', [
                'offers' => Offer::all()
            ])->with('success', 'Suppression réussit');
        }

        return back()->with('error', 'Impossible de supprimer cette sous catégorie');
    }

    public function uploadPhoto(Request $request, Offer $offer){
//
        if ($request->picture->isValid()) {

            if (!$offer) {
                return response()->json(['message' => 'Impossible de trouver l\'offre correspondant', 'code' => 1]);
            }

            // Vérifiez si l'ID de l'entreprise existe déjà dans la table "images"
            $image = $offer->image;

            if ($image) {
                // Si l'image existe déjà, mettez à jour le champ "url"
                $this->deleteImage($image->url); // Supprime l'ancienne image si nécessaire
                $image->path = $this->moveImage($request->picture); // Met à jour le champ "url"
                $image->save();
            }else {
                // Si l'image n'existe pas, créez un nouvel enregistrement dans la table "images"
                $image = new Image();
                $image->id = (string) Str::uuid();
                $image->path = $this->moveImage($request->picture); // Enregistre la nouvelle image
                $offer->image()->save($image);
            }


            return response()->json(['message' => 'Votre Image a bien été mis à jour', 'code' => 0]);
        }
        return response()->json(['message' => 'Aucune image trouvée.', 'code' => 1]);
    }

    // Méthode pour déplacer l'image et retourner l'URL de l'image déplacée
    private function moveImage($file)
    {
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('Ymd_His');

        $path_file = $formattedDateTime . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/offers/'), $path_file);

        return "assets/offers/" . $path_file;
    }

    // Méthode pour supprimer une image
    private function deleteImage($path)
    {
        if (file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }
    /**
     * @param \Illuminate\Http\Request $request
     */
    public function updateOrder(Request $request){
        //dd($request->all());
        $itemsIds = json_decode($request->input('itemsIds'));

        // Mettez à jour l'ordre des images en fonction des identifiants triés
        foreach ($itemsIds as $index => $itemId) {
            $offer = Offer::where('id', $itemId)->first();
            if ($offer) {
                $offer->update(['priority' => $index + 1]);
            }
        }
        // Retournez une réponse appropriée (par exemple, un message de succès)
        return response()->json(['message' => 'L\'ordre des offres a été mis à jour avec succès.', 'code' => 0]);
    }
}
