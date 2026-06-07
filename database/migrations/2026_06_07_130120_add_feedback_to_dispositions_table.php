<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dispositions', function (Blueprint $table) {
            $table->enum('status', ['pending', 'completed'])->default('pending')->after('due_date');
            $table->text('feedback_note')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('dispositions', function (Blueprint $table) {
            $table->dropColumn(['status', 'feedback_note']);
        });
    }
};
