<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAffiliateIdToStudentIdInClicksTable extends Migration
{
    public function up()
    {
        Schema::table('clicks', function (Blueprint $table) {
            $table->renameColumn('affiliate_id', 'student_id');
        });
    }

    public function down()
    {
        Schema::table('clicks', function (Blueprint $table) {
            $table->renameColumn('student_id', 'affiliate_id');
        });
    }
}
