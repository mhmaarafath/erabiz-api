<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Country;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Speciality;
use App\Models\State;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(public_path('countries.json'));
        $data = json_decode($json);

        foreach ($data as $item) {
            Country::create([
                'id' => $item->id,
                'name' => $item->name,
            ]);
        }

        $json = file_get_contents(public_path('states.json'));
        $data = json_decode($json);

        foreach ($data as $item) {
            State::create([
                'id' => $item->id,
                'country_id' => $item->country_id,
                'name' => $item->name,
            ]);
        }

        $specialities = [
            'Allergists',
            'Anesthesiologists',
            'Cardiologists',
            'Dermatologists',
            'Endocrinologists',
        ];

        foreach ($specialities as $speciality){
            Speciality::factory()->create([
                'name' => $speciality,
            ]);
        }

        Doctor::factory(15)->create();

        Hospital::factory(15)->create();
    }
}
