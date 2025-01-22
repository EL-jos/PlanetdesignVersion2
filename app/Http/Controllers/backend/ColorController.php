<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.resources.color.index', [
            'colors' => Color::all(),
            'title' => 'Liste des Couleurs'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.resources.color.form', [
            'title' => "Ajoutez une couleur",
            'color' => new Color()
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
            'document' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $color = Color::create([
            'name' => $request->input('name'),
        ]);

        if ($color){

            if ($request->hasFile('document')) {
                $files = $request->file('document');
                $this->saveDocument($files, $color, 'image');
            }

            return redirect()->route('color.index')->with('success', "Action reusit");

        }

        return redirect()->route('color.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit(Color $color)
    {
        return view('backend.resources.color.form', [
            'title' => "Modifiez une couleur",
            'color' => $color
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Color $color)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy(Color $color)
    {
        if($color->document !== null){
            $this->deleteImage($color->document()->where('type', 'image')->first()->path);
            $color->document()->delete();
        }


        if($color->delete()){
            return redirect()->route('color.index')->with('success', "Action reusit");
        }
        return redirect()->route('color.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    private function moveImage($file)
    {
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('Ymd_His');

        $path_file = (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/resources/colors/'), $path_file);

        return "assets/resources/colors/" . $path_file;
    }
    private function deleteImage($path)
    {
        if ( file_exists( public_path($path) ) ) {
            unlink(public_path($path));
        }
    }

    private function saveDocument($files, Color $color, string $type){

        if (is_array($files)) {

            foreach ($files as $file) {
                $documentPath = $this->moveImage($file);
                $document = new Document(['path' => $documentPath, 'type' => $type]);
                $color->document()->save($document);
            }

        } else {

            $documentPath = $this->moveImage($files);
            $document = new Document(['path' => $documentPath, 'type' => $type]);
            $color->document()->save($document);

        }
    }
}
