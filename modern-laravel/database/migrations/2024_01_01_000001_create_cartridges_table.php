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
        Schema::create('cartridges', function (Blueprint $table) {
            $table->id();
            $table->string('owner', 50)->comment('Location or owner according to inventory records');
            $table->string('brand', 50)->comment('Manufacturer of the cartridge');
            $table->string('marks', 50)->comment('Model of the cartridge assigned by the manufacturer');
            $table->integer('weight_before')->default(0)->comment('Weight before sending to the service center');
            $table->integer('weight_after')->default(0)->comment('Weight after refilling');
            $table->date('date_outcome')->nullable()->comment('Date sent to the service center');
            $table->date('date_income')->nullable()->comment('Date received from the service center');
            $table->string('servicename', 30)->nullable()->comment('Service center performing repair/refill');
            $table->string('comments', 50)->nullable()->comment('Comments describing the cartridge status');
            $table->tinyInteger('technical_life')->default(1)->comment('Cartridge condition: in use (1) or decommissioned (0)');
            $table->string('code', 30)->comment('Unique cartridge code or inventory number');
            $table->tinyInteger('inservice')->default(0)->comment('Service status: 1 - in service, 0 - not in service (auto-calculated)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartridges');
    }
};
