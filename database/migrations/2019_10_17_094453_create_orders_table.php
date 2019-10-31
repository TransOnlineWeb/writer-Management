<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->string('title');
            $table->text('description');
            $table->dateTime('deadline');
            $table->integer('pages')->unsigned();
            $table->integer('status')->unsigned();
            $table->string('viewers');
            $table->string('academic_level');
            $table->string('discipline');
            $table->string('paper_format');
            $table->string('spacing');
            $table->decimal('amount',8,2)->nullable();
            $table->integer('urgency')->default(0)->unsigned();
            $table->unsignedBigInteger('assigned_user_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
