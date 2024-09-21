<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;
use App\Models\Location;


class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            ['location' => '大阪府'],
            ['location' => '東京都'],
            ['location' => '福岡県'],
        ];
        foreach ($locations as $location) {
            Location::create($location);
        }
        // DB::table('locations')->insert($locations);
    }
}
