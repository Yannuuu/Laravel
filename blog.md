# Membangun Struktur Database dan CRUD Produk di Laravel

Pada artikel sebelumnya, kita telah membahas tentang pengenalan Laravel dan proses instalasinya. Kali ini, kita akan melanjutkan dengan membangun struktur database dan mengimplementasikan fitur CRUD (Create, Read, Update, Delete) untuk produk menggunakan Laravel.

## Persiapan Awal

Sebelum mulai, pastikan Laravel project sudah terinstall dan database sudah terkonfigurasi dengan benar di file `.env`. Kita akan membuat sistem manajemen produk dengan fitur kategori.

## Membuat Struktur Database

### 1. Migration untuk Tabel Customers

```bash
php artisan make:migration create_customers_table --create=customers
```

File migration untuk customers:

```php
public function up()
{
    Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->text('address')->nullable();
        $table->timestamps();
    });
}
```

### 2. Migration untuk Tabel Orders

```bash
php artisan make:migration create_orders_table --create=orders
```

File migration untuk orders:

```php
public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->constrained()->onDelete('cascade');
        $table->date('order_date');
        $table->decimal('total_amount', 10, 2)->default(0.00);
        $table->enum('status', ['pending', 'processing', 'completed', 'cancelled']);
        $table->timestamps();
    });
}
```

### 3. Migration untuk Tabel Order Details

```bash
php artisan make:migration create_order_details_table --create=order_details
```

File migration untuk order details:

```php
public function up()
{
    Schema::create('order_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained()->onDelete('restrict');
        $table->unsignedInteger('quantity')->default(1);
        $table->decimal('unit_price', 10, 2);
        $table->decimal('subtotal', 10, 2);
        $table->timestamps();
    });
}
```

### 4. Migration untuk Tabel Product Categories

```bash
php artisan make:migration create_product_categories_table --create=product_categories
```

File migration untuk kategori produk:

```php
public function up()
{
    Schema::create('product_categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}
```

## Implementasi Model

### 1. Model Product Category

```php
class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
```

### 2. Model Product

```php
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'stock',
        'product_category_id',
        'image_url',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
```

## Implementasi Controller

ProductController untuk menangani operasi CRUD:

```php
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'short_description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    // ... method update dan delete
}
```

## Implementasi Views

### 1. Form Component (resources/views/components/products/form.blade.php)

Kita membuat form component yang reusable untuk create dan edit:

```php
@props(['product' => null, 'categories' => []])

<div class="space-y-4">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="name" id="name" 
               value="{{ old('name', $product?->name) }}" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
               required>
    </div>
    
    <!-- Fields lainnya -->
</div>
```

### 2. Routes

Di file `routes/web.php`, tambahkan route untuk CRUD produk:

```php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('dashboard/products', ProductController::class);
});
```

## Seeding Data

Untuk testing, kita buat seeder untuk kategori produk:

```php
class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics' => 'Electronic devices and accessories',
            'Fashion' => 'Clothing, shoes, and accessories',
            'Home & Living' => 'Furniture and home decor',
            'Books' => 'Books and digital content',
            'Sports' => 'Sports equipment and accessories'
        ];

        foreach ($categories as $name => $description) {
            ProductCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $description,
                'is_active' => true
            ]);
        }
    }
}
```

## Fitur-fitur yang Diimplementasikan

1. **Manajemen Produk**
   - Create: Membuat produk baru dengan validasi
   - Read: Menampilkan daftar produk dengan pagination
   - Update: Mengubah data produk yang ada
   - Delete: Menghapus produk

2. **Kategori Produk**
   - Pengelompokan produk berdasarkan kategori
   - Status aktif/nonaktif untuk kategori

3. **UI/UX**
   - Form validation dengan pesan error
   - Flash messages untuk feedback
   - Responsive design dengan Tailwind CSS
   - Reusable components

4. **Keamanan**
   - CSRF protection
   - Validasi input
   - Authentication middleware

## Kesimpulan

Dengan implementasi ini, kita telah berhasil membuat sistem manajemen produk yang lengkap dengan Laravel. Sistem ini mencakup:

- Struktur database yang solid dengan relasi antar tabel
- CRUD functionality yang lengkap
- UI yang modern dan responsif menggunakan Tailwind CSS
- Validasi dan keamanan yang baik
- Reusable components untuk maintainability yang lebih baik

Pada artikel selanjutnya, kita akan membahas tentang implementasi fitur order dan integrasi dengan sistem pembayaran. Stay tuned!
