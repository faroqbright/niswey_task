@extends('layouts.master')

@section('content')
<div class="form-container">
    <div class="card" style="width: 100%; max-width: 500px;">
        <div class="card-header text-center">
            <h1 class="mb-0">Upload Form</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('form.submit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-1">
                    <label for="file" class="form-label">File Name</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Choose File</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <div class="table-container">
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>File Name</th>
                    <th>Uploaded At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(count($files)> 0)
                @foreach ($files as $file)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $file->name }}</td>
                    <td>{{ $file->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $file->file) }}" class="btn btn-sm btn-secondary" download>Download</a>
                        <a href="{{ route('contacts.view', $file->id) }}" class="btn btn-sm btn-info">View Contacts</a>
                        <form action="{{ route('file.delete', $file->id) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection