<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Note::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'text' => $this->faker->sentence,
            'user_id' => User::pluck('id')[$this->faker->numberBetween(1,User::count()-1)],
            'image' => $this->faker->image('public/storage/images/notes',500,500, null, false),
        ];
    }
}
