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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->date('atten_date')->nullable();
            $table->time('punch_in')->nullable();
            $table->time('punch_out')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->integer('member_id')->nullable();
            $table->string('member_code')->nullable();
            $table->string('member_type')->nullable();
            $table->integer('transfer_status')->default(0);
            $table->string('atten_type')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
