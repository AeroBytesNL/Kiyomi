<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_export', function (Blueprint $table) {
          $table->id()->autoIncrement();
          $table->string('file_name');
          $table->date('made_on');
          $table->string('made_by');
          $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_export');
    }
};
