<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Category::query()->withCount('services');

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where('name', 'LIKE', $searchTerm)
                  ->orWhere('slug', 'LIKE', $searchTerm);
        }

        $categories = $query->orderBy('name')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            // Add validation for parent_id if implementing hierarchical categories
            // 'parent_id' => 'nullable|exists:categories,id',
            // Add validation for image if categories can have images
            // 'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $category = new Category();
        $category->name = $validatedData['name'];
        $category->slug = $validatedData['slug'] ?? Str::slug($validatedData['name']);
        $category->description = $validatedData['description'];
        // $category->parent_id = $validatedData['parent_id'] ?? null;

        // if ($request->hasFile('image')) {
        //     $category->image_path = $request->file('image')->store('categories', 'public');
        // }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', __('Category created successfully.'));
    }

    /**
     * Display the specified category. (Optional for admin, index might be enough)
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function show(Category $category)
    {
        $category->loadCount('services');
        // Potentially load services in this category for quick view
        // $services = $category->services()->orderBy('created_at', 'desc')->take(10)->get();
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        // $parentCategories = Category::where('id', '!=', $category->id)->orderBy('name')->get(); // For parent_id dropdown
        return view('admin.categories.edit', compact('category')); //, 'parentCategories'
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            // 'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id, // Prevent self-parenting
            // 'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $category->name = $validatedData['name'];
        $category->slug = $validatedData['slug'] ?? Str::slug($validatedData['name']);
        $category->description = $validatedData['description'];
        // $category->parent_id = $validatedData['parent_id'] ?? null;

        // if ($request->hasFile('image')) {
        //     // Consider deleting old image
        //     // if ($category->image_path) Storage::disk('public')->delete($category->image_path);
        //     $category->image_path = $request->file('image')->store('categories', 'public');
        // } elseif ($request->boolean('remove_image')) {
        //     // if ($category->image_path) Storage::disk('public')->delete($category->image_path);
        //     // $category->image_path = null;
        // }


        $category->save();

        return redirect()->route('admin.categories.index')->with('success', __('Category updated successfully.'));
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        // Check if category has services associated with it
        if ($category->services()->count() > 0) {
            return redirect()->route('admin.categories.index')
                             ->with('error', __('Cannot delete category: It has services associated with it. Please reassign services first.'));
        }

        // Consider deleting image if it exists
        // if ($category->image_path) Storage::disk('public')->delete($category->image_path);

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', __('Category deleted successfully.'));
    }
}
