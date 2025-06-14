<?php

namespace App\Http\Controllers;
use App\Models\Checklist;
use App\Models\Lead;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function index($leadId)
    {
        $lead = Lead::with('checklists')->findOrFail($leadId);
        return view('checklists.index', compact('lead'));
    }

    public function toggle(Request $request)
    {
        $checklist = Checklist::findOrFail($request->id);
        $checklist->is_complete = !$checklist->is_complete;
        $checklist->save();

        $lead = $checklist->lead;
        $total = $lead->checklists->count();
        $completed = $lead->checklists->where('is_complete', true)->count();
        $progress = round(($completed / max($total, 1)) * 100);

        return response()->json(['success' => true, 'progress' => $progress]);
    }

}


