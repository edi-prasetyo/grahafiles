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
        $posts = Post::where('user_id', $user_id)
            ->with('counters')
            ->orderBy('id', 'desc')
            ->paginate(20);
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
        $post->meta_description = $request['meta_description'];
        $post->meta_title = $request['short_title'];
        $post->short_description = $request['short_description'];
        $post->keywords = $request['keywords'];

        $post->user_id = $user_id;
        $post->status = 1;
        $post->views = 0;

        if ($request->hasFile('image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));

            // $img = $img->scale(500);
            $img = $img->cover(500, 300);
            $img->toJpeg()->save('uploads/images/' . $name_gen);
            $save_url = $name_gen;

            $post->image = $save_url;
            $post->image_url = URL::to('/uploads/images/' . $name_gen);
        }

        $post->save();
        $post->tag()->sync((array)$request->input('tag'));

        // Upoload File
        if ($request->hasFile('file')) {
            $i = 1;
            foreach ($request->file('file') as $uploadfile) {

                $uuid_file =  $uuid = Str::uuid()->toString();

                $size = $uploadfile->getSize();
                $ext = $uploadfile->getClientOriginalExtension();
                $original_name = $uploadfile->getClientOriginalName();
                $filename = 'edikomputer.com-' . $post->slug .  $i++ . '-' . time() . '-' . $uuid . '.' . $ext;
                $uploadfile->move('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9/', $filename);

                $uploadfilePost = new ModelsFile();
                $uploadfilePost->post_id = $post->id;
                $uploadfilePost->name = $original_name;
                $uploadfilePost->size = $size;
                $uploadfilePost->ext = $ext;
                $uploadfilePost->uuid = $uuid_file;

                $uploadfilePost->file = $filename;
                // $uploadfile->file_url = URL::to('/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9/' . $filename);

                $uploadfilePost->save();
            }
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
        $post = Post::where('id', $post_id)->first();
        $tags = Tag::all();
        // $tags = Tag::get()->pluck('name', 'id');
        $categories = Category::all();
        $files = ModelsFile::where('post_id', $post_id)->get();
        // return $post;
        if (Auth::user()->id == $post->user_id) {
            return view('admin.posts.edit', compact('post', 'categories', 'tags', 'files'));
        } else {
            // redirect user to home page 
            return redirect('/posts')->with('success', 'You Canot Edit This Post');
        }
    }
    public function update(Request $request, int $post_id)
    {

        $uuid =  $uuid = Str::uuid()->toString();

        $user_id = Auth::user()->id;
        $validated = $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'tag.*' => 'exists:tags,id',
            'file' => 'nullable'
        ]);

        $post = Post::where('id', $post_id)->first();
        $post->category_id = $validated['category_id'];
        $post->title = $validated['title'];
        $post->content = $validated['content'];

        $post->meta_description = $request['meta_description'];
        $post->meta_title = $request['short_title'];
        $post->short_description = $request['meta_description'];
        $post->keywords = $request['keywords'];


        $post->user_id = $user_id;
        $post->status = 1;

        if ($request->hasFile('image')) {

            $path = 'uploads/images/' . $post->image;
            if (File::exists($path)) {
                File::delete($path);
            }

            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));

            $img = $img->scale(500);
            $img->toJpeg()->save('uploads/images/' . $name_gen);
            $save_url = $name_gen;

            $post->image = $save_url;
            $post->image_url = URL::to('/uploads/images/' . $name_gen);
        }

        $file = ModelsFile::where('post_id', $post_id)->first();
        // Upoload File
        if ($request->hasFile('file')) {

            $i = 1;
            foreach ($request->file('file') as $uploadfile) {

                $uuid_file =  $uuid = Str::uuid()->toString();
                // $file = $request->file('file');
                $size = $uploadfile->getSize();
                $ext = $uploadfile->getClientOriginalExtension();
                $original_name = $uploadfile->getClientOriginalName();
                $filename = 'edikomputer.com-' . $post->slug . $i++ . '-' . time() . '-' . $uuid . '.' . $ext;
                $uploadfile->move('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9/', $filename);

                $uploadUpdate = new ModelsFile();
                $uploadUpdate->post_id = $post->id;
                $uploadUpdate->name = $original_name;
                $uploadUpdate->size = $size;
                $uploadUpdate->ext = $ext;
                $uploadUpdate->uuid = $uuid_file;

                $uploadUpdate->file = $filename;
                // $uploadfile->file_url = URL::to('/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9/' . $filename);

                $uploadUpdate->save();
            }
        }

        $post->update();
        $post->tag()->sync((array)$request->input('tag'));

        Alert::success('Post', 'Post Berhasi di Update');
        return redirect()->back();
    }

    public function destroy_file($file_id)
    {
        $file = ModelsFile::where('id', $file_id)->first();
        $file_path = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9/' . $file->file;
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
        $file->delete();
        Alert::success('Post', 'Post Berhasil di Hapus');
        return redirect()->back();
    }

    public function destroy(int $post_id)
    {
        $post = Post::where('id', $post_id)->first();
        $file = ModelsFile::where('post_id', $post_id)->first();

        $image_path = 'uploads/images/' . $post->image;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        $file_path = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9/' . $file->file;
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
        $post->delete();
        Alert::success('Post', 'Post Berhasil di Hapus');
        return redirect('posts');
    }

    public function user_posts()
    {
        $user_posts = Post::orderBy('id', 'asc')->paginate(10);
        return view('admin.posts.user_post', compact('user_posts'));
    }
}
