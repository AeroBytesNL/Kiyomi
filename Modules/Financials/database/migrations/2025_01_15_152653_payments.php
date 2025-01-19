<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->onDelete('cascade');
			$table->decimal('amount', 8, 2);
			$table->string('payment_method');
			$table->integer('payment_status');
			$table->string('transaction_id');
			$table->timestamps();
		});
    }
	
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
