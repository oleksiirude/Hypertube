<?php

    namespace App\Http\Controllers;
    
    use DB;
    use Illuminate\Http\Request;
    
    class WishlistController extends Controller
    {
        protected function addFilm(Request $request)
        {
            DB::table('wishlist')->insert([
                'user_uuid' => auth()->user()->uuid,
                'imdb_id' => $request->get('imdb_id'),
            ]);
            
            // response true means film has added to wishlist
            return response()->json(['result' => true]);
        }
        
        protected function deleteFilm(Request $request)
        {
            if (!preg_match('/^tt[0-9]{7}$/', $request->get('imdb_id')))
                return $this->jsonResponseWithError();
            
            DB::table('wishlist')->where([
                'user_uuid' => auth()->user()->uuid,
                'imdb_id' => $request->get('imdb_id'),
            ])->delete();
    
            // response false means film has deleted from wishlist
            return response()->json(['result' => false]);
        }
        
        public static function getWishlist($auth)
        {
            $poster = LocaleController::getLang() . '_poster';
            
            $wishlist = DB::select("SELECT posters.*
                                            FROM wishlist
                                            JOIN posters
                                            ON wishlist.user_uuid = '$auth'
                                            AND posters.imdb_id = wishlist.imdb_id");
            
            if ($wishlist) {
                foreach ($wishlist as $item) {
                    $item->poster = $item->$poster;
                    $item->link = env('APP_URL') . '/watch/' . $item->imdb_id;
                    unset($item->en_poster);
                    unset($item->uk_poster);
                    unset($item->ru_poster);
                }
            }
            
            return $wishlist;
        }
        
        public static function checkIfInWishlist($imdb_id)
        {
            $auth = auth()->user()->uuid;
            
            $res = DB::select("SELECT wishlist.*
                                        FROM wishlist
                                        WHERE user_uuid = '$auth' AND imdb_id = '$imdb_id'");
            
            return $res ? true : false;
        }
    }
