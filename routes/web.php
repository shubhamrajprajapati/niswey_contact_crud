<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

// Home route - displays the list of contacts
Route::get('/', [ContactController::class, 'index'])->name('contacts.index');

// Route to show the import form
Route::get('contacts/import', function () {
    return view('contacts.import');
})->name('contacts.import.form');

// Route for importing contacts via XML
Route::post('contacts/import', [ContactController::class, 'import'])->name('contacts.import');

// Route for exporting contacts as CSV
Route::get('contacts/export', [ContactController::class, 'export'])->name('contacts.export');

// Route for exporting contacts as XML
Route::get('contacts/export/xml', [ContactController::class, 'exportXml'])->name('contacts.export.xml');

// Resource route for CRUD operations
Route::resource('contacts', ContactController::class)->names('contacts');



