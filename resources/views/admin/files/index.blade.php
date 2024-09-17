@extends('layouts.app')


@section('content')
    <div class="container">



        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-start">

                <h4> File Manager</h4>

            </div>
            <table class="table table-striped">
                <tr>

                    <th>Name</th>
                    <th>Format</th>
                    <th>Size</th>
                    <th>Download</th>

                </tr>
                @foreach ($files as $file)
                    <tr>
                        <td>{{ $file->post_title }}</td>
                        <td>{{ $file->ext }}</td>
                        <td>
                            @php
                                $bytes = $file->size;
                                if ($bytes >= 1073741824) {
                                    $bytes = number_format($bytes / 1073741824, 2) . ' GB';
                                } elseif ($bytes >= 1048576) {
                                    $bytes = number_format($bytes / 1048576, 2) . ' MB';
                                } elseif ($bytes >= 1024) {
                                    $bytes = number_format($bytes / 1024, 2) . ' KB';
                                } elseif ($bytes > 1) {
                                    $bytes = $bytes . ' bytes';
                                } elseif ($bytes == 1) {
                                    $bytes = $bytes . ' byte';
                                } else {
                                    $bytes = '0 bytes';
                                }
                            @endphp
                            {{ $bytes }}
                        </td>
                        <td>{{ $file->download_count }}</td>

                    </tr>
                @endforeach
            </table>
            <div class="card-footer">
                {{ $files->links() }}
            </div>
        </div>
    </div>
@endsection
