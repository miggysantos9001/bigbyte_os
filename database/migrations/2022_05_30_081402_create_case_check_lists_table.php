<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseCheckListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_check_lists', function (Blueprint $table) {
            $table->id();
            $table->date('date_delivery')->nullable();
            $table->integer('case_setup_id');
            $table->integer('branch_id');
            $table->integer('product_id');
            $table->integer('qty_delivered');
            $table->integer('qty_used');
            $table->tinyInteger('isPulledout')->default(0);
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
        Schema::dropIfExists('case_check_lists');
    }
}
