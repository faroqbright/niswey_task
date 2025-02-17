<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(){
        $files = File::OrderBy("id","DESC")->get();
        return view("welcome")->with(compact('files'));
    }

    public function contacts($id){
        $file = File::find($id);
        $contacts = Contact::where('file_id', $id)->get();
        return view("contacts")->with(compact('contacts','file'));
    }

    public function delete($id)
    {
        $file = File::findOrFail($id);

        Storage::disk('public')->delete($file->file);

        $file->contacts()->delete();
        $file->delete();

        return back()->with('success', 'File and related contacts deleted successfully.');
    }

    public function contact_delete($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return back()->with('success', 'Contact deleted successfully.');
    }


    public function submit(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:xml|max:2048',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');
        $fileEntry = File::create([
            'name' => $request->title,
            'file' => $filePath
        ]);

        $xmlContent = file_get_contents($file);
        $xml = simplexml_load_string($xmlContent);
        $arrayData = json_decode(json_encode($xml), true);

        foreach ($arrayData['contact'] as $contact) {
            $exists = Contact::where('phone', $contact['phone'])->exists();

            if (!$exists) {
                Contact::create([
                    'file_id' => $fileEntry->id,
                    'firstname' => $contact['name'],
                    'lastname' => $contact['lastName'],
                    'phone' => $contact['phone'],
                ]);
            }
        }

        return back()->with('success', 'File and contacts saved successfully!');
    }
}
