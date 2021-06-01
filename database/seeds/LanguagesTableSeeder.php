<?php

use Illuminate\Database\Seeder;

/**
 * Class LanguagesTableSeeder
 */
class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            [
                'id' => 1,
                'short_name' => 'ru',
                'long_name' => 'Русский'
            ],
            [
                'id' => 2,
                'short_name' => 'uz',
                'long_name' => 'Uzbek'
            ],
        ];

        DB::table('languages')->insert($languages);
    }
}
