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


            <form action="{{ url('pages/update', $page->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="row">
                        <div class="col-md-6 ">


                            <div class="form-group mb-3">

                                <input type="text" name="title" class="form-control" value="{{ $page->title }}">
                            </div>

                        </div>


                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <div id="imagePreview"
                                        class="d-flex flex-column justify-content-center align-items-center py-5 my-auto">
                                        <p class="text-muted">CHANGE PHOTO</p>
                                        <i class="ti ti-photo-plus fs-1 mx-auto"></i>

                                    </div>
                                    <input id="uploadFile" type="file" name="image" class="img">
                                </div>
                                <div class="col-md-6">
                                    <img src="{{ $page->image_url }}" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group my-3">
                        <textarea class="form-control summernote" name="content" placeholder="Content">{{ $page->content }}</textarea>

                    </div>





                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary my-3">Update Page</button>
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


        // Summernote

        $(".summernote").summernote({
            height: 300,
            tooltip: false,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ol', 'ul', 'paragraph']],
                ['table', ['table']],
            ]
        });
    </script>
@endsection
