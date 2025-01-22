<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.resources.material.index', [
            'materials' => Material::all(),
            'title' => 'Liste des matières'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.resources.material.form', [
            'title' => "Ajoutez une matière",
            'material' => new Material()
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
            'name' => 'required|max:255',
            //'document' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $material = Material::create([
            'name' => $request->input('name'),
        ]);

        if ($material){

            return redirect()->route('material.index')->with('success', "Action reusit");

        }

        return redirect()->route('material.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        return view('backend.resources.material.form', [
            'title' => "Modifiez la matière",
            'material' => $material
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            //'document' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $isUpdate = $material->update([
            'name' => $request->input('name'),
        ]);

        if ($isUpdate){

            return redirect()->route('material.index')->with('success', "Action reusit");

        }

        return redirect()->route('material.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        if ($material->delete()){

            return redirect()->route('material.index')->with('success', "Action reusit");

        }

        return redirect()->route('material.index')->with('error', 'Une erreur est survenue')->withInput();
    }
}
