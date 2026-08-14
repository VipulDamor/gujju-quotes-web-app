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
        Schema::create('contact_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_id', 50)->unique();
            $table->string('name', 100)->nullable();
            $table->string('email', 255)->index();
            $table->string('phone', 20)->nullable();
            $table->string('category', 50)->default('general')->index();
            $table->string('subject', 255);
            $table->text('message');

            // App Information
            $table->string('app_version', 30);
            $table->string('platform', 20)->default('android');
            $table->string('os_version', 50);
            $table->string('device_model', 100);
            $table->string('device_manufacturer', 100);
            $table->string('language', 20);
            $table->string('country', 10);

            // User context
            $table->bigInteger('user_id')->nullable()->index();
            $table->boolean('is_logged_in')->default(false);

            // Administration
            $table->string('status', 20)->default('new')->index();
            $table->string('priority', 20)->default('normal')->index();
            $table->text('admin_response')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users')->onDelete('set null');

            // Technical metadata
            $table->string('ip_address', 45);
            $table->text('user_agent');
            $table->string('api_version', 10)->default('v1');

            // Soft Deletes
            $table->boolean('is_deleted')->default(false)->index();
            $table->timestamp('deleted_at')->nullable();

            $table->timestamps();
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_requests');
    }
};
