<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request,Post $post)
    {
        #No le vamos a pasar el id del post al modelo en el fillable debido a que se lo vamos a aestar pasando pos aqui
        $post->likes()->create([
            'user_id'=>$request->user()->id
        ]);
        return back(); 
    }

    public function destroy(Request $request,Post $post)#El post lo obtenemoss por la url 
    {
       $request->user()->likes()->where('post_id',$post->id)->delete(); 
        return back(); 
    }
}
