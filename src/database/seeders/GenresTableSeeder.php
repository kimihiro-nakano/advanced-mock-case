<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;
use App\Models\Genre;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = [
            ['genre' => 'イタリアン'],
            ['genre' => '居酒屋'],
            ['genre' => '寿司'],
            ['genre' => '焼肉'],
            ['genre' => 'ラーメン'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
        // DB::table('genres')->insert($genres);
    }
}
