<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('subject_user', function (Blueprint $table) {
            $table->decimal('midterm_grade', 5, 2)->nullable();
            $table->decimal('final_grade', 5, 2)->nullable();
            $table->decimal('computed_grade', 5, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('subject_user', function (Blueprint $table) {
            $table->dropColumn(['midterm_grade', 'final_grade', 'computed_grade']);
        });
    }
}; 