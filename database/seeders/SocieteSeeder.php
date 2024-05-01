<?php

namespace Database\Seeders;

use App\Models\Societé;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocieteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Societé::create(['name' => 'Societe A']);
        Societé::create(['name' => 'Societe B']);
        Societé::create(['name' => 'Societe C']);

    $users = User::where('role_id' , 2)->get();
    $societes = Societé::all();

// Assign each user to a random company
$users->each(function ($user) use ($societes) {



 // Get a random societé
 $randomSociete = $societes->random();

 // Attach the user to the societé
 $user->societes()->attach($randomSociete);






});




    }

}
