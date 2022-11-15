<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branches_id')->nullable()->index();
            $table->date('walkin_date');
            $table->foreignId('cities_id')->nullable()->index();
            $table->string('customer_name');
            $table->string('mobile_no');
            $table->string('email');
            $table->foreignId('vehicles_id')->nullable()->index();
            $table->foreignId('model_names_id')->nullable()->index();
            $table->foreignId('varients_id')->nullable()->index();
            $table->string('customer_type');
            $table->string('sale_status');
            $table->date('followup_date');
            $table->foreignId('employees_id')->nullable()->index();
            $table->longtext('remarks');
            $table->string('welcome_sms');
            $table->string('thankyou_sms');
            $table->datetime('welcome_at');
            $table->datetime('thankyou_at');
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
        Schema::dropIfExists('customers');
    }
}
