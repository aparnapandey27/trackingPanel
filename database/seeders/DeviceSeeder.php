<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device;

class DeviceSeeder extends Seeder
{
    public function run()
    {
        Device::create(['name' => 'Desktop']);
        Device::create(['name' => 'Mobile']);
        Device::create(['name' => 'Tablet']);
    }
}
