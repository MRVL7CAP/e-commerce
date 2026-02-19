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
        Schema::table('products', function (Blueprint $table) {
            $table->string('old_price')->nullable();
            $table->string('rating')->nullable();
            $table->string('rating_count')->nullable();
            $table->string('is_published')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('old_price');
            $table->dropColumn('rating');
            $table->dropColumn('rating_count');
            $table->dropColumn('is_published');
        });
    }
};
