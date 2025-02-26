<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {   
        $paginate = $request->paginate ?? 10;

        if($request->has('search')) {
            $blogs = Blog::with('author')->where('title', 'like', '%'.$request->search.'%')->paginate($paginate);
            return response()->json($blogs);
        } else {
            $blogs = Blog::with('author')->paginate($paginate);
        }
 
        return view('admin.blog.index')->with([
            'title' => 'Blogs',
            'blogs' => $blogs
        ]);
    }

    public function create()
    {
        return view('admin.blog.form')->with([
            'title' => 'Create Blog'
        ]);
    }

    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'body' => 'required',
        ]);
    
        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            // Buat nama file unik
            $filename = time() . '.' . $image->getClientOriginalExtension();
    
            // Simpan file dengan nama khusus
            $path = $image->storePubliclyAs('blogs/images', $filename, 'public');
    
            // Simpan path di variabel
            $imagePath = 'storage/' . $path; // Simpan dengan jalur storage
    
            // Simpan path di data validasi
            $validatedData['image'] = $imagePath;
        }
    
        // Create unique slug
        $validatedData['slug'] = $this->generateUniqueSlug($request->title);
    
        // Get user id
        $validatedData['author_id'] = auth()->user()->id;
    
        // Store data
        Blog::create($validatedData);
    
        return redirect('admin/blog')->with('success', 'Blog created successfully');
    }

    public function show($id)
    {
        $blog = Blog::find($id);
        return view('admin.blog.show')->with([
            'title' => 'Blog Detail',
            'blog' => $blog
        ]);
    }

    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('admin.blog.form')->with([
            'title' => 'Edit Blog',
            'blog' => $blog
        ]);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        // Validation
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'body' => 'required',
        ]);

        // Upload image
        if($request->hasFile('image')) {
            // Hapus file lama
            $oldImage = Blog::find($id)->image;
            Storage::disk('public')->delete(str_replace('storage/', '', $oldImage));

            // Upload file baru
            $image = $request->file('image');

            // Buat nama file unik
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            // Simpan file dengan nama khusus
            $path = $image->storePubliclyAs('Blogs/images', $filename, 'public');
            
            // Simpan path di variabel
            $imagePath = 'storage/' . $path; // Simpan dengan jalur storage
        
            // Simpan ke model atau database (opsional)
            // Blog::create(['image_path' => $imagePath]);
            $validatedData['image'] = $imagePath;
        }

        // Perbarui slug hanya jika judul berubah
        if ($request->title !== $blog->title) {
            $validatedData['slug'] = $this->generateUniqueSlug($request->title);
        }

        // Get user id
        $validatedData['author_id'] = auth()->user()->id;
        
        // Store data
        Blog::find($id)->update($validatedData);

        return redirect('admin/blog')->with('success', 'Blog updated successfully');
    }

    public function destroy($id)
    {
        // Hapus file
        $oldImage = Blog::find($id)->image;
        Storage::delete(str_replace('storage/', '', $oldImage));

        // Hapus data
        Blog::destroy($id);

        return redirect('admin/blog')->with('success', 'Blog deleted successfully');
    }

        /**
     * Generate a unique slug for a given title.
     *
     * @param string $title
     * @return string
     */
    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;
    
        // Check if slug already exists
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    
        return $slug;
    }
}
