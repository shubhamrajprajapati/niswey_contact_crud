@extends('layouts.app')

@section('content')
    <h1 class="text-center">Contacts List</h1>

    <!-- Show success message if import was successful -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="text-end mb-3 d-flex gap-2 flex-wrap justify-content-end align-items-center">
        <a href="{{ route('contacts.create') }}" class="btn btn-success">Add New Contact</a>
        <a href="{{ route('contacts.import.form') }}" class="btn btn-danger">Import XML Contact</a>
        
        <!-- Export Dropdown Button -->
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Export
            </button>
            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                <li><a class="dropdown-item" href="{{ route('contacts.export') }}">Export as CSV</a></li>
                <li><a class="dropdown-item" href="{{ route('contacts.export.xml') }}">Export as XML</a></li>
            </ul>
        </div>

    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>
                        <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <!-- Delete Button with Modal Trigger -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-contact-id="{{ $contact->id }}" data-contact-name="{{ $contact->name }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Contact Developer Section (Gravatar Profile + Contact Info) -->
    <div class="contact-developer mt-5 text-center p-5 m-5 mx-auto border rounded" style="max-width: 500px;">
        <h4>Like this Application? Contact Me!</h4>
        
        <!-- Gravatar Profile -->
        <a href="https://gravatar.com/shubhamrajprajapati" target="_blank">
            <img src="{{asset('shubham-raj.png')}}" 
                 alt="Shubham Raj" class="rounded-circle" width="80" height="80">
        </a>

        <p>I'm Shubham Raj, the developer of this Contact Manager. Feel free to contact me if you think this app is useful or if you have any questions or feedback!</p>
        
        <!-- Contact Me Button (opens email client) -->
        <a href="mailto:shubhamrajprajapati@example.com?subject=Contact Manager Feedback" class="btn btn-success">
            Contact Me
        </a>
        <a href="https://gravatar.com/shubhamrajprajapati" target="_blank" class="btn btn-info">
            Gravatar Profile
        </a>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this contact: <strong><span id="contactName"></span></strong>?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Set the contact ID and name for deletion in the modal
        var deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var contactId = button.getAttribute('data-contact-id');
            var contactName = button.getAttribute('data-contact-name');
            
            // Set the contact name in the modal
            document.getElementById('contactName').textContent = contactName;

            // Set the form action URL for deletion
            var form = deleteModal.querySelector('#deleteForm');
            form.action = '/contacts/' + contactId;
        });
    </script>
@endsection