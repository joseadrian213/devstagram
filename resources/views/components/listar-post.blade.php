<div>
{{-- {{$titulo}}
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
<h1>{{ $slot}}</h1> --}}
     {{-- Esta directiva de forelse es un conbinacion de un condicional y un foreach --}}
    {{-- @forelse ($posts as $post )
     <h1>{{$post->titulo}}</h1>
 @empty
     <p>No Hay Posts</p>
 @endforelse --}}
 @if ($posts->count())
 <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

     @foreach ($posts as $post)
         <div>
             {{-- Le pasamos la variable de post ya que la declaramos en web  --}}
             <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                 {{-- Aqui a nuestro enlace href le estamos enviando multiplesss valores que son los del post y el user  --}}
                 <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
             </a>
         </div>
     @endforeach
 </div>
 <div class="my-10">
     {{-- Creamos la paginacion  --}}
     {{ $posts->links('pagination::tailwind') }}
 </div>
@else
 <p class="text-center">No Hay Posts, sigue a alguien para porder mostrar sus posts </p>
@endif
</div>