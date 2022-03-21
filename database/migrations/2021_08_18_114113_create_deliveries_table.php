<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Deliveries', function (Blueprint $table) {
            $table->id('DeliveryID');
            $table->unsignedBigInteger('CustomerID');
            $table->foreign('CustomerID')->references('CustomerID')->on('Customers');
            $table->string('InvoiceID');
            $table->text('DeliveryAddress');
            $table->string('AssignedBy');
            $table->foreign('AssignedBy')->references('UserID')->on('UserManager');
            $table->dateTime('AssignedTime');
            $table->dateTime('StartTime')->nullable();
            $table->dateTime('EndTime')->nullable();
            $table->text('SpecialInstruction')->nullable();
            $table->string('RiderID');
            $table->string('OTP')->nullable();
            $table->tinyInteger('OTPVerified')->default(0);
            $table->foreign('RiderID')->references('UserID')->on('UserManager');
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
        Schema::dropIfExists('deliveries');
    }
}
