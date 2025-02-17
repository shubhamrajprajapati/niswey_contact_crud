<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ContactController
{
    // Show all contacts
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

    // Show the form to create a new contact
    public function create()
    {
        return view('contacts.create');
    }

    // Store a new contact
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        Contact::create($request->all());
        return redirect()->route('contacts.index');
    }

    // Show the form to edit an existing contact
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }

    // Update the contact
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($request->all());
        return redirect()->route('contacts.index');
    }

    // Delete a contact
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('contacts.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xml',
        ]);

        $file       = $request->file('file');
        $xmlContent = simplexml_load_file($file);

        foreach ($xmlContent->contact as $contact) {
            Contact::create([
                'name'  => (string) $contact->name,
                'phone' => (string) $contact->phone,
            ]);
        }

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Contacts imported successfully!');
    }

    public function export()
    {
        // Fetch all contacts from the database
        $contacts = Contact::all();

        // Define the CSV headers
        $csvHeaders = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="contacts.csv"',
        ];

        // Open a temporary memory stream to write the CSV data
        $csvOutput = fopen('php://output', 'w');

        // Add the CSV column headers
        fputcsv($csvOutput, ['Name', 'Phone']);

        // Loop through each contact and write to CSV
        foreach ($contacts as $contact) {
            fputcsv($csvOutput, [$contact->name, $contact->phone]);
        }

        // Close the output stream
        fclose($csvOutput);

        // Return the response with the headers to download the CSV file
        return Response::make('', 200, $csvHeaders);
    }

    public function exportXml()
    {
        // Fetch all contacts from the database
        $contacts = Contact::all();

        // Start creating the XML structure
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><contacts></contacts>');

        // Loop through contacts and add them to the XML structure
        foreach ($contacts as $contact) {
            $contactXml = $xml->addChild('contact');
            $contactXml->addChild('name', $contact->name);
            $contactXml->addChild('phone', $contact->phone);
        }

        // Set headers to download the XML file
        $headers = [
            'Content-Type'        => 'text/xml',
            'Content-Disposition' => 'attachment; filename="contacts.xml"',
        ];

        // Return the XML response for download
        return Response::make($xml->asXML(), 200, $headers);
    }
}
