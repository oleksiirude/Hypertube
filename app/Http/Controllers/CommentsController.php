<?php

    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    
    class CommentsController extends Controller
    {
        public static function getComments($imdbID)
        {
            return DB::select("SELECT users.login, users.avatar, comments.comment, comments.created_at as date
                                FROM users, comments
                                WHERE users.uuid = comments.user_uuid
                                AND comments.imdb_id = '$imdbID'
                                ORDER BY comments.created_at DESC");
        }
        
        protected function addComment(Request $request)
        {
            DB::table('comments')->insert([
                'user_uuid' => auth()->user()->uuid,
                'imdb_id' => $request->get('imdb_id'),
                'comment' => $request->get('comment'),
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            return $this->jsonResponseWithSuccess();
        }
    }
