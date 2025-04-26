<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_roles', function (Blueprint $table) {
            $table->id();
            $table->integer('membership_id');
            $table->integer('role_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_roles');
    }
};
