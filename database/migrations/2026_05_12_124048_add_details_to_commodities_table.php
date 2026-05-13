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
        Schema::table('commodities', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->foreignId('program_study_id')->nullable()->constrained('program_studies')->onDelete('cascade');
            $table->string('item_code')->nullable()->unique();
            $table->integer('stock')->default(0);
            $table->enum('condition', ['good', 'broken', 'lost'])->default('good');
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commodities', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['program_study_id']);
            $table->dropColumn(['category_id', 'program_study_id', 'item_code', 'stock', 'condition', 'image']);
        });
    }
};
