<?php

namespace Database\Seeders;

use App\models\Buku;
use App\models\User;
use App\Models\Profile;
use App\models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the Application's database.
     *
     * @return void
     */
    public function run()
    {
     //App\models\User::factory(10)->create();

     User::create([
        'name'=> 'Admin',
        'username'=>'petugas',
        'password' => Hash::make('12345678'),
        'rfid' => '12345678',
        'isAdmin' => '1',
     ]);
     Profile::create([
        'nisn'=>'123',
        'kelas'=>'admin',
        'alamat'=>'sidoarjo',
        'noTelp'=>'39894',
        'user_id'=>'1',
        ]);

    }
}
