<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMCListMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_c_list_members', function (Blueprint $table) {
            $table->string('id');
            $table->string('email_address');
            $table->string('unique_email_id');
            $table->string('email_type');
            $table->string('status');
            $table->json('merge_fields');
            $table->unsignedInteger('stats');
            $table->string('ip_signup');
            $table->string('timestamp_signup');
            $table->string('ip_opt');
            $table->integer('member_rating');
            $table->string('last_changed');
            $table->string('language');
            $table->boolean('vip');
            $table->string('email_client');
            $table->unsignedInteger('location');
            $table->string('list_id');

            $table->foreign('stats')->references('id')->on('member_stats');
            $table->foreign('location')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_c_list_members');
    }
}
