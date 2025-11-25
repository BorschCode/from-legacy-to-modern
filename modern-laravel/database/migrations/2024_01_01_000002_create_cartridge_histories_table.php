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
        Schema::create('cartridge_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cartridge_id')->constrained('cartridges')->onDelete('cascade')->comment('Linked item ID from cartridges table');
            $table->string('owner', 40)->default('Log start')->comment('Location or owner according to inventory records');
            $table->integer('weight_before')->default(0)->comment('Weight before sending to the service center');
            $table->integer('weight_after')->default(0)->comment('Weight after refilling');
            $table->date('date_outcome')->nullable()->comment('Date sent to the service center');
            $table->date('date_income')->nullable()->comment('Date received from the service center');
            $table->string('servicename', 50)->default('Log start')->comment('Service center performing repair/refill');
            $table->tinyInteger('technical_life')->default(1)->comment('Cartridge condition: active (1) or inactive (0)');
            $table->text('log')->nullable()->comment('Short change history: records only keys and values that were modified');
            $table->text('log_full')->nullable()->comment('Full change log: records all data before and after each edit');
            $table->date('date_of_changes')->nullable()->comment('Date when changes were made');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartridge_histories');
    }
};
