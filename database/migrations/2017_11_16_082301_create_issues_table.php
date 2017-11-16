<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->integer('id')->nullable();
            $table->string('self')->nullable();
            $table->string('key')->nullable();
            $table->string('fields_issuetype')->nullable();
            $table->string('fields_resolution')->nullable();
            $table->string('fields_resolution')->nullable();
            $table->string('fields_assignee')->nullable();
            $table->string('fields_status')->nullable();
            $table->string('fields_reporter')->nullable();
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
        Schema::dropIfExists('issues');
    }
}
