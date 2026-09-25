<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weight_logs', function (Blueprint $table) {
            $table->id();
            $table->date('recorded_at'); // วันที่บันทึก
            $table->decimal('weight', 5, 2); // น้ำหนัก (กก.)
            $table->text('note')->nullable(); // บันทึกเพิ่มเติม
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weight_logs');
    }
};