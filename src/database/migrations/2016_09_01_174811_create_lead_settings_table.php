<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mailer_name')->nullable();
            $table->string('thank_you_subject')->nullable();
            $table->text('thank_you_body')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::drop('lead_settings');
        Schema::enableForeignKeyConstraints();
    }
}
