<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.resources.category.index', [
            'categories' => Category::all(),
            'title' => 'Liste des Categories'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.resources.category.form', [
            'category' => new Category(),
            'title' => "Ajoutez une catégorie",
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
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $category = Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('mane'), '-'),
        ]);

        if ($category){

            return redirect()->route('category.index')->with('success', "Action reusit");

        }

        return redirect()->route('category.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('backend.resources.category.form', [
            'category' => $category,
            'title' => "Modifiez une catégorie",
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $isUpdate = $category->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-'),
        ]);

        if ($isUpdate){

            return redirect()->route('category.index')->with('success', "Action reusit");

        }

        return redirect()->route('category.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->delete()){
            return redirect()->route('category.index')->with('success', "Action reusit");
        }
        return redirect()->route('category.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    public function trashed(){
        $categories = Category::onlyTrashed()->get();

        return view('backend.resources.category.index', [
            'categories' => $categories,
            'title' => 'Liste des Categories supprimées'
        ]);

    }

    public function restore(string $id){

        $category = Category::withTrashed()->find($id);
        if($category->restore()){
            return redirect()->route('category.index')->with('success', 'Réstauration réussit');
        }
        return back()->with('error', 'Echec de réstauration');

    }
}
