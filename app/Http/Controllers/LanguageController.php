<?php

namespace App\Http\Controllers;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        if (!in_array($locale, ['hy', 'en', 'ru'])) {
            abort(404);
        }

        session()->put('locale', $locale);

        return redirect()->back();
    }
}