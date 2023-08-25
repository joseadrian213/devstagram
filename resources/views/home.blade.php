<!-- Aqui le vamos a pasar una directiva las directivas pueden ser for o if
van acompañadas por un @   -->
@extends('layouts.app')<!-- Aqui le estamos pasando la direccion en vez de usar / se utiliza el punto  -->

<!-- Aqui le indicamos que vamos inyectar cidigo  -->
@section('titulo')
    Pagina Principal
@endsection

@section('contenido')

{{-- despues de pasrle el nombre del archivo le vamos a pasar la variable con los :posts='$posts' --}}
<x-listar-post :posts="$posts"/>

{{-- Cada que se muestre una x- se trata de un componente  --}}
    {{-- Los slots son como variables se pueden utilizar multples veces  --}}
{{-- <x-listar-post> --}}
    {{-- Creamos una variable de un slot  --}}
    {{-- <x-slot:titulo> --}}
        {{-- <header>Esto es un header  </header> --}}
    {{-- </x-slot:titulo> --}}
    {{-- Los que se muestra desde un slot se pasa automaticamente al component --}}
    {{-- <h2>Mostrando post desde slot </h2> --}}
{{-- </x-listar-post> --}}
@endsection
