@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Leads</h5>
                    <p class="card-text fs-4">{{ $totalLeads }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Checklist Completed</h5>
                    <p class="card-text fs-4">{{ $completionPercentage }}%</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <canvas id="leadsChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('leadsChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($leadsPerCategory->keys()) !!},
            datasets: [{
                label: 'Leads per Category',
                data: {!! json_encode($leadsPerCategory->values()) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
