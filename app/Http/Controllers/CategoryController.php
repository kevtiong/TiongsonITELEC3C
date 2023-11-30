<?php

namespace App\Http\Controllers;

// Added
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    //
    public function index() {
        //$categories = Category::all();
        $categories = Category::latest()->paginate('5');
        $trashCat = Category::onlyTrashed()->latest()->paginate('5');
        return view('admin.category.category', compact('categories', 'trashCat'));
    }

    public function AddCategory(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:20',
            'category_icon' => 'required|mimes:jpeg,png,jpg'
            ]);

        $categoryIcon = null;

        // Handle file upload
        if ($request->hasFile('category_icon')) {
            $uploadedFile = $request->file('category_icon');
            $originalFileName = $uploadedFile->getClientOriginalName();

            // Generate a unique filename to avoid conflicts
            $filename = Str::uuid() . '_' . $originalFileName;

            // Store the file with the generated filename
            $imagePathLocal = $uploadedFile->storeAs('category_images', $originalFileName, 'public');
            $categoryIcon = $originalFileName;
        }

            Category::insert([
                'category_name' => $request->category_name,
                'category_icon' => $categoryIcon,
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now()
            ]);

        return Redirect()->back()->with('success','Add Category Successful');
    }

    public function EditCategory($id) {
        $categories = Category::find($id);
        return view('admin.category.edit', compact('categories'));
    }

    public function UpdateCategory(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'category_icon' => 'mimes:jpeg,png,jpg'
            ]);

        // Find the product to update
        $category = Category::find($id);

        // Update only when the file has been changed or added
        if ($request->hasFile('category_icon')) {
            $this->deleteAndUploadFile($request->file('category_icon'), $category->category_icon);
            $category->category_icon = $request->file('category_icon')->getClientOriginalName();
        }

        // Update only the changed fields
        $category->update([
            'category_name' => $request->category_name,
        ]);

        return Redirect()->route('AllCat')->with('success','Category Updated Successful');
    }

    private function deleteAndUploadFile($uploadedFile, $existingFilePath)
    {
        // Delete the existing file
        Storage::disk('public')->delete('category_images/' . $existingFilePath);

        // Upload the new file using a new filename
        $originalFileName = $uploadedFile->getClientOriginalName();
        $uploadedFile->storeAs('category_images', $originalFileName, 'public');
    }

    public function DeleteCategory(Request $request, $id)
    {
        $deleted = Category::destroy($id);
        return Redirect()->back()->with('success','Category Deleted Successful');
    }

    public function RestoreCategory(Request $request, $id)
    {
        $restore = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success','Category Restored Successful');
    }

    public function PermaDeleteCategory(Request $request, $id)
    {
        $restore = Category::withTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success','Category Deleted Permanently');
    }


}

/*
    public function AddCategory(Request $request): RedirectResponse
    {
        $category = new Category;

        $category->category_name = $request->input('inputCategory');

        if (Auth::check()) {
            // $userId contains the user_id of the currently authenticated user
            $userId = Auth::user()->id;
            $category->user_id = $userId;
        }

        else {
            // The user is not authenticated
        }

        $category->save();

        return redirect('/category');
    }
 */
