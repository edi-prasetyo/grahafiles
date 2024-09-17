<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:banner-list|banner-create|banner-edit|banner-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:banner-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:banner-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:banner-delete', ['only' => ['destroy']]);

        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        $banners = Banner::orderBy('id', 'asc')->get();
        return view('admin.banners.index', compact('banners'));
    }
    public function create()
    {
        return view('admin.banners.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'position' => 'required',

        ]);

        $banner = new Banner();

        $banner->name = $validated['name'];
        $banner->position = $validated['position'];
        $banner->url = $request['url'];
        $banner->script = $request['script'];
        $banner->status = $request->status == true ? '1' : '0';

        if ($request->hasFile('image')) {


            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/banners/', $filename);

            $banner->image = $filename;
            $banner->image_url = URL::to('/uploads/banners/' . $filename);
        }

        $banner->save();
        Alert::success('Banner', 'Banner Berhasil di Posting');
        return redirect('banners');
    }
    public function edit($banner_id)
    {
        $banner = Banner::where('id', $banner_id)->first();
        return view('admin.banners.edit', compact('banner'));
    }
    public function update(Request $request, int $banner_id)
    {
        $banner = Banner::where('id', $banner_id)->first();
        $banner->name = $request['name'];
        $banner->position = $request['position'];
        $banner->url = $request['url'];
        $banner->script = $request['script'];
        $banner->status = $request->status == true ? '1' : '0';


        if ($request->hasFile('image')) {

            $path = 'uploads/banners/' . $banner->icon;
            if (File::exists($path)) {
                File::delete($path);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/banners/', $filename);

            $banner->image = $filename;
            $banner->image_url = URL::to('/uploads/banners/' . $filename);
        }

        $banner->update();
        Alert::success('Banner', 'Halaman Berhasil di Update');
        return redirect('banners');
    }
    public function destroy(int $banner_id)
    {
        $banner = Banner::where('id', $banner_id)->first();

        $path = 'uploads/banners/' . $banner->image;
        if (File::exists($path)) {
            File::delete($path);
        }
        $banner->delete();
        Alert::success('Banner', 'Banner Berhasil di Hapus');
        return redirect()->back();
    }
}
