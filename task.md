## ✍️ Tugas Praktik Laravel: **Relasi Tabel & CRUD Produk dengan FluxUI**

### 🎯 Tujuan Pembelajaran

Pada tugas ini, Anda akan:

* Membuat struktur database menggunakan Laravel Migrations.
* Mengimplementasikan relasi antar tabel.
* Membangun fitur CRUD untuk produk dengan **FluxUI**.
* Mendokumentasikan proses instalasi dan konfigurasi pada blog pribadi, **melanjutkan tulisan blog sebelumnya**.

---

### 🧱 Bagian 1: Membuat Migrations untuk Tiga Tabel

Silakan definisikan tiga buah tabel berikut dalam folder `database/migrations` menggunakan fitur Laravel Migrations:

#### 1. Tabel `customers`

* `id` (BIGINT, UNSIGNED, PRIMARY KEY, AUTO\_INCREMENT)
* `name` (VARCHAR(255), NOT NULL)
* `email` (VARCHAR(255), UNIQUE, NOT NULL)
* `address` (TEXT, NULLABLE)
* `created_at`, `updated_at` (TIMESTAMP, NULLABLE)

#### 2. Tabel `orders`

* `id` (BIGINT, UNSIGNED, PRIMARY KEY, AUTO\_INCREMENT)
* `customer_id` (BIGINT, UNSIGNED, NOT NULL) – *foreign key ke tabel `customers`*
* `order_date` (DATE, NOT NULL)
* `total_amount` (DECIMAL(10, 2), NOT NULL, DEFAULT 0.00)
* `status` (ENUM: `'pending'`, `'processing'`, `'completed'`, `'cancelled'`)
* `created_at`, `updated_at` (TIMESTAMP, NULLABLE)

#### 3. Tabel `order_details`

* `id` (BIGINT, UNSIGNED, PRIMARY KEY, AUTO\_INCREMENT)
* `order_id` (BIGINT, UNSIGNED, NOT NULL) – *foreign key ke tabel `orders`*
* `product_id` (BIGINT, UNSIGNED, NOT NULL) – *foreign key ke tabel `products`*
* `quantity` (INTEGER, UNSIGNED, NOT NULL, DEFAULT 1)
* `unit_price` (DECIMAL(10, 2), NOT NULL)
* `subtotal` (DECIMAL(10, 2), NOT NULL)
* `created_at`, `updated_at` (TIMESTAMP, NULLABLE)

---

### 🧑‍💻 Bagian 2: CRUD Produk menggunakan FluxUI

Implementasikan fitur CRUD (Create, Read, Update, Delete) untuk **tabel `products`** di bagian **administrator aplikasi** Anda menggunakan **FluxUI**.

#### ✅ Persyaratan:

* Gunakan **controller Laravel** untuk menangani logika bisnis CRUD.
* Gunakan komponen **FluxUI** ([https://fluxui.dev](https://fluxui.dev)) untuk membangun UI:
  Form input, tabel data, tombol aksi, dan notifikasi.
* Tambahkan **route khusus**:
  `/dashboard/products`
* Pastikan terdapat **validasi input** yang sesuai.
* CRUD harus bisa berjalan **dari UI** dan **tersimpan ke database**.

---

### 📝 Dokumentasi di Blog: **Melanjutkan Tulisan Sebelumnya**

Buatlah satu artikel blog lanjutan dari postingan Anda sebelumnya (*"Pengenalan Laravel dan Instalasi Laravel"*) dengan judul seperti berikut:

> **Membangun Struktur Database dan CRUD Produk di Laravel dengan FluxUI**

Gunakan gaya penulisan yang **konsisten dengan blog sebelumnya**:

* Gunakan penjelasan yang **ringan, runut, dan bisa diikuti oleh pemula**.
* Sertakan potongan kode seperti contoh migration, controller, route, dan tampilan.
* Tunjukkan langkah-langkah instalasi **FluxUI**, termasuk perintah yang dijalankan dan konfigurasi yang diubah (jika ada).
* Tambahkan screenshot UI jika memungkinkan.

---

### 📦 Output yang Diharapkan

1. Tiga file migration (`customers`, `orders`, `order_details`)
2. CRUD lengkap untuk tabel `products` berbasis FluxUI
3. File controller Laravel untuk `ProductController`
4. File view atau komponen FluxUI
5. URL blog pribadi berisi dokumentasi lanjutan
