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
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'quantity_available')) {
                $table->integer('quantity_available')->after('quantity')->default(0);
            }
        });
        
        // Update existing records to set quantity_available = quantity
        \DB::table('tickets')->update([
            'quantity_available' => \DB::raw('quantity')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'quantity_available')) {
                $table->dropColumn('quantity_available');
            }
        });
    }
};
