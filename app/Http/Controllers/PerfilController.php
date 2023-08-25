<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        #estamos restringiendo al usuario a este apartado de editar perfil 
        $this->middleware('auth');
    }

    public function index()
    {
        #Retornamos a las vista con la ubicacion de la carppeta y despues el nombre del archivo 
        return view('perfil.index');
    }
    #El request siempre se les pasa a los store 
    public function store(Request $request)
    {
        #Se reescrbie la validacion para que pueda realizar la validacion  del validate
        #Modificamos el request
        $request->request->add(['username' => Str::slug($request->username)]);
        #Cuando son mas de tres validaciones se recomienda pasarlas por un arreglo
        $this->validate($request, [
            'username' => [                        #Si el usuario coloca su mismo username lo uidentificamos con la concatenacion de username
                'required', 'unique:users,username,' . auth()->user()->id, 'min:3', 'max:20',
                #Para nombres no validos si queremos apartar cierto nombre o exlucir nombres que cuasen inconvenientes se hace con not_in
                'not_in:twitter,editar-perfil',
                #Si queremos que sean nombres especificos como roles de usuario es con 'in;CLIENTE,PROVEEDOR,GERENTE,NOMBRE_USUARIO'        

            ],
            'email' => ['required', 'unique:users,email,' . auth()->user()->id, 'email', 'max:60'],

        ]);

        if ($request->imagen) {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . "." . $imagen->extension(); #Esta linea de codigo va generar un id unico para cada imagen 
            #Aqui estamos utlizando ointervetion image que es lo que vamos utilizar para poder cortar las imagenes al tamaño que queremos  despues de la instalacion de intervention image 
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen; #Le pasamo la ruta al path para indicarlo en donde y como se va guarda la imagen 
            $imagenServidor->save($imagenPath);
        }
        //Guardar cambios
        $usuario = User::find(auth()->user()->id); #Se buscar al usuario actual que esta buscando su informacion 
        $usuario->username = $request->username;
        $usuario->email = $request->email ?? auth()->user()->mail;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null; #Si el campo imagen se encuentra vacio pasa a verificar si el usuario en base de datos ya cuenta con una imagen si no por utlimo pasa null y es el emento que guarda s 
        $usuario->save();

        if ($request->oldpassword || $request->password) {
            $this->validate($request, [
                'password' => 'required|confirmed',
            ]);

            if (Hash::check($request->oldpassword, auth()->user()->password)) {
                $usuario->password = Hash::make($request->password) ?? auth()->user()->password;
                $usuario->save();
            } else {
                return back()->with('mensaje', 'La Contraseña Actual no Coincide');
            }
        }

        //Redireccionaremos al usuario
        return redirect()->route('posts.index', $usuario->username);
    }
}
