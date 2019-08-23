<?php
    
    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\App;

    class LocaleController extends Controller
    {
        public function setLanguage($locale)
        {
            if (!preg_match('/^en|ua$/', $locale))
                return redirect()->back();
            
            session()->put('locale', $locale);
            App::setLocale($locale);
            return redirect()->back();
        }
    }