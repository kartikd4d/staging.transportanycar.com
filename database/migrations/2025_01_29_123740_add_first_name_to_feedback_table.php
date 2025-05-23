<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirstNameToFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->string('first_name')->nullable()->default(null);
            $table->string('vehical_name')->nullable()->default(null);
            $table->unsignedBigInteger('transporter_id')->nullable();
            $table->date('date')->nullable(); 
            $table->foreign('transporter_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feedback', function (Blueprint $table) {
            //
            $table->dropColumn('first_name');
        });
    }
}
