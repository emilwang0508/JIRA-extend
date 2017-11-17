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
            $table->string('user_id')->nullable();
            $table->string('user_key')->nullable();
            $table->string('fields')->nullable();
            $table->string('issuetype')->nullable();
            $table->string('project_id')->nullable();
            $table->string('project_key')->nullable();
            $table->string('project_name')->nullable();
            $table->string('project')->nullable();
            $table->string('assignee_key')->nullable();
            $table->string('assignee_name')->nullable();
            $table->string('assignee')->nullable();
            $table->string('creator_key')->nullable();
            $table->string('creator_name')->nullable();
            $table->string('creator')->nullable();
            $table->string('summary')->nullable();
            $table->string('reporter_key')->nullable();
            $table->string('reporter_name')->nullable();
            $table->string('reporter')->nullable();
            $table->string('changelog')->nullable();
            $table->string('status_id')->nullable();
            $table->string('status_name')->nullable();
            $table->string('statusCategory_key')->nullable();
            $table->string('statusCategory_id')->nullable();
            $table->string('status')->nullable();
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
