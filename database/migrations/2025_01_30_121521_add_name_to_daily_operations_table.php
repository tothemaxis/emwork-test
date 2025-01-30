<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameToDailyOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_operations', function (Blueprint $table) {
            // Add the 'name' column
            $table->string('name')->nullable(); // Make it nullable if not required
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_operations', function (Blueprint $table) {
            // Remove the 'name' column in case of rollback
            $table->dropColumn('name');
        });
    }
}
