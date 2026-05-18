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
        Schema::create('outgoing_letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_number')->unique();
            $table->date('letter_date');
            $table->string('destination'); // Tujuan surat
            $table->string('subject');     // Perihal
            $table->text('description')->nullable();
            $table->string('file_path')->nullable(); // Nullable because drafts might not have a file yet
            $table->enum('status', ['draft', 'sent', 'archived'])->default('draft');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who created the letter
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_letters');
    }
};
