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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // id, Primary Key, Auto increment

            $table->string('name', 255); // Nama produk
            $table->string('slug', 255)->unique(); // Slug unik
            $table->text('description')->nullable(); // Deskripsi
            $table->text('short_description')->nullable(); // Deskripsi pendek

            $table->decimal('price', 10, 2)->default(0); // Harga
            $table->integer('stock')->default(0); // Stok

            $table->foreignId('product_category_id')
                  ->nullable()
                  ->constrained('product_categories')
                  ->nullOnDelete()
                  ->cascadeOnUpdate(); // Relasi ke kategori produk

            $table->string('image_url', 255)->nullable(); // Gambar produk
            $table->boolean('is_active')->default(true); // Status aktif

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
