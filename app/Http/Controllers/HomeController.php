<?php

namespace App\Http\Controllers;

use App\Models\CounterDownload;
use App\Models\CounterPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = CounterPost::selectRaw("date_format(created_at, '%Y-%m-%d') as date, count(*) as aggregate")
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->get();
        $downloaded = CounterDownload::selectRaw("date_format(created_at, '%Y-%m-%d') as date, count(*) as aggregate")
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->get();
        // return $data;
        return view('home', compact('data', 'downloaded'));
    }
    public function profile()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        return view('profile', compact('user'));
    }

    public function update_profile(Request $request)
    {
        $user_id = Auth::user()->id;

        $user = User::where('id', $user_id)->first();

        $user->id = $user_id;
        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->facebook = $request->facebook;
        $user->twitter = $request->twitter;
        $user->youtube = $request->youtube;
        $user->instagram = $request->instagram;

        if ($request->hasFile('avatar')) {

            $path = 'uploads/avatar/' . $user->avatar;
            if (File::exists($path)) {
                File::delete($path);
            }

            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $request->file('avatar')->getClientOriginalExtension();
            $img = $manager->read($request->file('avatar'));

            $img = $img->cover(90, 90);
            $img->toJpeg()->save(base_path('public/uploads/avatar/' . $name_gen));
            $save_url = $name_gen;

            $user->avatar = $save_url;
            $user->avatar_url = URL::to('/uploads/avatar/' . $name_gen);
        }

        $user->update();
        Alert::success('Profile', 'Profile telah diperbahrui');
        return redirect()->back();
    }

    public function delete_profile()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        Auth::logout();
        if ($user->delete()) {
            return redirect('login')->with('delete-profile', 'Akun anda sudah di hapus!');
        }
    }
}
