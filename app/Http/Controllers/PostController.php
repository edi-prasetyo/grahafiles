<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File as ModelsFile;
// use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use RealRashid\SweetAlert\Facades\Alert;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:post-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);

        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        $posts = Post::where('user_id', $user_id)->paginate(8);
        return view('admin.posts.index', compact('posts'));
    }



    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $uuid =  $uuid = Str::uuid()->toString();

        $validated = $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            // 'url' => 'required',
            'image' => 'required',
            'tag.*' => 'exists:tags,id',
        ]);

        $slugRequest = Str::slug($validated['title']);
        $code = random_int(00, 99);
        $slug = $slugRequest . '-' . $code;

        $post = new Post();
        if (Post::where('slug', $slugRequest)->exists()) {
            $post->slug = $slug;
        } else {
            $post->slug = $slugRequest;
        }
        $post->category_id = $validated['category_id'];
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->url = $request['url'];
        $post->user_id = $user_id;
        $post->status = 1;
        $post->views = 0;

        if ($request->hasFile('image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));

            // $img = $img->scale(500);
            $img = $img->cover(300, 180);
            $img->toJpeg()->save(base_path('public/uploads/images/' . $name_gen));
            $save_url = $name_gen;

            $post->image = $save_url;
            $post->image_url = URL::to('/uploads/images/' . $name_gen);
        }

        $post->save();
        $post->tag()->sync((array)$request->input('tag'));

        // Upoload File
        if ($request->hasFile('file')) {

            $file = $request->file('file');
            $size = $file->getSize();
            $ext = $file->getClientOriginalExtension();
            $original_name = $file->getClientOriginalName();
            $filename = $post->slug . '-' . time() . '-' . $uuid . '.' . $ext;
            $file->move('uploads/files/', $filename);

            $uploadfile = new ModelsFile();
            $uploadfile->post_id = $post->id;
            $uploadfile->name = $original_name;
            $uploadfile->size = $size;
            $uploadfile->ext = $ext;
            $uploadfile->uuid = $uuid;

            $uploadfile->file = $filename;
            $uploadfile->file_url = URL::to('/uploads/files/' . $filename);

            $uploadfile->save();
        }

        Alert::success('Post', 'Artikel Berhasil di Posting');
        return redirect('posts');
    }
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }
    public function edit(int $post_id)
    {

        $post = Post::where('id', $post_id)->with('previewImage')->first();
        $tags = Tag::all();
        // $tags = Tag::get()->pluck('name', 'id');
        $categories = Category::all();
        // return $post;
        if (Auth::user()->id == $post->user_id) {
            return view('admin.posts.edit', compact('post', 'categories', 'tags'));
        } else {
            // redirect user to home page 
            return redirect('/posts')->with('success', 'You Canot Edit This Post');
        }
    }
    public function update(Request $request, int $post_id)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'url' => 'required',
            'tag.*' => 'exists:tags,id',
        ]);

        $post = Post::where('id', $post_id)->with('previewImage')->first();
        $post->category_id = $validated['category_id'];
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->url = $validated['url'];
        $post->update();

        $post->tag()->sync((array)$request->input('tag'));


        Alert::success('Success Title', 'Success Message');
        return redirect('posts');
    }

    public function destroy(int $post_id)
    {
        $post = Post::where('id', $post_id)->with('previewImage')->first();

        $path = 'uploads/images/' . $post->previewImage->image;
        if (File::exists($path)) {
            File::delete($path);
        }
        $post->delete();
        return redirect('posts')->with('success', 'Post deleted successfully');
    }

    public function user_posts()
    {
        $user_posts = Post::orderBy('id', 'asc')->paginate(10);
        return view('admin.posts.user_post', compact('user_posts'));
    }
}
