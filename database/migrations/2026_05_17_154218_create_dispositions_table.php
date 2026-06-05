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
        Schema::create('dispositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_letter_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->comment('Who made the disposition');
            // GANTI MENJADI FOREIGN ID KE TABEL USERS:
            $table->foreignId('assigned_user_id')->constrained('users')->onDelete('cascade');
            $table->text('instruction');
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispositions');
    }
};
