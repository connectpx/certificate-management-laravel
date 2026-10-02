<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('handler_name');
            $table->string('certificate_number')->unique();
            $table->date('date_of_assessment');
            $table->string('training_organization');
            $table->string('assessor_name');
            $table->string('result'); // PASS | FAIL
            $table->string('status')->default('active'); // active | inactive
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
