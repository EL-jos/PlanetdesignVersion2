<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Document;
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
        return view('backend.resources.offer.index', [
            'offers' => Offer::all(),
            'title' => 'Liste des offres'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.resources.offer.form', [
            'offers' => Offer::all(),
            'title' => 'Modifiez l\'offres'
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        return view('backend.resources.offer.form', [
            'offer' => $offer,
            'title' => 'Modifiez l\'offres'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
            'document' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $isUpdate = $offer->update([
            'title' => $request->input('title'),
            'url' => $request->input('url'),
            'description' => $request->input('description'),
        ]);

        if ($isUpdate){

            if ($request->hasFile('document')) {
                $files = $request->file('document');
                $this->saveDocument($files, $offer, 'image');
            }

            return redirect()->route('offer.index')->with('success', "Action reusit");

        }

        return redirect()->route('offer.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        //
    }

    private function moveImage($file)
    {
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('Ymd_His');

        $path_file = (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/resources/offers/'), $path_file);

        return "assets/resources/offers/" . $path_file;
    }
    private function deleteImage($path)
    {
        if ( file_exists( public_path($path) ) ) {
            unlink(public_path($path));
        }
    }

    private function saveDocument($files, Offer $offer, string $type){

        if (is_array($files)) {

            foreach ($files as $file) {
                $documentPath = $this->moveImage($file);
                $document = new Document(['path' => $documentPath, 'type' => $type]);
                $offer->document()->save($document);
            }

        } else {

            $documentPath = $this->moveImage($files);
            $document = new Document(['path' => $documentPath, 'type' => $type]);
            $offer->document()->save($document);

        }
    }
}
