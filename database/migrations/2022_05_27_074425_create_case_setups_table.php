<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_setups', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('patient_name');
            $table->integer('branch_id');
            $table->integer('agent_id');
            $table->integer('surgeon_id');
            $table->integer('hospital_id');
            $table->integer('implant_id');
            $table->date('date_delivery');
            $table->date('date_surgery');
            $table->text('notes')->nullable();
            $table->integer('status_id');
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
        Schema::dropIfExists('case_setups');
    }
}
