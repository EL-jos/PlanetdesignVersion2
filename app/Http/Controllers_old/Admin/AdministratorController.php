<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdministratorController extends Controller
{
    public function login(Request $request){

        if($request->isMethod('post')){
            //dd($request->all());

            if ($request->input('email') === "b.lahlou@promogifts.ma" && $request->input('password') === "G%q3p#k9@L!") {

                session()->put('admin',[
                    'email' => $request->input('email'),
                    'password' => $request->input('password')
                ]);

                return redirect()->route('article.index');
            }

            return back()->withInput()->withErrors([
                'email' => 'Please enter an email address'
            ]);
        }

        return view('admin.sign-in');

    }
}
