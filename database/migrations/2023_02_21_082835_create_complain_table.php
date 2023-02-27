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
        Schema::create('complain', function (Blueprint $table) {
            $table->id('complain_id');
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('pt');
            $table->string('dept');
            $table->string('mob');
            $table->string('pd');
            $table->string('file');
            $table->string('status');
            $table->string('file_update');
            $table->string('department_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complain');
    }
};
