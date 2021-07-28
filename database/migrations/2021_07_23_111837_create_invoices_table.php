<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
             $table->id();
             $table->unsignedBigInteger('creditor_id');
             $table->foreign('creditor_id')->references('id')->on('companies');
             $table->unsignedBigInteger('debtor_id');
             $table->foreign('debtor_id')->references('id')->on('companies');
             $table->tinyInteger('status')->default(0);
             $table->timestamp('paid_at')->nullable();
             $table->date('due_date');
             $table->decimal('total_amount',10);
             $table->decimal('selling_amount',10);
             $table->decimal('fees_amount',10);
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}
