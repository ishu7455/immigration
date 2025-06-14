<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::all();
        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:leads',
            'phone' => 'required|string',
            'uci' => 'required|string',
            'case_type' => 'required|string',
        ]);

        $lead = Lead::create($request->all());
        $items = [
            'Submit Passport Copy',
            'Proof of Funds',
            'Medical Examination',
            'Educational Transcripts',
            'Police Clearance Certificate',
        ];

        foreach (array_slice($items, 0, rand(3, 5)) as $item) {
            $lead->checklists()->create(['item' => $item]);
        }

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    public function show(Lead $lead)
    {
        return view('leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        return view('leads.edit', compact('lead'));
    }

    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:leads,email,' . $lead->id,
            'phone' => 'required|string',
            'uci' => 'required|string',
            'case_type' => 'required|string',
        ]);

        $lead->update($request->all());

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }
}

