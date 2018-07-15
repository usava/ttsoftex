<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMCListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_c_lists', function (Blueprint $table) {
            $table->string('id');
            $table->unsignedInteger('web_id');
            $table->string('name');
            $table->unsignedInteger('contact');
            $table->string('permission_reminder');
            $table->boolean('use_archive_bar');
            $table->unsignedInteger('campaign_defaults');
            $table->string('notify_on_subscribe');
            $table->string('notify_on_unsubscribe');
            $table->string('date_created');
            $table->integer('list_rating');
            $table->boolean('email_type_option');
            $table->string('subscribe_url_short');
            $table->string('subscribe_url_long');
            $table->string('beamer_address');
            $table->string('visibility');
            $table->text('modules');
            $table->unsignedInteger('stats');

            $table->foreign('contact')->references('id')->on('contacts');
            $table->foreign('campaign_defaults')->references('id')->on('compaigns');
            $table->foreign('stats')->references('id')->on('stats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_c_lists');
    }
}
