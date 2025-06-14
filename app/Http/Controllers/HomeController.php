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

        $leadsPerCategory = Lead::select('case_type', DB::raw('count(*) as total'))
            ->groupBy('case_type')
            ->pluck('total', 'case_type');

        $totalChecklistItems = Checklist::count();
        $completedChecklistItems = Checklist::where('is_complete', 1)->count();

        $completionPercentage = $totalChecklistItems > 0
            ? round(($completedChecklistItems / $totalChecklistItems) * 100, 2)
            : 0;

        return view('home', compact(
            'totalLeads',
            'leadsPerCategory',
            'completionPercentage'
        ));
    }
}

