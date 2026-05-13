<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy(Category $category)
    {
        // Prevent deleting category if it has commodities (optional but good practice)
        if ($category->commodities()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori ini tidak dapat dihapus karena masih memiliki barang terkait.');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
