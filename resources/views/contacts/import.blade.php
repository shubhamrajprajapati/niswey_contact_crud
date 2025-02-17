@extends('layouts.app')

@section('content')
    <h1 class="text-center mb-5">Import Contacts from XML</h1>

    <div class="col-md-6 offset-md-3">
        <form action="{{ route('contacts.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Choose XML File</label>
                <input type="file" class="form-control" name="file" accept=".xml" required>
            </div>

            <button type="submit" class="btn btn-primary">Import Contacts</button>
        </form>
    </div>
@endsection
