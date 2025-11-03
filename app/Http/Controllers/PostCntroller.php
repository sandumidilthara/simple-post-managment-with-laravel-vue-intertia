<?php
namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostCntroller extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->get();
        
        return Inertia::render('Frontend/Posts', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        $categories = Category::all(); // සියලුම categories load කරන්න
        
        return Inertia::render('Frontend/CreatePost', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id', // Category validate කරන්න
        ]);

        Post::create($validated);

        return redirect()->route('posts.index')->with('success', '✅ Post created successfully!');
    }

    public function edit(Post $post)
    {
        $categories = Category::all(); // Categories load කරන්න
        
        return Inertia::render('Frontend/EditPost', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post->update($validated);

        return redirect()->route('posts.index')->with('success', '✅ Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', '🗑️ Post deleted successfully!');
    }
}