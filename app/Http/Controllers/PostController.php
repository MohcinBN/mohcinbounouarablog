<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Services\ImageUpload;

class PostController extends Controller
{
    public function index()
    {
        return Inertia::render('Posts/Index', [
            'posts' => Post::with('user')
                ->latest()
                ->paginate(10)
                ->through(fn ($post) => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'excerpt' => $post->excerpt,
                    'featured_image' => $post->featured_image,
                    'status' => $post->status,
                    'created_at' => $post->created_at->format('M d, Y'),
                    'author' => $post->user->name
                ])
        ]);
    }

    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = ImageUpload::upload($request->file('featured_image'));
        }

        Post::create($validated);
        return redirect()->route('posts.index')->with('message', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return Inertia::render('Posts/Show', [
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'excerpt' => $post->excerpt,
                'status' => $post->status,
                'featured_image' => $post->featured_image,
                'author' => $post->user->name,
                'created_at' => $post->created_at->format('M d, Y'),
            ],
        ]);
    }

    public function edit(Post $post)
    {
        return Inertia::render('Posts/Edit', [
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'excerpt' => $post->excerpt,
                'featured_image' => $post->featured_image,
                'status' => $post->status,
            ],
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();

        if ($validated['title'] !== $post->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = ImageUpload::upload($request->file('featured_image'));
        } else {
            $validated['featured_image'] = $post->featured_image;
        }

        $post->update($validated);
        return redirect()->route('posts.index')->with('message', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('message', 'Post deleted successfully.');
    }

    public function viewPost(Post $post)
    {
        $props = [
            'singlePost' => $post->only(
                'id',
                'title',
                'content',
                'excerpt',
                'featured_image',
                'created_at'
            ),
        ];
        return Inertia::render('singlePost', $props);
    }

    public function publicPostsList() {
        return Inertia::render('publicPostsList', [
            'publicPosts' => Post::with('user')
                ->latest()
                ->paginate(10)
                ->through(fn ($post) => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'excerpt' => $post->excerpt,
                    'featured_image' => $post->featured_image,
                    'status' => $post->status,
                    'created_at' => $post->created_at,
                    'author' => $post->user->name
                ])
        ]);
    }
}
