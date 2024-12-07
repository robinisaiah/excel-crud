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
            $table->bigIncrements('id');
            $table->string('customer_name');
            $table->string('email');
            $table->string('phone');
            $table->decimal('premium_amount', 10, 2);
            $table->decimal('gst_percentage', 5, 2)->default(18);
            $table->decimal('gst_amount', 10, 2);
            $table->decimal('total_premium_collected', 10, 2);
            $table->softDeletes(); // For soft delete
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
