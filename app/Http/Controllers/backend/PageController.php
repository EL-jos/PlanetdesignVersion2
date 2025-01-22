<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashboard(){
        return view('backend.pages.dashboard', [
            'title' => "Dashboard",
        ]);
    }

    /*public function invoicePrint(Order $order){
        return view('backend.pages.invoice-print', [
            'title' => "Print Invoice",
            'order' => $order
        ]);
    }*/
}
