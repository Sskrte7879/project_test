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
        Schema::create('nda_contracts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('disclosing_party'); // الطرف المُفصِح (صاحب المعلومات)
    $table->string('receiving_party');  // الطرف المُتلقي
    $table->string('project_name');     // اسم المشروع أو الغرض من الإفصاح
    $table->integer('duration_years');  // مدة التزام السرية (بالسنوات)
    $table->string('jurisdiction')->default('المحاكم المختصة بالمغرب'); // الاختصاص القضائي
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nda_contracts');
    }
};
