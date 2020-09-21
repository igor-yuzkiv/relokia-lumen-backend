<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->unsignedBigInteger("assignee");
            $table->unsignedBigInteger("reporter");
            $table->string("status");
            $table->timestamps();
        });

        Schema::table("ticket", function (Blueprint $table) {
            $table->foreign("assignee")->references("id")->on("users");
            $table->foreign("reporter")->references("id")->on("users");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket');
    }
}
