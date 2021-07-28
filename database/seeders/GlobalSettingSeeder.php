<?php

namespace Database\Seeders;

use App\Models\GlobalSetting;
use Illuminate\Database\Seeder;

class GlobalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GlobalSetting::create([
           'key' => 'selling_fees_percentage',
            'value' => 30
        ]);
    }
}
