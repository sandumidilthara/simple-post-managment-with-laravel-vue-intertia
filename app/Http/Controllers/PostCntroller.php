<?php
namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\StorePostRequest;

class PostCntroller extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'tags'])->latest()->get();

        return Inertia::render('Frontend/Posts', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        $categories = Category::all();

        return Inertia::render('Frontend/CreatePost', [
            'categories' => $categories
        ]);
    }

    public function store(StorePostRequest $request)
    {
        // Validation already handled by StorePostRequest
        $validated = $request->validated();

        $post = Post::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'category_id' => $request->category_id,
        ]);

        if (!empty($request->tags)) {
            $tagIds = [];
            foreach ($request->tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $tagIds[] = $tag->id;
            }
            $post->tags()->attach($tagIds);
        }

        return redirect()->route('posts.index')->with('success', '✅ Post created successfully with tags!');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $post->load('tags', 'category');

        return Inertia::render('Frontend/EditPost', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    public function update(StorePostRequest $request, Post $post)
    {
        $validated = $request->validated();

        $post->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'category_id' => $request->category_id,
        ]);

        if (isset($request->tags)) {
            $tagIds = [];
            foreach ($request->tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $tagIds[] = $tag->id;
            }
            $post->tags()->sync($tagIds);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('posts.index')->with('success', '✅ Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', '🗑️ Post deleted successfully!');
    }
}
