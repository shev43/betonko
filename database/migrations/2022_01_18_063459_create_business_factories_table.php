<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessFactoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_factories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('business_id')->unsigned()->index();
            $table->string('contacts_id')->nullable();

            $table->string('factory_number')->nullable();

            $table->string('name')->nullable();
            $table->string('photo')->nullable();
            $table->text('address')->nullable();

            $table->double('map_latitude')->nullable();
            $table->double('map_longitude')->nullable();
            $table->double('map_zoom')->nullable();
            $table->double('map_rotate')->nullable();
            $table->double('marker_latitude')->nullable();
            $table->double('marker_longitude')->nullable();

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
        Schema::dropIfExists('business_factories');
    }
}
