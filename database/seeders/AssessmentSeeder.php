<?php

namespace Database\Seeders;

use App\Models\Assessment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_IN');
        $patients = Patient::inRandomOrder()->take(15)->get();
        $admin = User::where('role', 'Admin')->first() ?? User::first();

        if (!$admin) {
            return;
        }

        $latest = Assessment::latest('id')->first();
        $lastId = $latest ? (int) str_replace('ASM', '', $latest->assessment_id) : 0;

        foreach ($patients as $patient) {
            $lastId++;
            $assessment = Assessment::create([
                'assessment_id' => 'ASM' . str_pad($lastId, 6, '0', STR_PAD_LEFT),
                'patient_id' => $patient->id,
                'assessment_date' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
                'distress_meter' => $faker->numberBetween(0, 10),
                'status' => $faker->randomElement(['Draft', 'Completed']),
                'created_by' => $admin->id,
            ]);

            $this->addRelatedData($assessment, $faker);
        }
    }

    private function addRelatedData(Assessment $assessment, $faker)
    {
        // Complaints
        $complaints = ['Pain in abdomen', 'Difficulty breathing', 'Severe headache', 'Nausea and vomiting'];
        for ($i = 0; $i < rand(1, 2); $i++) {
            $assessment->complaints()->create([
                'complaint_text' => $faker->randomElement($complaints),
            ]);
        }

        // Symptoms
        $symptoms = ['Cough', 'Fever', 'Dizziness', 'Weakness'];
        for ($i = 0; $i < rand(1, 2); $i++) {
            $assessment->symptoms()->create([
                'symptom_name' => $faker->randomElement($symptoms),
            ]);
        }

        // Pain
        if (rand(0, 1)) {
            $assessment->pains()->create([
                'pain_label' => $faker->randomElement(['A', 'B', 'C', 'D']),
                'duration' => $faker->numberBetween(1, 10) . ' days',
                'continuous_intermittent' => $faker->randomElement(['Continuous', 'Intermittent']),
                'pain_score' => $faker->numberBetween(1, 10),
                'radiation' => $faker->randomElement(['None', 'To back', 'To arms']),
                'quality' => $faker->randomElement(['Sharp', 'Dull', 'Aching']),
                'provoking_factors' => 'Walking, Standing',
                'palliating_factors' => 'Rest, Lying down',
            ]);
        }

        // Medical History
        $assessment->medicalHistory()->create([
            'problem_started_on' => $faker->sentence(),
            'illness_details' => $faker->sentence(),
            'doctor_hospital' => $faker->company(),
            'diagnosed_at' => $faker->city(),
            'dm_htn_asthma_cad_details' => 'DM: Yes, HTN: No, Asthma: No, CAD: Yes',
        ]);

        // Medication
        $assessment->medication()->create([
            'diabetes_medicine' => $faker->optional()->word(),
            'bp_medicine' => $faker->optional()->word(),
            'pain_medicine' => $faker->optional()->word(),
        ]);
    }
}
