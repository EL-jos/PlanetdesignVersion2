<?php

namespace App\Http\Controllers;

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
        return view('admin.size.index', [
            'sizes' => Size::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.size.form',[
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
        $validators = Validator::make($request->all(), [
            'name' => 'required|unique:sizes',
        ]);
        $errors = $validators->errors();
        if($validators->fails()){
            return back()->withErrors($errors)->withInput();
        }

        $size = Size::create($request->all());

        if ($size){
            return redirect()->route('size.index')->with('success', "Taille ajoutée avec succès");
        }else{
            return  back()->with('error', "Impossible d'ajouter cette taille")->withInput();
        }
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
     * @param  Size $size
     * @return \Illuminate\Http\Response
     */
    public function edit(Size $size)
    {
        return view('admin.size.form', [
            'size' => $size
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Size $size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Size $size)
    {
        $ok = $size->update([
            'name' => $request->input('name')
        ]);

        if($ok){
            return redirect()->route('size.index')->with('success', "Mise à jour réussit");
        }
        return back()->with('error', 'Impossible de mettre à jour cette information')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Size $size
     * @return \Illuminate\Http\Response
     */
    public function destroy(Size $size)
    {

        if($size->delete()){
            return redirect()->route('size.index', [
                'sizes' => Size::all()
            ])->with('success', 'Suppression réussit');
        }

        return back()->with('error', 'Impossible de supprimer cette taille');
    }

    public function deleted(){
        return view('admin.size.index', [
            'sizes' => Size::onlyTrashed()->get()
        ]);
    }

    public function restore(int $id){

        $size = Size::withTrashed()->find($id);
        if($size->restore()){
            return view('admin.size.index', [
                'sizes' => Size::all()
            ])->with('success', 'Réstauration réussit');
        }
        return back()->with('error', 'Echec de réstauration');
    }

    public function remove(int $id){

        $size = Size::withTrashed()->find($id);
        if($size->forceDelete()){
            return redirect()->route('size.index', [
                'sizes' => Size::all()
            ])->with('success', 'Suppression définitive réussit');
        }
        return back()->with('error', 'Echec lors de la suppression définitive');
    }

    public function updateOrder(Request $request){
        //dd($request->all());
        $itemsIds = json_decode($request->input('itemsIds'));

        // Mettez à jour l'ordre des images en fonction des identifiants triés
        foreach ($itemsIds as $index => $itemId) {
            $size = Size::where('id', $itemId)->first();
            if ($size) {
                $size->update(['priority' => $index + 1]);
            }
        }
        // Retournez une réponse appropriée (par exemple, un message de succès)
        return response()->json(['message' => 'L\'ordre des tailles a été mis à jour avec succès.', 'code' => 0]);
    }
}
