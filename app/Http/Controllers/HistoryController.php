<?php

    namespace App\Http\Controllers;
    
    use DB;
    use Illuminate\Http\Request;
    
    class HistoryController extends Controller
    {
        protected function addFilm(Request $request)
        {
            $result = DB::table('history')->where([
                'user_uuid' => auth()->user()->uuid,
                'imdb_id' => $request->get('imdb_id'),
            ])->get();
            
            if (!count($result))
                DB::table('history')->insert([
                    'user_uuid' => auth()->user()->uuid,
                    'imdb_id' => $request->get('imdb_id'),
                ]);
        
            // response true means film has added to history
            return response()->json(['result' => true]);
        }
    
        protected function deleteFilm(Request $request)
        {
            if (!preg_match('/^tt[0-9]{7}$/', $request->get('imdb_id')))
                return $this->jsonResponseWithError();
        
            DB::table('history')->where([
                'user_uuid' => auth()->user()->uuid,
                'imdb_id' => $request->get('imdb_id'),
            ])->delete();
        
            // response false means film has deleted from history
            return response()->json(['result' => false]);
        }
    
        public static function getHistory($auth)
        {
            $poster = LocaleController::getLang() . '_poster';
        
            $history = DB::select("SELECT posters.*
                                            FROM history
                                            JOIN posters
                                            ON history.user_uuid = '$auth'
                                            AND posters.imdb_id = history.imdb_id");
        
            if ($history) {
                foreach ($history as $item) {
                    $item->poster = $item->$poster;
                    $item->link = env('APP_URL') . '/watch/' . $item->imdb_id;
                    unset($item->en_poster);
                    unset($item->uk_poster);
                    unset($item->ru_poster);
                }
            }
        
            return $history;
        }
    }
