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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('products_id')->references('id')->on('products');
            $table->unsignedBigInteger('products_id')->nullable()
           
            $table->integer('cantidad');
            $table->decimal('precio unitario', 10, 4);
            $table->decimal('total', 10, 4);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
