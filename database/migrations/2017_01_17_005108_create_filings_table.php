<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filings', function (Blueprint $table) {
            $table->string('RETURN_ID');
            $table->string('FILING_TYPE');
            $table->string('EIN');
            $table->string('TAX_PERIOD');
            $table->string('SUB_DATE');
            $table->string('TAXPAYER_NAME');
            $table->string('RETURN_TYPE');
            $table->string('DLN');
            $table->string('OBJECT_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filings');
    }
}
