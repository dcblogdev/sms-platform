<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tenant_users', function (Blueprint $table) {
            $table->uuid('tenant_id');
            $table->uuid('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_users');
    }
};
