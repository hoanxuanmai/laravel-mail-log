<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHxmMailErrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hxm_mail_errors', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('message');
            $table->text('trace');
            $table->foreign('id')->on('hxm_mail_logs')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hxm_mail_errors');
    }
}
