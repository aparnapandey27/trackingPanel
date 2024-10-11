<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrowserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $browsers = array(
            array('id' => 1, 'name' => 'Chrome'),
            array('id' => 2, 'name' => 'Firefox'),
            array('id' => 3, 'name' => 'Edge'),
            array('id' => 4, 'name' => 'Internet Explorer'),
            array('id' => 5, 'name' => 'Safari'),
            array('id' => 6, 'name' => 'Opera'),
            array('id' => 7, 'name' => 'Chromium'),
            array('id' => 8, 'name' => 'Netscape Navigator'),
            array('id' => 9, 'name' => 'Yandex Browser'),
            array('id' => 10, 'name' => 'Tor'),
            array('id' => 11, 'name' => 'Brave'),
            array('id' => 12, 'name' => 'SeaMonkey'),
            array('id' => 13, 'name' => 'UC Browser'),
            array('id' => 14, 'name' => 'CometBird'),
            array('id' => 15, 'name' => 'Maxthon'),
        );

        if (DB::table('browsers')->count() == 0) {
            DB::table('browsers')->insert($browsers);
        }
    }
}
