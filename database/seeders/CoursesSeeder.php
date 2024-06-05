<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            [
                'title'         => 'Recitation of Quran',
                'description'   => 'Recite the Quran with proper Tajweed and Tarteel',
                'created_by'    => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'title'         => 'Tajweed of Quran',
                'description'   => 'Learn Quran with Noon, Meem and Laam Saakinah',
                'created_by'    => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'title'         => 'Hifz Quran',
                'description'   => 'Hifz means the memorization of the Quran',
                'created_by'    => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'title'         => 'Arabic Grammar and Linguistics',
                'description'   => 'Rules and regulations of Arabic language along with meanings',
                'created_by'    => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]
        ]);
    }
}
