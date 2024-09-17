<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TagController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:tag-list|tag-create|tag-edit|tag-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:tag-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tag-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tag-delete', ['only' => ['destroy']]);

        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $tags = Tag::orderBy('id', 'desc')->paginate('10');
        $title = 'Delete Tag!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin.tags.index', compact('tags'));
    }
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $validated = $request->validate([
            'name' => 'required',
        ]);

        $slugRequest = Str::slug($validated['name']);
        $code = random_int(00, 99);
        $slug = $slugRequest . '-' . $code;

        $tag = new Tag();

        $tag->name = $validated['name'];
        if (Tag::where('slug', $slugRequest)->exists()) {
            $tag->slug = $slug;
        } else {
            $tag->slug = $slugRequest;
        }
        $tag->user_id = $user_id;
        $tag->save();

        Alert::success('Tag', 'Tag Berhasil Dibuat');
        return redirect('tags');
    }
    public function edit($id)
    {
        $tag = Tag::where('id', $id)->first();
        return view('admin.tags.edit', compact('tag'));
    }
    public function update(Request $request, $tag)
    {
        $tag = Tag::findOrFail($tag);
        $tag->name = $request['name'];
        $tag->update();
        Alert::success('Category', 'Tag Berhasil Dibuat');
        return redirect('tags');
    }
    public function destroy($id)
    {
        Tag::where('id', $id)->delete();
        Alert::success('Tag', 'Berhasil di Hapus');
        return back();
    }
}
