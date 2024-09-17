<?php

namespace App\Http\Controllers;

use App\Models\File as ModelsFile;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        $files = ModelsFile::orderBy('id', 'asc')
            ->join('posts', 'posts.id', '=', 'files.post_id')
            ->select('files.*', 'posts.title as post_title')
            ->paginate(10);
        return view('admin.files.index', compact('files'));
    }
}
