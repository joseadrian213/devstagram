<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username', # cada que añadimos un nuevo campo por migracion los debemos de añadir al modelo si no este dara error alo ejecutarlo   
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    #Aqui vamos a utilizar la relacion One toMany que es uno a muchos 
    public function posts()
    {
        #creamos la relacion 
        return $this->hasMany(Post::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    //Alamacenaremos los seguidores de un usuario debido a que la relacion no contiene un nombre distinto a las convenciones de laravel 
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id'); #Le estamos indicando que el metodo followers pertenece a muchos usuarios  
        #Tenemos que indicar que la tabla con la que hacemos relacion y las columnas que vamos a rellenar 
    }
    //Almacenar los que seguimos 
    public function followings()
    {                                          #En esta relacion se va buscar el id del usuario para saber a cuantos esta siguiendo 
        return $this->belongsToMany(User::class, 'followers','follower_id', 'user_id' ); #Le estamos indicando que el metodo followers pertenece a muchos usuarios  
        #Tenemos que indicar que la tabla con la que hacemos relacion y las columnas que vamos a rellenar 
    }
    //Comprobar si un usuario ya sigue a otro 
    public function siguiendo(User $user)
    {
        #EL usuario que estamos manedando es el que esta accediendo al perfil 
        #Entramos al metodo followers y verificamos con contains si id de ese usuario y verificamos si ese usuario ya sigue a ese perfil 
        return $this->followers->contains($user->id);
    }
}
