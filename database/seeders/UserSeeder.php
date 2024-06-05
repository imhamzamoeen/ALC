<?php

namespace Database\Seeders;

use App\Classes\Enums\UserTypesEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         User::firstOrCreate(
            [
                'email' => 'admin@alquranclasses.com',
            ],[
            'id'    => 1,
            'name' => 'Admin',
            'email' => 'admin@alquranclasses.com',
            'password' => Hash::make('admin@Alquran2021'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::Admin,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        User::firstOrCreate(
            [
                'email' => 'sales@alquranclasses.com',

            ],[
            'id'    => 2,
            'name' => 'Sales Support',
            'email' => 'sales@alquranclasses.com',
            'password' => Hash::make('sales@Alquran2021'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::SalesSupport,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        User::firstOrCreate([
            'email' => 'customer@alquranclasses.com',
        ],[
            'id'    => 3,
            'name' => 'Alquran User',
            'email' => 'customer@alquranclasses.com',
            'password' => Hash::make('customer@Alquran2021'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::Customer,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        User::firstOrCreate([
            'email' => 'coord@alquranclasses.com',

        ],[
            'id'    => 4,
            'name' => 'Teacher Co-oridater ',
            'email' => 'coord@alquranclasses.com',
            'password' => Hash::make('coord@Alquran2021'),
            'email_verified_at' => Carbon::now(),       
            'user_type' => UserTypesEnum::TeacherCoordinator,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        User::firstOrCreate([
            'email' => 'teacher@alquranclasses.com',
        ],[
            'id'    => 5,
            'name' => 'Teacher  ',
            'email' => 'teacher@alquranclasses.com',
            'password' => Hash::make('teacher@Alquran2021'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::Teacher,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        User::firstOrCreate([
            'email' => 'CS@alquranclasses.com',

        ],[
            'id'=>6,
            'name' => 'Customer Support',
            'email' => 'CS@alquranclasses.com',
            'password' => Hash::make('CS@Alquran2021'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::CustomerSupport,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        User::firstOrCreate([
            'email' => 'TC@alquranclasses.com',

        ],[
            "id"=>7,
            'name' => 'TC',
            'email' => 'TC@alquranclasses.com',
            'password' => Hash::make('TC@Alquran2021'),
            'email_verified_at' => Carbon::now(),
            'user_type' => UserTypesEnum::TC,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

       
    }
}
