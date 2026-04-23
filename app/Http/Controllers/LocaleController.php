<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function switch($locale)
    {
        if (in_array($locale, ['ca', 'es', 'en'])) {
            Session::put('locale', $locale);
        }

        return redirect()->back();
    }
}
