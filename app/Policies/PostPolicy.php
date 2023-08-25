<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
  
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post)
    { 
        #vamos retornar si el usuario actual es el mismo que creo el post
        return $user->id=== $post->user_id; 
    }
  

}
