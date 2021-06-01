<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewspaperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newspapers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('advantages')->nullable();
            $table->string('questions')->nullable();
            $table->string('img')->nullable();
            $table->integer('status')->default(1);
            $table->string('type')->nullable();
            $table->string('published_at')->nullable();
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
        Schema::dropIfExists('newspapers');
    }
}
