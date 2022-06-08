<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('subtwo_id');
            $table->string('catalog_no');
            $table->string('uom_id');
            $table->string('description');
            $table->decimal('capital_usd',9,2);
            $table->decimal('capital_php',9,2);
            $table->decimal('exchange_rate',9,2);
            $table->decimal('agent_price',9,2);
            $table->decimal('outsource_price',9,2);
            $table->tinyInteger('isActive')->default(0);
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
        Schema::dropIfExists('products');
    }
}
