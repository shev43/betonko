<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('business_id')->unsigned()->index();
            $table->string('factories_id')->nullable();
            $table->string('product_number')->nullable();
            $table->string('mark')->nullable();
            $table->string('class')->nullable();
            $table->string('water_resistance')->nullable();
            $table->string('winter_supplement')->nullable();
            $table->string('mixture_mobility')->nullable();
            $table->string('frost_resistance')->nullable();
            $table->decimal('price', 8, 0)->nullable();
            $table->text('comment')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_products');
    }
}
