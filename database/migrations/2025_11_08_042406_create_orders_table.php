<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->date('order_date');
            $table->date('due_date')->nullable();
            $table->decimal('total_price', 10, 2)->default(0);
            $table->decimal('down_payment', 10, 2)->default(0);
            $table->enum('status', ['Pending', 'Cutting', 'Sewing', 'Finishing', 'Ready', 'Completed'])->default('Pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};