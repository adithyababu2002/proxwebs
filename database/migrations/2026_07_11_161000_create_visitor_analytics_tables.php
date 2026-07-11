<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('visitor_uuid')->unique();
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('country', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('email', 190)->nullable()->index();
            $table->string('name', 120)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('browser', 80)->nullable();
            $table->string('platform', 80)->nullable();
            $table->string('device', 40)->nullable();
            $table->string('landing_page', 255)->nullable();
            $table->string('referrer', 500)->nullable();
            $table->unsignedInteger('page_views_count')->default(0);
            $table->unsignedInteger('events_count')->default(0);
            $table->unsignedInteger('total_duration_seconds')->default(0);
            $table->timestamp('first_seen_at')->nullable()->index();
            $table->timestamp('last_seen_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('visitor_page_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitor_session_id')->constrained('visitor_sessions')->cascadeOnDelete();
            $table->string('path', 255)->index();
            $table->string('title', 255)->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->unsignedInteger('duration_seconds')->default(0);
            $table->timestamps();

            $table->index(['visitor_session_id', 'started_at']);
        });

        Schema::create('visitor_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitor_session_id')->constrained('visitor_sessions')->cascadeOnDelete();
            $table->string('type', 60)->index();
            $table->string('path', 255)->nullable();
            $table->string('label', 255)->nullable();
            $table->json('meta')->nullable();
            $table->timestamp('occurred_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_events');
        Schema::dropIfExists('visitor_page_views');
        Schema::dropIfExists('visitor_sessions');
    }
};
