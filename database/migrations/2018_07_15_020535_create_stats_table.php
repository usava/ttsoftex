<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_count');
            $table->string('unsubscribe_count');
            $table->string('cleaned_count');
            $table->string('member_count_since_send');
            $table->string('unsubscribe_count_since_send');
            $table->string('cleaned_count_since_send');
            $table->string('campaign_count');
            $table->string('campaign_last_sent');
            $table->unsignedInteger('merge_field_count');
            $table->integer('avg_sub_rate');
            $table->integer('avg_unsub_rate');
            $table->integer('target_sub_rate');
            $table->integer('open_rate');
            $table->string('click_rate');
            $table->string('last_sub_date');
            $table->string('last_unsub_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stats');
    }
}
