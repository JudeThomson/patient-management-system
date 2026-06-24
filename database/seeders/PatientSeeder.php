<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_IN');

        $diagnoses = [
            'Chronic Kidney Disease',
            'Type 2 Diabetes Mellitus',
            'Hypertension',
            'Coronary Artery Disease',
            'Chronic Obstructive Pulmonary Disease',
            'Osteoarthritis',
            'Rheumatoid Arthritis',
            'Bronchial Asthma',
            'Hypothyroidism',
            'Generalized Anxiety Disorder',
        ];

        $hospitals = [
            'AIIMS', 'Apollo Hospital', 'Fortis Healthcare', 'Max Super Speciality Hospital',
            'Manipal Hospital', 'Medanta - The Medicity', 'Sir Ganga Ram Hospital', 'Christian Medical College',
        ];

        $departments = [
            'Cardiology', 'Nephrology', 'Oncology', 'Neurology', 'Orthopedics', 'Gastroenterology', 'Endocrinology', 'Pulmonology',
        ];

        $latestPatient = Patient::latest('id')->first();
        $lastId = $latestPatient ? (int) str_replace('PAT', '', $latestPatient->patient_id) : 0;

        for ($i = 0; $i < 20; $i++) {
            $lastId++;
            Patient::create([
                'patient_id' => 'PAT' . str_pad($lastId, 6, '0', STR_PAD_LEFT),
                'sct_no' => 'SCT' . $faker->unique()->numberBetween(1000, 9999),
                'name' => $faker->name,
                'age' => $faker->numberBetween(18, 85),
                'gender' => $faker->randomElement(['Male', 'Female', 'Other']),
                'phone' => $faker->unique()->numerify('##########'),
                'diagnosis' => $faker->randomElement($diagnoses),
                'address' => $faker->address,
                'route_map' => $faker->sentence(10),
                'pincode' => $faker->postcode,
                'referred_by' => $faker->name,
                'hospital_department' => $faker->randomElement($hospitals) . ' - ' . $faker->randomElement($departments),
                'doctor' => 'Dr. ' . $faker->name,
            ]);
        }
    }
}
