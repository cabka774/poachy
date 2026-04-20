<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'location')) {
                $table->string('location')->nullable()->after('email');
            }
        });

        Schema::table('sales', function (Blueprint $table) {
            if (!Schema::hasColumn('sales', 'customer_id')) {
                $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete()->after('user_id');
            }
        });

        // Convert settings from key/value to a single row per user
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'key')) {
                $table->dropUnique(['user_id', 'key']);
                $table->dropColumn(['key', 'value']);
            }

            if (!Schema::hasColumn('settings', 'business_name')) {
                $table->string('business_name')->default('My Business');
            }
            if (!Schema::hasColumn('settings', 'business_phone')) {
                $table->string('business_phone')->nullable();
            }
            if (!Schema::hasColumn('settings', 'business_email')) {
                $table->string('business_email')->nullable();
            }
            if (!Schema::hasColumn('settings', 'business_location')) {
                $table->string('business_location')->nullable();
            }
            if (!Schema::hasColumn('settings', 'currency')) {
                $table->string('currency', 10)->default('KSh');
            }
            if (!Schema::hasColumn('settings', 'tax_rate')) {
                $table->decimal('tax_rate', 5, 2)->default(16.00);
            }
            if (!Schema::hasColumn('settings', 'receipt_footer')) {
                $table->string('receipt_footer')->nullable()->default('Thank you for your business!');
            }

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'customer_id')) {
                $table->dropConstrainedForeignId('customer_id');
            }
        });

        Schema::table('customers', function (Blueprint $table) {
            if (Schema::hasColumn('customers', 'location')) {
                $table->dropColumn('location');
            }
        });

        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'business_name')) {
                $table->dropUnique(['user_id']);
                $table->dropColumn([
                    'business_name',
                    'business_phone',
                    'business_email',
                    'business_location',
                    'currency',
                    'tax_rate',
                    'receipt_footer',
                ]);
            }

            $table->string('key');
            $table->text('value')->nullable();
            $table->unique(['user_id', 'key']);
        });
    }
};
