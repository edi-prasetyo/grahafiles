<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate('10');
        $title = 'Delete Customer!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin.categories.index', compact('categories'));
    }
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $validated = $request->validate([
            'name' => 'required',
        ]);

        $slugRequest = Str::slug($validated['name']);
        $code = random_int(00, 99);
        $slug = $slugRequest . '-' . $code;

        $category = new Category();

        $category->name = $validated['name'];
        if (Category::where('slug', $slugRequest)->exists()) {
            $category->slug = $slug;
        } else {
            $category->slug = $slugRequest;
        }
        $category->user_id = $user_id;
        $category->save();

        Alert::success('Category', 'Category Berhasil Dibuat');
        return redirect('categories');
    }
    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        return view('admin.categories.edit', compact('category'));
    }
    public function update(Request $request, $category)
    {
        $category = Category::findOrFail($category);
        $category->name = $request['name'];
        $category->update();
        Alert::success('Category', 'Category Berhasil Dibuat');
        return redirect('categories');
    }
    public function destroy($id)
    {
        Category::where('id', $id)->delete();
        Alert::success('Customer', 'Berhasil di Hapus');
        return back();
    }
}
