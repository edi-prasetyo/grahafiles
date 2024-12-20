@extends('layouts.app')


@section('content')

    <div class="container">

        <div class="col-md-10 mx-auto">
            <h2 class="my-5">Add New Post </h2>

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


            <form action="{{ url('posts/store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">

                        <div class="form-group mb-3">
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                placeholder="Title">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group my-3">
                            <textarea class="form-control summernote @error('content') is-invalid @enderror" name="content" placeholder="Content"></textarea>
                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <h3 class="my-2">Seo Meta</h3>
                        <div class="form-group mb-3">
                            <label class="form-label">Keywords</label>
                            <input type="text" name="keywords" class="form-control" placeholder="Keywords">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="short_title" class="form-control" placeholder="Short Title"
                                maxlength="35">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Short Desc</label>
                            <input type="text" name="short_description" class="form-control"
                                placeholder="Short Description" maxlength="65">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Meta Desc</label>
                            <textarea name="meta_description" class="form-control" placeholder="Meta Description" maxlength="155"></textarea>
                        </div>

                    </div>



                    <div class="col-md-4">



                        <div class="col-12 mx-auto">
                            <div id="imagePreview"
                                class="d-flex flex-column justify-content-center align-items-center py-5 my-auto">
                                <p class="text-muted">PHOTO</p>
                                <i class="ti ti-photo-plus fs-1 mx-auto"></i>
                            </div>
                            <input id="uploadFile" type="file" name="image"
                                class="img @error('image') is-invalid @enderror">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group my-3">

                            <select class="form-select single-select-field @error('category_id') is-invalid @enderror"
                                id="category-dropdown" name="category_id">
                                <option value="">--Pilih Kategori--</option>
                                @foreach ($categories as $key => $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group my-3">
                            <select class="form-select" name="tag[]" id="multiple-select-clear-field"
                                data-placeholder="Choose anything" multiple>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group my-3">
                            <label>File</label>
                            <input class="form-control" type="file" id="upload_requiremnt_files" name="file[]" multiple>
                            <div id="upload_count"></div>
                            <div id="upload_prev"></div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary my-3">Save</button>
                        </div>

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

    <script>
        $(document).ready(function(readyEvent) {

            var filesToUpload = []; //store files
            var removeFile = []; //remove remove files
            var fileCounter = 0; //count files

            //upload file
            $('#upload_requiremnt_files').on('change', function() {

                $("#upload_prev").html('');

                fileCounter = this.files.length; //count files

                //Store all files to our main array
                var files = this.files;
                for (var i = 0; i < files.length; i++) {
                    filesToUpload.push(files[i]);
                }

                //Push file to remove file to that we can match to remove file
                for (var i = 0, f; f = files[i]; i++) {
                    removeFile.push('<div class="filenameupload" id="' + i + '"  fileName="' + f.name +
                        '" >' + f.name +
                        '<p class="close" ><i class="fa fa-window-close" aria-hidden="true"></i></p></div>'
                    );
                }

                //Append Remove file icon to each file
                if (removeFile.length) {
                    $("#upload_prev").html(removeFile.join(""));
                }

                //Show counter
                $('#upload_count').show().text('Total Files To Upload = ' + fileCounter)

            });

            //Remove files 
            $(document).on('click', '.close', function() {

                var i = $(this).parent().attr("id"); //get index
                var fileName = $(this).parent().attr("fileName"); //get fileName

                //Loop through all the file and remove Files
                for (i = 0; i < filesToUpload.length; ++i) {
                    if (filesToUpload[i].name == fileName) {
                        //Remove the one element at the index where we get a match
                        filesToUpload.splice(i, 1);
                        removeFile.splice(i, 1);
                    }
                }

                //Remove file from DOM
                $(this).parent().remove();

                //Decrease counter
                fileCounter--

                //Update counter
                if (fileCounter > 0) {
                    $('#upload_count').text('Total Files To Upload = ' + fileCounter)
                } else {
                    $('#upload_count').hide()
                }
            })

            //Demo Upload button
            $(document).on('click', '#upload_file', function() {
                if (filesToUpload.length) {
                    alert(filesToUpload.length + ' files will be sent to controller')
                } else {
                    alert('Nothing to upload')
                }
            })
        });
    </script>
@endsection
