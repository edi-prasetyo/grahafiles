<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class OptionController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:option-list|option-edit'], ['only' => ['index', 'update']]);
        $this->middleware(['permission:user-edit'], ['only' => ['edit', 'update']]);

        $this->middleware(['auth', 'verified']);
    }
    public function index()
    {
        $option = Option::first();
        return view('admin.options.index', compact('option'));
    }
    public function update(Request $request)
    {
        $option = Option::first();

        $option->site_name = $request['site_name'];
        $option->site_tagline = $request['site_tagline'];
        $option->site_description = $request['site_description'];
        $option->site_email = $request['site_email'];
        $option->keywords = $request['keywords'];
        $option->site_url = $request['site_url'];
        $option->phone_number = $request['phone_number'];
        $option->whatsapp = $request['whatsapp'];
        $option->address = $request['address'];
        $option->facebook = $request['facebook'];
        $option->twitter = $request['twitter'];
        $option->instagram = $request['instagram'];
        $option->youtube = $request['youtube'];
        $option->google_webmaster = $request['google_webmaster'];
        $option->bing_webmaster = $request['bing_webmaster'];
        $option->maps = $request['maps'];
        $option->moderation = $request['moderation'];
        $option->google_ads = $request['google_ads'];
        $option->banner_ads = $request['banner_ads'];

        if ($request->hasFile('logo')) {

            $path = 'uploads/logo/' . $option->logo;
            if (File::exists($path)) {
                File::delete($path);
            }

            $file = $request->file('logo');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/logo/', $filename);

            $option->logo = $filename;
            $option->logo_url = URL::to('/uploads/logo/' . $filename);
        }
        if ($request->hasFile('second_logo')) {

            $path = 'uploads/logo/' . $option->second_logo;
            if (File::exists($path)) {
                File::delete($path);
            }

            $file = $request->file('second_logo');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/logo/', $filename);

            $option->second_logo = $filename;
            $option->second_logo_url = URL::to('/uploads/logo/' . $filename);
        }
        if ($request->hasFile('favicon')) {

            $path = 'uploads/logo/' . $option->favicon;
            if (File::exists($path)) {
                File::delete($path);
            }

            $file = $request->file('favicon');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/logo/', $filename);

            $option->favicon = $filename;
            $option->favicon_url = URL::to('/uploads/logo/' . $filename);
        }
        $option->update();
        Alert::success('Pengaturan Web', 'Pengaturan Web Berhasil diupdate');
        return redirect()->back();
    }
}
