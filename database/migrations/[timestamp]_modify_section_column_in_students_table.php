<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // First make it nullable
            $table->string('section')->nullable()->change();
            // Or if you want to remove it completely since we're using section_id
            // $table->dropColumn('section');
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            // If you made it nullable
            $table->string('section')->nullable(false)->change();
            // Or if you dropped it
            // $table->string('section');
        });
    }
}; 