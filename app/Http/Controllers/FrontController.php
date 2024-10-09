<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CounterDownload;
use App\Models\CounterPost;
use App\Models\File as ModelsFile;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request as FacadesRequest;

class FrontController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')
            ->with('count')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'users.name as user_name', 'categories.name as category_name')
            ->paginate(8);
        // return $posts;
        $popular = Post::orderBy('views', 'desc')->take(3)->get();
        $recent = Post::orderBy('id', 'desc')->take(3)->get();
        return view('frontends.index', compact('posts', 'popular', 'recent'));
    }
    public function post()
    {
        $posts = Post::orderBy('id', 'desc')->with('files')->paginate(8);
        $popular = Post::orderBy('views', 'desc')->take(3)->get();
        $recent = Post::orderBy('id', 'desc')->take(3)->get();
        // return $posts;
        return view('frontends.post', compact('posts', 'popular', 'recent'));
    }
    public function search(Request $request)
    {
        $keyword = $request['keyword'];

        $posts = Post::with('count')->orderBy('id', 'desc')->where('title', 'like', "%" . $keyword . "%")
            ->paginate(8);
        $posts->appends(array('keyword' => $keyword));

        $popular = Post::orderBy('views', 'desc')->take(3)->get();
        $recent = Post::orderBy('id', 'desc')->take(3)->get();

        return view('frontends.search', compact('posts', 'popular', 'recent', 'keyword'));
    }

    public function category($category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();

        $posts = Post::orderBy('id', 'desc')->where('category_id', $category->id)
            ->with('count')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'users.name as user_name')
            ->paginate(8);
        $popular = Post::orderBy('views', 'desc')->take(3)->get();
        $recent = Post::orderBy('id', 'desc')->take(3)->get();
        // return $posts;
        return view('frontends.category', compact('posts', 'popular', 'recent', 'category'));
    }
    public function tag($tag_slug)
    {

        $tag = Tag::where('slug', $tag_slug)->first();
        $post_tags = PostTag::where('tag_id', $tag->id)->get();
        $tagName = $tag->name;

        $posts = Post::with('count')->whereHas('tag', function ($query) use ($tagName) {
            $query->whereName($tagName);
        })->orderBy('id', 'desc')->paginate(8);

        $popular = Post::orderBy('views', 'desc')->take(3)->get();
        $recent = Post::orderBy('id', 'desc')->take(3)->get();
        // return $posts;
        return view('frontends.tag', compact('posts', 'popular', 'recent', 'tag'));
    }
    public function show(String $post_slug)
    {
        $post = Post::where('posts.slug', $post_slug)
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'categories.name as category_name', 'categories.slug as category_slug', 'users.name as user_name')
            ->first();
        $tags = PostTag::where('post_id', $post->id)
            ->join('tags', 'tags.id', '=', 'post_tags.tag_id')
            ->select('post_tags.*', 'tags.name as tag_name', 'tags.slug as tag_slug')
            ->get();
        // return $tags;
        $related = Post::where('category_id', $post->category_id)->with('downloadCount')->take(3)->get();
        $popular = Post::orderBy('views', 'desc')->take(3)->get();
        $recent = Post::orderBy('id', 'desc')->take(3)->get();

        $user = User::where('id', $post->user_id)->first();

        $files = ModelsFile::where('post_id', $post->id)
            ->with('downloadCount')
            ->get();

        // return $files;

        if (!Auth::check()) { //guest user identified by ip
            $cookie_name = (Str::replace('.', '', (request()->ip())) . '-' . $post->id);
        } else {
            $cookie_name = (Auth::user()->id . '-' . $post->id); //logged in user
        }
        if (Cookie::get($cookie_name) == '') { //check if cookie is set
            $cookie = cookie($cookie_name, '1', 60); //set the cookie
            $post->incrementReadCount(); //count the view

            $counter = new CounterPost();
            $counter->post_id = $post->id;
            $counter->ip_address = request()->ip();
            $counter->user_agent = request()->userAgent();
            $counter->save();

            return response()
                ->view('frontends.show', [
                    'post' => $post,
                    'related' => $related,
                    'popular' => $popular,
                    'recent' => $recent,
                    'user' => $user,
                    'tags' => $tags,
                    'files' => $files,

                ])
                ->withCookie($cookie); //store the cookie
        } else {
            return view('frontends.show', compact('post', 'related', 'popular', 'recent', 'user', 'tags', 'files'));
        }
    }



    public function download($uuid)
    {
        $files = ModelsFile::where('uuid', $uuid)->first();
        $post = Post::where('id', $files->post_id)->first();


        if (!Auth::check()) { //guest user identified by ip
            $cookie_name = (Str::replace('.', '', (request()->ip())) . '-' . $files->id);
        } else {
            $cookie_name = (Auth::user()->id . '-' . $files->id); //logged in user
        }
        if (Cookie::get($cookie_name) == '') { //check if cookie is set
            $cookie = cookie($cookie_name, '1', 60); //set the cookie

            return response()
                ->view('frontends.download', [
                    'post' => $post,
                    'files' => $files,

                ])
                ->withCookie($cookie); //store the cookie
        } else {
            return view('frontends.download', compact('files', 'post'));
        }
    }
    public function download_process($uuid)
    {

        $file = ModelsFile::where('uuid', $uuid)->first();

        $counter = new CounterDownload();
        $counter->file_id = $file->id;
        $counter->ip_address = request()->ip();
        $counter->user_agent = request()->userAgent();
        $counter->referer = request()->headers->get('referer');
        $counter->save();
        // $pathToFile = url('uploads/files/' . $file->file);

        $path = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9/' . $file->file;
        // $pathToFile = url($path . $file->file);

        if (!Auth::check()) { //guest user identified by ip
            $cookie_name = (Str::replace('.', '', (request()->ip())) . '-' . $file->id);
        } else {
            $cookie_name = (Auth::user()->id . '-' . $file->id); //logged in user
        }
        if (Cookie::get($cookie_name) == '') { //check if cookie is set
            $cookie = cookie($cookie_name, '1', 60); //set the cookie
            $file->incrementReadCount();



            return response()->download($path); //store the cookie
        } else {
            return response()->download($path);
        }
    }
    public function page($slug)
    {
        $page = Page::where('slug', $slug)->first();
        return view('frontends.page', compact('page'));
    }
}
