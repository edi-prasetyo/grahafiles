@extends('layouts.app')


@section('content')

    <div class="container">

        <div class="col-md-9 mx-auto">
            <h2 class="my-5">Add New Post</h2>

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


            <form action="{{ url('posts/update/' . $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="form-group mb-3">

                                <select class="form-select single-select-field @error('category_id') is-invalid @enderror"
                                    id="category-dropdown" name="category_id">
                                    <option value="">--Pilih Kategori--</option>
                                    @foreach ($categories as $key => $category)
                                        <option value="{{ $category->id }}"
                                            {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">

                                <input type="text" name="title" class="form-control" value="{{ $post->title }}">
                            </div>

                        </div>



                        <div class="col-md-6">
                            <div class="row">
                                {{-- <input type="file" name="image" class="img"> --}}

                                <div class="col-6 mx-auto">
                                    <div id="imagePreview"
                                        class="d-flex flex-column justify-content-center align-items-center py-5 my-auto">
                                        <p class="text-muted">GANTI PHOTO</p>
                                        <i class="ti ti-photo-plus fs-1 mx-auto"></i>
                                    </div>
                                    <input id="uploadFile" type="file" name="image" class="img">
                                </div>
                                <div class="col-6">
                                    <img src="{{ $post->image_url }}" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group my-3">
                        <textarea class="form-control summernote" name="content" placeholder="Content">{{ $post->content }}</textarea>
                        <div class="col-xs-12">
                            Minimal teks : <span id="maxContentPost"></span>
                        </div>
                    </div>

                    <select name="tag[]" multiple="multiple" id="multiple-select-clear-field"
                        class="form-control select_multiple" multiple>
                        @foreach ($tags as $skey => $tag)
                            <option value="{{ $tag->id }}"
                                @if ($post->tag->containsStrict('id', $tag->id)) selected="selected" @endif>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-group my-5">
                        <label>File</label>
                        <input type="file" name="file[]" class="form-control" multiple>
                        <div class="row mt-5">
                            @foreach ($files as $file)
                                <div class="col-md-3">
                                    <div class="card position-relative mb-3">
                                        <div class="card-body">
                                            <a href="{{ url('posts/delete/file/' . $file->id) }}"
                                                class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger p-2"><span
                                                    class=""><i class="bi bi-trash3-fill"></i></span></a>
                                            {{ $file->name }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary my-3">Save</button>
                    </div>
                </div>


            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Select 2 Bootstrap 5
        $('.single-select-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });

        $('#multiple-select-clear-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
            allowClear: true,
        });

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


        // Summernote

        function registerSummernote(element, placeholder) {
            $(element).summernote({
                height: 300,
                tooltip: false,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ol', 'ul', 'paragraph']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                placeholder,

            });
        }


        $(function() {
            registerSummernote('.summernote', 'Konten', 900, function(max) {
                $('#maxContentPost').text(max)
            });
        });
    </script>
@endsection
