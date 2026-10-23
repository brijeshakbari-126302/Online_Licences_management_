<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->string('software_name');
            $table->string('license_key')->nullable();
            $table->string('license_type')->default('Subscription'); // Subscription, Perpetual, Per Seat, Enterprise, Trial
            $table->string('category')->nullable(); // Development, Design, Productivity, Security, Cloud, IT
            $table->integer('total_seats')->default(1);
            $table->decimal('cost_per_seat', 10, 2)->default(0.00);
            $table->string('currency', 10)->default('USD');
            $table->string('billing_cycle')->default('annually'); // monthly, annually, quarterly, one-time
            $table->date('purchase_date');
            $table->date('expiration_date')->nullable();
            $table->string('status')->default('active'); // active, expiring_soon, expired, suspended
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
