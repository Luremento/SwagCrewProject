<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->timestamps();
        });

        DB::table('categories')->insert([
            ['name' => 'Биты', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Киты', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Лупы', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Пресеты', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Миксы', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
