<?php

namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\Lead;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index($leadId)
    {
        $lead = Lead::with('documents')->findOrFail($leadId);
        return view('documents.index', compact('lead'));
    }

    public function store(Request $request, $leadId)
    {
        $request->validate([
            'documents.*' => 'required|file|mimes:pdf,jpg,png,jpeg|max:2048'
        ]);

        foreach ($request->file('documents') as $file) {
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('documents', 'public');

            Document::create([
                'lead_id' => $leadId,
                'file_name' => $fileName,
                'file_path' => $filePath
            ]);
        }

        return redirect()->back()->with('success', 'Documents uploaded successfully.');
    }

}
