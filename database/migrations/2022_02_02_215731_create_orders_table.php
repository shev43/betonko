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
            $table->id();
            $table->bigInteger('client_id')->nullable()->unsigned()->index();
            $table->bigInteger('seller_id')->nullable()->unsigned()->index();
            $table->bigInteger('factory_id')->nullable()->unsigned()->index();
            $table->bigInteger('offers_id')->nullable()->unsigned()->index();

            $table->boolean('is_tender')->default(false);

            $table->string('order_number')->nullable();

            $table->string('mark')->nullable();
            $table->string('class')->nullable();
            $table->string('frost_resistance')->nullable();
            $table->string('water_resistance')->nullable();
            $table->string('mixture_mobility')->nullable();
            $table->string('winter_supplement')->nullable();

            $table->smallInteger('count')->nullable();
            $table->decimal('min_price', 8, 0)->nullable();
            $table->decimal('max_price', 8, 0)->nullable();

            $table->string('contact_first_name')->nullable();
            $table->string('contact_last_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->text('comment')->nullable();

            $table->enum('type_of_delivery', ['self', 'business'])->default('business');

            $table->date('date_of_delivery')->nullable();
            $table->date('start_date_of_delivery')->nullable();
            $table->date('end_date_of_delivery')->nullable();

            $table->string('address')->nullable();

            $table->double('map_latitude')->nullable();
            $table->double('map_longitude')->nullable();
            $table->double('map_zoom')->nullable();
            $table->double('map_rotate')->nullable();

            $table->double('marker_latitude')->nullable();
            $table->double('marker_longitude')->nullable();

            $table->enum('status', ['new', 'accepted', 'executed', 'done', 'expired', 'canceled'])->default('new');

            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('factory_id')->references('id')->on('business_factories')->onDelete('cascade');

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
