<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('seller_id')->unsigned()->index();
            $table->bigInteger('order_id')->unsigned()->index();
            $table->bigInteger('factory_id')->nullable()->unsigned()->index();
            $table->string('offer_number')->nullable();

            $table->string('mark')->nullable();
            $table->string('class')->nullable();
            $table->string('frost_resistance')->nullable();
            $table->string('water_resistance')->nullable();
            $table->string('mixture_mobility')->nullable();
            $table->string('winter_supplement')->nullable();

            $table->decimal('price', 8, 0)->nullable();
            $table->decimal('delivery', 8, 0)->nullable();

            $table->enum('status', ['new', 'changed', 'history', 'canceled'])->default('new');
            $table->enum('canceled_by', ['client', 'seller', 'cron'])->nullable();
            $table->string('canceled_comment')->nullable();

            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('factory_id')->references('id')->on('business_factories')->onDelete('cascade');

            $table->unique(['order_id', 'seller_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
