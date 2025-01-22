<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.resources.size.index', [
            'sizes' => Size::all(),
            'title' => 'Liste des Tailles'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.resources.size.form', [
            'title' => "Ajoutez une taille",
            'size' => new Size()
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
            //'document' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $size = Size::create([
            'name' => $request->input('name'),
        ]);

        if ($size){

            return redirect()->route('size.index')->with('success', "Action reusit");

        }

        return redirect()->route('size.index')->with('error', 'Une erreur est survenue')->withInput();
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function edit(Size $size)
    {
        return view('backend.resources.size.form', [
            'title' => "Modifiez une taille",
            'size' => $size
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Size $size)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            //'document' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $isUpdate = $size->update([
            'name' => $request->input('name'),
        ]);

        if ($isUpdate){

            return redirect()->route('size.index')->with('success', "Action reusit");

        }

        return redirect()->route('size.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy(Size $size)
    {
        if ($size->delete()){

            return redirect()->route('size.index')->with('success', "Action reusit");

        }

        return redirect()->route('size.index')->with('error', 'Une erreur est survenue')->withInput();
    }
}
