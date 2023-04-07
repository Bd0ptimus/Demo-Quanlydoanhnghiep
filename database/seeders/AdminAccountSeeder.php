<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'name' => 'Trong Nguyen',
                'email' => 'nvt.702@gmail.com',
                'password' => 'Trong2250f702',
                'roles' => ROLE_MANAGER,
                'pid' => 0,
            ],

            [
                'name' => 'Bui Dung',
                'email' => 'thedung.1292@gmail.com',
                'password' => 'Buidung1292',
                'roles' => ROLE_MANAGER,
                'pid' => 0,
            ],

            [
                'name' => 'Giang Admin',
                'email' => 'sylvietf03@gmail.com',
                'password' => 'Giangadmin123',
                'roles' => ROLE_MANAGER,
                'pid' => 0,
            ],

            [
                'name' => 'Dao Duy Chinh',
                'email' => 'daoduychinh1609@gmail.com',
                'password' => 'Guest123@',
                'roles' => ROLE_MANAGER,
                'pid' => 0,
            ],
        ];


        DB::beginTransaction();
        try{
            // User::truncate();
            foreach($admins  as $admin){
                User::create([
                    "name" => $admin['name'],
                    'email' =>  $admin['email'],
                    'password' =>  Hash::make( $admin['password']),
                    'password_raw' =>  $admin['password'],
                    'roles' => $admin['roles'],
                ]);
            }

            DB::commit();
        }catch(\Exception $e){
            Log::debug('service type seeder : '.$e);
            DB::rollBack();
        }
    }
}
