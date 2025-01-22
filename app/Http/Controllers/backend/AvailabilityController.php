<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.resources.availability.index', [
            'availabilities' => Availability::all(),
            'title' => 'Liste des disponibilités'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.resources.availability.form', [
            'title' => "Ajoutez une disponibilité",
            'availability' => new Availability()
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

        $availability = Availability::create([
            'name' => $request->input('name'),
        ]);

        if ($availability){

            return redirect()->route('availability.index')->with('success', "Action reusit");

        }

        return redirect()->route('availability.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function edit(Availability $availability)
    {
        return view('backend.resources.availability.form', [
            'title' => "Modifiez une disponibilité",
            'availability' => $availability
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Availability $availability)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            //'document' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $isUpdate = $availability->update([
            'name' => $request->input('name'),
        ]);

        if ($isUpdate){

            return redirect()->route('availability.index')->with('success', "Action reusit");

        }

        return redirect()->route('availability.index')->with('error', 'Une erreur est survenue')->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Availability $availability)
    {
        if ($availability->delete()){

            return redirect()->route('availability.index')->with('success', "Action reusit");

        }

        return redirect()->route('availability.index')->with('error', 'Une erreur est survenue')->withInput();
    }
}
