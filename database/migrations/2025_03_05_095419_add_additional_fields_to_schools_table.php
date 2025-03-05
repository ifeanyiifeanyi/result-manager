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
        Schema::table('schools', function (Blueprint $table) {
            $table->text('short_description')->nullable()->after('description');
            $table->string('favicon')->nullable()->after('logo');
            $table->string('navbar_color')->nullable()->after('favicon');
            $table->string('paystack_subaccount_code')->nullable()->after('navbar_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['short_description', 'favicon', 'navbar_color', 'paystack_subaccount_code']);
        });
    }
};
