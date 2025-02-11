<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->string('code')->nullable()->change();
            $table->foreignId('grade_id')->nullable()->constrained();
            $table->foreignId('strand_id')->nullable()->constrained();
        });
    }

    public function down()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->string('code')->nullable(false)->change();
            $table->dropForeign(['grade_id']);
            $table->dropForeign(['strand_id']);
            $table->dropColumn(['grade_id', 'strand_id']);
        });
    }
}; 