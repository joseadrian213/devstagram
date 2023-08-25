<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //Los factorys se encargan de hacer pruebas a la base de datos una vez los ejecutamos para verificar que todos los campos se crearon y se añaden de forma correcta 
        return [
            'titulo'=>$this->faker->sentence(5),
            'descripcion'=>$this->faker->sentence(20),
            'imagen'=>$this->faker->uuid().'.jpg',
            'user_id'=>$this->faker->randomElement([1,3,4])#Aaqui estamos probando la relacion por eso deben de ser usuarios que ya existen dentro de la base de datos 
        ];
    }
}
