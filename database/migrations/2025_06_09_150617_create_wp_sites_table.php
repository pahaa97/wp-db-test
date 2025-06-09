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
        Schema::create('wp_sites', function (Blueprint $table) {
            $table->id();
            $table->string('site_url')->unique();
            $table->string('admin_url')->unique();
            $table->string('admin_login');
            $table->string('admin_password');
            $table->string('server_host')->nullable();
            $table->string('server_login')->nullable();
            $table->string('server_password')->nullable();
            $table->string('cdn_name')->nullable();
            $table->string('cdn_login')->nullable();
            $table->string('cdn_password')->nullable();
            $table->boolean('admin_login_is_valid')->nullable();
            $table->timestamp('last_admin_login_check_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wp_sites');
    }
};
