@extends('layouts.app')

@section('content')
    <h1 class="text-center mb-5">Edit Contact</h1>

    <div class="col-md-6 offset-md-3">
        <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $contact->name }}" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $contact->phone }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Contact</button>
        </form>
    </div>
@endsection