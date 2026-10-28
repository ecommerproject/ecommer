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
        Schema::table('products', function (Blueprint $table): void {
            if (!Schema::hasColumn('products', 'badge_color')) {
                $table->string('badge_color', 100)->nullable()->after('badge');
            }
            if (!Schema::hasColumn('products', 'badge_style')) {
                $table->string('badge_style', 40)->nullable()->default('solid')->after('badge_color');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            if (Schema::hasColumn('products', 'badge_color')) {
                $table->dropColumn('badge_color');
            }
            if (Schema::hasColumn('products', 'badge_style')) {
                $table->dropColumn('badge_style');
            }
        });
    }
};
