@extends('layouts.app')

@section('titulo')
    Perfil: {{ $user->username }}
@endsection

@section('contenido')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">

            <div class="w-8/12 lg:w-6/12 px-5">
                {{-- Haremos la comprobacion de si los datos son correctos con operador ternario que es un condicional  --}}
                <img src="{{ $user->imagen ? asset('perfiles') . '/' . $user->imagen : asset('img/usuario.svg') }}"
                    alt="">
            </div>
            <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center md:justify-center md:items-start py-10 md:py-10">
                {{-- {{dd($user)}} Para poder abrir el codigo de dd()  debemos abrirlo en llaves si lo queremos abrrir en un template  --}}
                <div class=" flex items-center gap-2">
                    <p class="text-gray-700 text-2xl">{{ $user->username }}</p>
                    @auth
                        @if ($user->id === auth()->user()->id)
                            <a href="{{ route('perfil.index') }}" class="text-gray-500 hover:text-gray-600 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>

                            </a>
                        @endif
                    @endauth

                </div>

                <p class="text-gray-800  text-sm mb-3 font-bold mt-5">
                    {{$user->followers->count()}}
                    <span class="font-normal"> @choice('Seguidor|Seguidores',$user->followers->count())</span>
                    {{-- la directiva de choice  elige segun el numero que texto colocar  --}}
                </p>
                <p class="text-gray-800  text-sm mb-3 font-bold">
                    {{-- Se manda a llamar a larelacion que ahora es inversa y busca el id del usuario en el lado del los followings para sabes a cual usuario esta siguiendo  --}}
                    {{$user->followings->count()}}
                    <span class="font-normal"> Siguiendo</span>
                    
                </p>
                <p class="text-gray-800  text-sm mb-3 font-bold">
                    {{-- Por la relacion que tenemos con el post podemos usarlos aqui  --}}
                    {{ $user->posts->count() }}
                    <span class="font-normal"> Posts</span>
                </p>
                @auth
                    {{-- El condicional indica si el usuario es diferente del usuario autenticado se mostraran los botone si es igual entonces esta en su perfil y no podra ver los botones  --}}
                    @if ($user->id !== auth()->user()->id)
                    {{-- Aqui negamos la condicion por que en la funcion siguiendo si no se encuentra el id de sgiuiendo retornara false entonses hay que negarlo para que se muestre el boton de seguir  --}}
                        @if (!$user->siguiendo(auth()->user()))
                            {{-- El primerusuario es al que le pertenece el perfil y le p´asamos a ala funcion el usuario que se encuentra autenticado  --}}
                            <form action="{{ route('users.follow', $user) }}" method="POST">
                                @csrf
                                <input type="submit"
                                    class="bg-blue-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer"
                                    value="Seguir">
                            </form>
                        @else
                            <form action="{{ route('users.unfollow', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit"
                                    class="bg-red-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer"
                                    value="Dejar de Seguir">
                            </form>
                        @endif
                    @endif
                @endauth
            </div>

        </div>
    </div>

    <section class="container mx-auto mt-10">
        <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>

       <x-listar-post :posts="$posts"/>
    </section>
@endsection
