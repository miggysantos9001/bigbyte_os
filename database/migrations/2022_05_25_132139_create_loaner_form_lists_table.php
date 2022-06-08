<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanerFormListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loaner_form_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('loaner_form_id');
            $table->integer('product_id');
            $table->integer('qty');
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
        Schema::dropIfExists('loaner_form_lists');
    }
}
