<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('sidebar_menu')->insert([
            // Dashboard
            ['name' => 'Dashboard', 'url' => '/dashboard', 'parent_id' => null, 'order_no' => 1, 'role' => 'admin'],
            
            // Reports (Parent)
            ['name' => 'Reports', 'url' => null, 'parent_id' => null, 'order_no' => 2, 'role' => 'admin'],
            ['name' => 'Performance', 'url' => '/reports/performance', 'parent_id' => 2, 'order_no' => 1, 'role' => 'admin'],
            ['name' => 'Conversion', 'url' => '/reports/conversion', 'parent_id' => 2, 'order_no' => 2, 'role' => 'admin'],
            ['name' => 'Conversion logs', 'url' => '/reports/conversion-logs', 'parent_id' => 2, 'order_no' => 3, 'role' => 'admin'],
            ['name' => 'Click logs', 'url' => '/reports/click-logs', 'parent_id' => 2, 'order_no' => 4, 'role' => 'admin'],
            
            // Offers (Parent)
            ['name' => 'Offers', 'url' => null, 'parent_id' => null, 'order_no' => 3, 'role' => 'admin'],
            ['name' => 'Create', 'url' => '/offers/create', 'parent_id' => 6, 'order_no' => 1, 'role' => 'admin'],
            ['name' => 'Manage', 'url' => '/offers/manage', 'parent_id' => 6, 'order_no' => 2, 'role' => 'admin'],
            ['name' => 'Offer Categories', 'url' => '/offers/categories', 'parent_id' => 6, 'order_no' => 3, 'role' => 'admin'],
            ['name' => 'Offer Application', 'url' => '/offers/application', 'parent_id' => 6, 'order_no' => 4, 'role' => 'admin'],
            
            // Students
            ['name' => 'Student', 'url' => null, 'parent_id' => null, 'order_no' => 4, 'role' => 'student'],
            ['name' => 'Add', 'url' => '/students/add', 'parent_id' => 11, 'order_no' => 1, 'role' => 'student'],
            ['name' => 'Manage', 'url' => '/students/manage', 'parent_id' => 11, 'order_no' => 2, 'role' => 'student'],
            ['name' => 'Postback', 'url' => '/students/postback', 'parent_id' => 11, 'order_no' => 3, 'role' => 'student'],
            ['name' => 'Payment', 'url' => '/students/payment', 'parent_id' => 11, 'order_no' => 4, 'role' => 'student'],

            // Advertiser
            ['name' => 'Advertiser', 'url' => null, 'parent_id' => null, 'order_no' => 5, 'role' => 'advertiser'],
            ['name' => 'Add', 'url' => '/advertiser/add', 'parent_id' => 16, 'order_no' => 1, 'role' => 'advertiser'],
            ['name' => 'Manage', 'url' => '/advertiser/manage', 'parent_id' => 16, 'order_no' => 2, 'role' => 'advertiser'],

            // Employee
            ['name' => 'Employee', 'url' => null, 'parent_id' => null, 'order_no' => 6, 'role' => 'employee'],
            ['name' => 'Add', 'url' => '/employee/add', 'parent_id' => 19, 'order_no' => 1, 'role' => 'employee'],
            ['name' => 'Manage', 'url' => '/employee/manage', 'parent_id' => 19, 'order_no' => 2, 'role' => 'employee'],

            // Custom
            ['name' => 'Import Conversion', 'url' => '/custom/import-conversion', 'parent_id' => null, 'order_no' => 7, 'role' => 'admin'],
            ['name' => 'IP Whitelisting', 'url' => null, 'parent_id' => null, 'order_no' => 8, 'role' => 'admin'],
            ['name' => 'Add', 'url' => '/ip-whitelisting/add', 'parent_id' => 23, 'order_no' => 1, 'role' => 'admin'],
            ['name' => 'Manage', 'url' => '/ip-whitelisting/manage', 'parent_id' => 23, 'order_no' => 2, 'role' => 'admin'],

            // Mail Room
            ['name' => 'Mail Room', 'url' => '/mail-room', 'parent_id' => null, 'order_no' => 9, 'role' => 'admin'],

            // Preferences
            ['name' => 'Preferences', 'url' => null, 'parent_id' => null, 'order_no' => 10, 'role' => 'admin'],
            ['name' => 'Company', 'url' => '/preferences/company', 'parent_id' => 26, 'order_no' => 1, 'role' => 'admin'],
            ['name' => 'Email', 'url' => '/preferences/email', 'parent_id' => 26, 'order_no' => 2, 'role' => 'admin'],
            ['name' => 'Payment Methods', 'url' => '/preferences/payment-methods', 'parent_id' => 26, 'order_no' => 3, 'role' => 'admin'],
            ['name' => 'Signup Questions', 'url' => '/preferences/signup-questions', 'parent_id' => 26, 'order_no' => 4, 'role' => 'admin'],

            // Send Report
            ['name' => 'Send Report', 'url' => '/send-report', 'parent_id' => null, 'order_no' => 11, 'role' => 'admin'],

            // Signout
            ['name' => 'Signout', 'url' => '/signout', 'parent_id' => null, 'order_no' => 12, 'role' => 'admin'],
        ]);
    }
}
