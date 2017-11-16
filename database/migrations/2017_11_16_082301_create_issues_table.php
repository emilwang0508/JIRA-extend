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
            $table->integer('user_id')->nullable();
            $table->integer('user_key')->nullable();
            $table->string('fields')->nullable();
            $table->string('fields_issuetype')->nullable();
            $table->string('project_id')->nullable();
            $table->string('project_key')->nullable();
            $table->string('project')->nullable();
            $table->string('fields_project')->nullable();
            $table->string('fields_assignee_id')->nullable();
            $table->string('fields_assignee_name')->nullable();
            $table->string('fields_assignee')->nullable();
            $table->string('fields_status')->nullable();
            $table->string('fields_creator')->nullable();
            $table->string('fields_summary')->nullable();
            $table->string('fields_reporter')->nullable();
            $table->string('changelog')->nullable();
            $table->string('status_id')->nullable();
            $table->string('status_name')->nullable();
            $table->string('statusCategory_key')->nullable();
            $table->string('statusCategory_id')->nullable();
            $table->string('remark')->nullable();
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
