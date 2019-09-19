<?php

    namespace App\Http\Controllers;
    
    use DB;
    use Illuminate\Http\Request;
    
    class RecommendationsController extends Controller
    {
        protected function addFilm(Request $request)
        {
            DB::table('recommendations')->insert([
                'user_uuid' => auth()->user()->uuid,
                'imdb_id' => $request->get('imdb_id'),
            ]);
        
            // response true means film has added to recommendations
            return response()->json(['result' => true]);
        }
    
        protected function deleteFilm(Request $request)
        {
            if (!preg_match('/^tt[0-9]{7}$/', $request->get('imdb_id')))
                return $this->jsonResponseWithError();
        
            DB::table('recommendations')->where([
                'user_uuid' => auth()->user()->uuid,
                'imdb_id' => $request->get('imdb_id'),
            ])->delete();
        
            // response false means film has deleted from recommendations
            return response()->json(['result' => false]);
        }
    
        public static function getRecommendations($auth)
        {
            $poster = LocaleController::getLang() . '_poster';
        
            $recommendations = DB::select("SELECT posters.*
                                            FROM recommendations
                                            JOIN posters
                                            ON recommendations.user_uuid = '$auth'
                                            AND posters.imdb_id = recommendations.imdb_id");
        
            if ($recommendations) {
                foreach ($recommendations as $item) {
                    $item->poster = $item->$poster;
                    $item->link = env('APP_URL') . '/watch/' . $item->imdb_id;
                    unset($item->en_poster);
                    unset($item->uk_poster);
                    unset($item->ru_poster);
                }
            }
        
            return $recommendations;
        }
    
        public static function getProperty($auth)
        {
            return $auth === auth()->user()->uuid ? true : false;
        }
        
        public static function checkIfInRecommendations($imdb_id)
        {
            $auth = auth()->user()->uuid;
        
            $res = DB::select("SELECT recommendations.*
                                        FROM recommendations
                                        WHERE user_uuid = '$auth' AND imdb_id = '$imdb_id'");
        
            return $res ? true : false;
        }
    }
