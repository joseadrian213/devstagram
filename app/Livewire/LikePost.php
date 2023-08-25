<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    #La unica renstricion que tiene likepost es que no puede acceder al Request 
    #Las variable creadas aqui no se le tienen que pasar por el return se pasana automaticamente una vez ya declaradas 
    public $post;
    public $isLiked; 
    public $likes; 

    #Esta funcion se ejecuta cuando es instanciado livewire  es parecido al constructor 
    public function mount($post)
    {
        #Invocamos a las funciones para saber el estado de los elementos 
        $this->isLiked=$post->checkLike(auth()->user()); 
        $this->likes=$post->likes->count(); 

    }
    #El evento que declaramos en la vista lo mandamos a llamar desde aqui 
    public function like()
    {
        if ($this->post->checkLike(auth()->user())) {

            // $this->post->likes()->where('post_id', $this->post->id)->delete();
            auth()->user()->likes()->where('post_id', $this->post->id)->delete();
            $this->isLiked=false;#Tenemos que poasarle el estado para que se vuelva reactivo y evitemos recargar 
            $this->likes--;#HAcemos reactivo el codigo una vez que se verifica el estado de la funciones en el mount 
                    #decrementamos los likes cada que se presione el boton 
        } else {
            #No le vamos a pasar el id del post al modelo en el fillable debido a que se lo vamos a aestar pasando pos aqui
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            $this->isLiked=true;
            $this->likes++;
                    #incrementamos los likes cada que se presione el boton 

        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
