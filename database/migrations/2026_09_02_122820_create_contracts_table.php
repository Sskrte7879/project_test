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
    Schema::create('contracts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('type')->default('prestation_it');
        $table->string('client_name');
        $table->string('dev_name');
        $table->text('project_desc');
        $table->decimal('price', 10, 2);
        $table->string('ip_transfer');
        $table->string('non_compete');
        $table->string('compete_city')->nullable();
        $table->integer('compete_months')->nullable();
        $table->integer('support_months');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
