<?php

use Illuminate\Database\Seeder;

class DecksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('decks')->truncate();
        DB::table('cards')->truncate();
        DB::table('fields')->truncate();
        DB::table('tags')->truncate();
        DB::table('card_field')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = \Faker\Factory::create();

        factory(App\Models\Deck::class, 1)->create()->each(function($deck) use ($faker) {
            $tags = factory(App\Models\Tag::class, 5)->create(['deck_id' => $deck->id]);
            $fields = factory(App\Models\Field::class, 3)->create(['deck_id' => $deck->id]);
            $cards = factory(App\Models\Card::class, 30)->create(['deck_id' => $deck->id]);

            foreach($cards as $card) {
                foreach($fields as $field) {
                    $card->fields()->attach([$field->id => ['value' => $faker->text(15)]]);
                    $card->save();
                }
            }
        });
    }
}
