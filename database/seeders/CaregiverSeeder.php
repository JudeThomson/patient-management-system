<?php

namespace Database\Seeders;

use App\Models\Caregiver;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CaregiverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_IN');
        $patients = Patient::all();

        $relations = ['Spouse', 'Son', 'Daughter', 'Sibling', 'Parent', 'Friend', 'Relative'];

        foreach ($patients as $patient) {
            $count = rand(1, 3);
            for ($i = 0; $i < $count; $i++) {
                Caregiver::create([
                    'patient_id' => $patient->id,
                    'name' => $faker->name,
                    'relation' => $faker->randomElement($relations),
                    'contact_no' => $faker->numerify('##########'),
                ]);
            }
        }
    }
}
