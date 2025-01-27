<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.resources.banner.index', [
            'banners' => Banner::all(),
            'title' => 'Liste des Catalogues'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.resources.banner.form', [
            'banner' => new Banner(),
            'title' => "Ajoutez un catalogue",
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
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
            'document' => 'required|image|mimes:jpeg,jpg,png|max:1024',
            'category_id' => 'required|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $banner = Banner::create([
            'url' => $request->input('url'),
            'category_id' => $request->input('category_id'),
        ]);

        if ($banner){

            if ($request->hasFile('document')) {
                $files = $request->file('document');
                $this->saveDocument($files, $banner, 'image');
            }

            return redirect()->route('banner.index')->with('success', "Action reusit");

        }

        return redirect()->route('banner.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('backend.resources.banner.form', [
            'banner' => $banner,
            'title' => "Modifiez le catalogue",
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
            'document' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'category_id' => 'required|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $isUpdate = $banner->update([
            'url' => $request->input('url'),
            'category_id' => $request->input('category_id'),
        ]);

        if ($isUpdate){

            if ($request->hasFile('document')) {
                $files = $request->file('document');
                $this->saveDocument($files, $banner, 'image');
            }

            return redirect()->route('banner.index')->with('success', "Action reusit");

        }

        return redirect()->route('banner.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $this->deleteImage($banner->document()->where('type', 'iamge')->first()->path);
        if ($banner->delete()){
            return redirect()->route('category.index')->with('success', "Action reusit");
        }
        return redirect()->route('category.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    private function moveImage($file)
    {
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('Ymd_His');

        $path_file = (string) Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/resources/banners/'), $path_file);

        return "assets/resources/banners/" . $path_file;
    }
    private function deleteImage($path)
    {
        if ( file_exists( public_path($path) ) ) {
            unlink(public_path($path));
        }
    }

    private function saveDocument($files, Banner $banner, string $type){

        if (is_array($files)) {

            foreach ($files as $file) {
                $documentPath = $this->moveImage($file);
                $document = new Document(['path' => $documentPath, 'type' => $type]);
                $banner->document()->save($document);
            }

        } else {

            $documentPath = $this->moveImage($files);
            $document = new Document(['path' => $documentPath, 'type' => $type]);
            $banner->document()->save($document);

        }
    }
}
