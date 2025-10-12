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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

			$table->string('name');
			$table->string('father');
			$table->string('mother');
            $table->date('dob');
			$table->string('school');
			$table->string('mobile');			
			$table->enum('group', ['A', 'B', 'C', 'D'])->nullable();
			$table->string('reg_number')->nullable()->unique();

			$table->string('image')->nullable();
			$table->string('certificate')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
