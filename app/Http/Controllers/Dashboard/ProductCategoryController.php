<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categories = ProductCategory::when($search, function($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
        })
        ->latest()
        ->paginate(10);
        
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:product_categories,slug',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $data = $request->all();
            
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('public/categories');
                $data['image'] = str_replace('public/', '', $imagePath);
            }

            ProductCategory::create($data);

            return redirect()
                ->route('categories.index')
                ->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error creating category: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ProductCategory $category)
    {
        if ($request->ajax()) {
            return response()->json([
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'image' => $category->image ? Storage::url($category->image) : null
            ]);
        }
        
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */ 
    public function update(Request $request, ProductCategory $category)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:product_categories,slug,' . $category->id,
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $data = $request->all();

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($category->image) {
                    Storage::delete('public/' . $category->image);
                }
                
                $imagePath = $request->file('image')->store('public/categories');
                $data['image'] = str_replace('public/', '', $imagePath);
            }

            $category->update($data);

            return redirect()
                ->route('categories.index')
                ->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error updating category: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $category)
    {
        try {
            if ($category->image) {
                Storage::delete('public/' . $category->image);
            }
            
            $category->delete();

            return redirect()
                ->route('categories.index')
                ->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }
}
