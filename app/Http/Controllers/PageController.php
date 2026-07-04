<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function help()
    {
        return view('pages.help');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }
}
