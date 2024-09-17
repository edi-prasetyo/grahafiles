@extends('layouts.app')


@section('content')

    <div class="container">

        <div class="col-md-9 mx-auto">
            <h2 class="my-5">Edit Post</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ url('banners/update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="row">
                        <div class="col-md-6 ">


                            <div class="form-group mb-3">

                                <input type="text" name="name" class="form-control" value="{{ $banner->name }}">
                            </div>
                            <div class="form-group mb-3">

                                <input type="text" name="url" class="form-control" value="{{ $banner->url }}">
                            </div>

                            <div class="form-group mb-3">

                                <select class="form-select single-select-field @error('position') is-invalid @enderror"
                                    id="category-dropdown" name="position">
                                    <option value="">--Pilih Posisi--</option>
                                    <option value="top" @if ($banner->position == 'top') selected @endif>Top</option>
                                    <option value="list" @if ($banner->position == 'list') selected @endif>List Post
                                    </option>
                                    <option value="detail" @if ($banner->position == 'detail') selected @endif>Detail Post
                                    </option>
                                    <option value="sidebar" @if ($banner->position == 'sidebar') selected @endif>Sidebar
                                    </option>
                                    <option value="download" @if ($banner->position == 'download') selected @endif>Download
                                    </option>

                                </select>
                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-check form-switch">
                                <label class="form-check-label">Status</label>
                                <input class="form-check-input" type="checkbox" name="status"
                                    {{ $banner->status == '1' ? 'checked' : '' }}>
                            </div>


                        </div>




                        <div class="col-md-6">

                            <input type="file" name="image" class="img">

                            {{-- <div class="col-12 mx-auto">
                                <div id="imagePreview"
                                    class="d-flex flex-column justify-content-center align-items-center py-5 my-auto">
                                    <p class="text-muted">PHOTO</p>
                                    <i class="ti ti-photo-plus fs-1 mx-auto"></i>
                                </div>
                                <input id="uploadFile" type="file" name="image" class="img">
                            </div> --}}
                        </div>

                    </div>

                    <div class="form-group my-3">
                        <textarea class="form-control" name="script">{{ $banner->script }}</textarea>

                    </div>


                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary my-3">Publish Banner</button>
                    </div>
                </div>


            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Image Preview

        $(function() {
            $("#uploadFile").on("change", function() {
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader)
                    return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                        $("#imagePreview").css("background-image", "url(" + this.result + ")");
                    }
                }
            });
        });
        $('#imagePreview').click(function() {
            $('#uploadFile').click();
        });
    </script>
@endsection
