<?php
    
    namespace App\Http\Controllers;
    
    use Auth;
    use App\User;

    class LocaleController extends Controller
    {
        public function changeLang($locale)
        {
            if (!preg_match('/^en|uk|ru$/', $locale))
                return redirect()->back();
    
            if (Auth::check())
                User::where('uuid', auth()->id())->update(['lang' => $locale]);
            session()->put('locale', $locale);
            return redirect()->back();
        }
    
        public static function setLang()
        {
            $locale = session()->get('locale');
            $locale = $locale ? $locale : 'en';
            User::where('uuid', auth()->id())->update(['lang' => $locale]);
        }
    
        public static function getLang()
        {
            return User::select('lang')->where('uuid', auth()->id())->pluck('lang')[0];
        }
    }