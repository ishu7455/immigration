<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Checklist;
use App\Models\Document;
use App\Models\Lead;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        if ($request->email === 'client@example.com') {
            return response()->json([
                'token' => 'dummy-jwt-token',
                'lead_id' => 1,
            ]);
        }

        return response()->json(['error' => 'Invalid login'], 401);
    }

    public function leadDetails($id)
    {
        $lead = Lead::find($id);

        if (!$lead) {
            return response()->json(['error' => 'Lead not found'], 404);
        }

        return response()->json($lead);
    }

    public function checklist($leadId)
    {
        $checklist = Checklist::where('lead_id', $leadId)->get();
        $total = $checklist->count();
        $completed = $checklist->where('is_complete', 1)->count();
        $progress = $total > 0 ? round(($completed / $total) * 100) : 0;

        return response()->json([
            'items' => $checklist,
            'progress' => $progress,
        ]);
    }

    public function upload(Request $request, Lead $lead)
    {
        $request->validate([
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        foreach ($request->file('documents') as $file) {
            $path = $file->store('documents');

            Document::create([
                'lead_id' => $lead->id,
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
            ]);
        }

        return response()->json(['message' => 'Files uploaded successfully']);
    }

    public function getByLead($leadId)
    {
        $documents = Document::where('lead_id', $leadId)->get()->map(function ($doc) {
            return [
                'id' => $doc->id,
                'original_name' => $doc->original_name,
                'url' => Storage::url($doc->path),
            ];
        });

        return response()->json($documents);
    }
}
