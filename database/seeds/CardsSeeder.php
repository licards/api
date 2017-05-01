<?php

use App\Models\Card;
use App\Models\Category;
use App\Models\Deck;
use App\Models\Field;
use App\Models\Group;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class CardsSeeder extends Seeder
{
    const TOTAL_TAGS = 20;
    const TOTAL_DECKS = 1;
    const TOTAL_CATEGORIES = 10;
    const TOTAL_GROUPS = 3;

    const TAGS_PER_DECK = 3;
    const CATEGORIES_PER_DECK = 3;
    const FIELDS_PER_DECK = 3;
    const CARDS_PER_DECK = 30;
    const SUBCATEGORIES_PER_CATEGORY = 3;

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
        factory(Tag::class, self::TOTAL_TAGS)->create();
    }

    protected function seedGroups()
    {
        factory(Group::class, self::TOTAL_GROUPS)->create(['user_id' => 1]);
    }

    protected function seedCategories()
    {
        $rootCategory = factory(Category::class)->create();

        factory(Category::class, self::TOTAL_CATEGORIES)
            ->create(['parent_id' => $rootCategory->id])
            ->each(function(Category $category) {
                factory(Category::class, self::SUBCATEGORIES_PER_CATEGORY)->create(['parent_id' => $category->id]);
            });
    }

    protected function seedDecks()
    {
        $tagIndex = 0;
        $categoriesIndex = 0;
        $groupsIndex = 0;

        $leafCategories = Category::allLeaves()->get();
        $tags = Tag::all();
        $groups = Group::all();

        return factory(Deck::class, self::TOTAL_DECKS)->create(['user_id' => 1])
            ->each(function($deck) use ($groupsIndex, $tagIndex, $categoriesIndex, $groups, $tags, $leafCategories) {

                for($i = 0; $i < self::TAGS_PER_DECK; $i++) {
                    $deck->tags()->attach($tags->get($tagIndex)->id);
                    $tagIndex = ($tagIndex + 1) % self::TOTAL_TAGS;
                }

                $group = $groups->get($groupsIndex);
                $groupsIndex = ($groupsIndex + 1) % self::TOTAL_GROUPS;

                $deck->group()->associate($group);

                for($i = 0; $i < self::CATEGORIES_PER_DECK; $i++) {
                    $leafCategory = $leafCategories->get($categoriesIndex);

                    foreach($leafCategory->getAncestorsAndSelf() as $category) {
                        $deck->categories()->syncWithoutDetaching([$category->id]);
                        $categoriesIndex = ($categoriesIndex + 1) % $leafCategories->count();
                    }
                }

                $fields = factory(Field::class, self::FIELDS_PER_DECK)->create(['deck_id' => $deck->id]);
                $cards = factory(Card::class, self::CARDS_PER_DECK)->create(['deck_id' => $deck->id]);

                foreach($cards as $card) {
                    foreach($fields as $field) {
                        $card->fields()->attach([$field->id => ['value' => $this->faker->text(15)]]);
                        $card->save();
                    }
                }

                $deck->save();

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

        $this->seedTags();
        $this->seedCategories();
        $this->seedGroups();
        $this->seedDecks();

    }
}
