<?php

// database/factories/QuestFactory.php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Quests;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quests::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categoryIDs = Category::all()->pluck('id')->toArray();

        return [
            'title' => $this->faker->title(),
            'description' => $this->faker->text(),
            'reward' => $this->faker->numberBetween(1 , 100),
            'category_id' => $this->faker->randomElement($categoryIDs)
        ];
    }
}
