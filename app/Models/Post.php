<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable=[
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    #Aqui haremos la relacion inverzaa en donde un post le pertenece a un usuario 
    public function user()
    {
        return $this->belongsTo(User::class)->select(['name','username']);#El select sirve aqui para indicar que elementos queremos traer la relacion  
    }
    public function comentarios()
    {
        #Estamos indicando con la relacion que un post va tener multiples comentarios 
        return $this->hasMany(Comentario::class); 
    }
    public function likes()
    {
        return $this->hasMany(Like::class); 
    }
    public function checkLike(User $user)
    {
        #Con esta funcion verificaremos si el post ya tiene el like de terminado usuario  
        #Pasamos la informacion de likes que es la relacion y funcion de arriba pero solo estamos extrayendo la informacion  despues con contains verficamos si el usuario existe en la columna de user_id 
        return $this->likes->contains('user_id',$user->id); 
    }
}
