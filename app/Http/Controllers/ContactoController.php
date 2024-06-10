<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function show($mobileNumber)
    {
        return view('home', ['mobileNumber' => $mobileNumber]);
    }

    public function home($mobileNumber)
    {
        return view('home', ['mobileNumber' => $mobileNumber]);
    }

    public function perfil($mobileNumber)
    {
        return view('perfil', ['mobileNumber' => $mobileNumber]);
    }

    public function contactos($mobileNumber)
    {
        return view('contactos', ['mobileNumber' => $mobileNumber]);
    }

    public function estados($mobileNumber)
    {
        return view('estados', ['mobileNumber' => $mobileNumber]);
    }
}
