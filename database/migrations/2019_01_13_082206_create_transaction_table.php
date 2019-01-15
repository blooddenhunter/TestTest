<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->enum('type', ['default', 'first', 'regular', 'refund'])->default('default');
            $table->enum('operation', ['deposit', 'withdraw'])->default('deposit');
            $table->enum('status', ['await', 'processing', 'success', 'failed'])->default('await');
            $table->smallInteger('sum')->unsigned();
            $table->timestamps();


            $table->index('updated_at');
            $table->index('client_id');

            $table->foreign('client_id')
                ->references('id')
                ->on('client')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
