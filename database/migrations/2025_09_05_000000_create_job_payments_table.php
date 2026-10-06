<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('job_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_application_id');
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('show_agent_id');
            $table->double('amount');
            $table->double('platform_fee');
            $table->double('show_agent_amount');
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('status')->nullable();
            $table->longText('transaction_details')->nullable();
            $table->timestamps();

            $table->foreign('job_application_id')->references('id')->on('job_applications')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('show_agent_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_payments');
    }
};
