<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Checklist;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalLeads = Lead::count();

        $caseTypes = Lead::select('case_type')->distinct()->pluck('case_type');

        $completionPerCategory = [];

        foreach ($caseTypes as $caseType) {
            $leadIds = Lead::where('case_type', $caseType)->pluck('id');
            $totalItems = Checklist::whereIn('lead_id', $leadIds)->count();
            $completedItems = Checklist::whereIn('lead_id', $leadIds)
                                ->where('is_complete', 1)->count();

            $completionPerCategory[$caseType] = $totalItems > 0
                ? round(($completedItems / $totalItems) * 100, 2)
                : 0;
        }

        $totalChecklistItems = Checklist::count();
        $completedChecklistItems = Checklist::where('is_complete', 1)->count();

        $completionPercentage = $totalChecklistItems > 0
            ? round(($completedChecklistItems / $totalChecklistItems) * 100, 2)
            : 0;

        return view('home', compact(
            'totalLeads',
            'completionPercentage',
            'completionPerCategory'
        ));
    }

}


