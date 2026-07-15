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
        // 🟩 Only add the column if it does not exist yet
        if (Schema::hasTable('payments') && !Schema::hasColumn('payments', 'note')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->string('note')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 🟩 Only drop the column if it exists
        if (Schema::hasColumn('payments', 'note')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropColumn('note');
            });
        }
    }
};
