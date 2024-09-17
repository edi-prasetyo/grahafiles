<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:page-list|page-create|page-edit|page-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:page-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:page-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:page-delete', ['only' => ['destroy']]);

        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        $pages = Page::orderBy('id', 'asc')->get();
        // $title = 'Delete Page!';
        // $text = "Are you sure you want to delete?";
        // confirmDelete($title, $text);
        // return $pages;
        return view('admin.pages.index', compact('pages'));
    }
    public function create()
    {
        return view('admin.pages.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $slugRequest = Str::slug($validated['title']);
        $code = random_int(00, 99);
        $slug = $slugRequest . '-' . $code;

        $page = new Page();
        if (Page::where('slug', $slugRequest)->exists()) {
            $page->slug = $slug;
        } else {
            $page->slug = $slugRequest;
        }
        $page->title = $validated['title'];
        $page->content = $validated['content'];

        if ($request->hasFile('image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));

            $img = $img->scale(500);
            $img->toJpeg()->save(base_path('public/uploads/images/' . $name_gen));
            $save_url = $name_gen;

            $page->image = $save_url;
            $page->image_url = URL::to('/uploads/images/' . $name_gen);
        }

        $page->save();
        Alert::success('Page', 'Halaman Berhasil di Posting');
        return redirect('pages');
    }
    public function edit($page_id)
    {
        $page = Page::where('id', $page_id)->first();
        return view('admin.pages.edit', compact('page'));
    }
    public function update(Request $request, int $page_id)
    {
        $page = Page::where('id', $page_id)->first();
        $page->title = $request['title'];
        $page->content = $request['content'];

        if ($request->hasFile('image')) {

            $path = 'uploads/images/' . $page->image;
            if (File::exists($path)) {
                File::delete($path);
            }

            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));

            $img = $img->scale(500);
            $img->toJpeg()->save(base_path('public/uploads/images/' . $name_gen));
            $save_url = $name_gen;

            $page->image = $save_url;
            $page->image_url = URL::to('/uploads/images/' . $name_gen);
        }

        $page->update();
        Alert::success('Page', 'Halaman Berhasil di Update');
        return redirect('pages');
    }
    public function destroy(int $page_id)
    {
        $page = Page::where('id', $page_id)->first();

        $path = 'uploads/images/' . $page->image;
        if (File::exists($path)) {
            File::delete($path);
        }
        $page->delete();
        Alert::success('Page', 'Halaman Berhasil di Hapus');
        return redirect()->back();
    }
}
