@extends('layouts.app')

@section('content')
    <h1 class="text-center mb-5">Add New Contact</h1>

    <div class="col-md-6 offset-md-3">
        <form action="{{ route('contacts.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>

            <button type="submit" class="btn btn-primary">Save Contact</button>
        </form>
    </div>
@endsection