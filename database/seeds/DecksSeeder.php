<?php

use App\Models\Card;
use App\Models\Category;
use App\Models\Deck;
use App\Models\Field;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DecksSeeder extends Seeder
{
    const TOTAL_TAGS = 20;
    const TOTAL_DECKS = 1;
    const TAGS_PER_DECK = 3;
    const TOTAL_CATEGORIES = 10;

    const CATEGORIES_PER_DECK = 3;
    const FIELDS_PER_DECK = 3;
    const CARDS_PER_DECK = 30;

    protected $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    protected function truncateTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('decks')->truncate();
        DB::table('cards')->truncate();
        DB::table('fields')->truncate();
        DB::table('tags')->truncate();
        DB::table('card_field')->truncate();
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    protected function seedTags()
    {
        return factory(Tag::class, self::TOTAL_TAGS)->create();
    }

    protected function seedCategories()
    {
        $rootCategory = factory(Category::class)->create();

        factory(Category::class, self::TOTAL_CATEGORIES)
            ->create(['parent_id' => $rootCategory->id])
            ->each(function(Category $category) {
                factory(Category::class, 3)->create(['parent_id' => $category->id]);
            });

        // get all categories that are leaves
        return Category::allLeaves()->get();
    }

    protected function seedDecks($tags, $leafCategories)
    {
        $tagIndex = 0;
        $categoriesIndex = 0;

        return factory(Deck::class, self::TOTAL_DECKS)->create()
            ->each(function($deck) use ($tagIndex, $categoriesIndex, $tags, $leafCategories) {

                for($i = 0; $i < self::TAGS_PER_DECK; $i++) {
                    $deck->tags()->attach($tags->get($tagIndex)->id);
                    $tagIndex = ($tagIndex + 1) % self::TOTAL_TAGS;
                }

                for($i = 0; $i < self::CATEGORIES_PER_DECK; $i++) {
                    $category = $leafCategories->get($categoriesIndex);

                    // propagate from leaf to root
                    do {
                        $deck->categories()->attach($category->id);
                        $categoriesIndex = ($categoriesIndex + 1) % $leafCategories->count();
                    } while($category = $category->parent()->get()->first());
                }

                $fields = factory(Field::class, self::FIELDS_PER_DECK)->create(['deck_id' => $deck->id]);
                $cards = factory(Card::class, self::CARDS_PER_DECK)->create(['deck_id' => $deck->id]);

                foreach($cards as $card) {
                    foreach($fields as $field) {
                        $card->fields()->attach([$field->id => ['value' => $this->faker->text(15)]]);
                        $card->save();
                    }
                }

            });
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables();

        $tags = $this->seedTags();
        $leafCategories = $this->seedCategories();

        $this->seedDecks($tags, $leafCategories);

    }
}
