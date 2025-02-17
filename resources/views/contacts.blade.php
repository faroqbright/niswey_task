@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Contacts for File: {{ $file->name }}</h2>
    
    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $contact->firstname }}</td>
                <td>{{ $contact->lastname }}</td>
                <td>{{ $contact->phone }}</td>
                <td>
                    <form action="{{ route('contact.delete', $contact->id) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(event)">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center mt-3">
        <a href="{{ route('welcome') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection