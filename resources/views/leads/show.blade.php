@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lead Details</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $lead->name }}</p>
            <p><strong>Email:</strong> {{ $lead->email }}</p>
            <p><strong>Phone:</strong> {{ $lead->phone }}</p>
            <p><strong>UCI:</strong> {{ $lead->uci }}</p>
            <p><strong>Case Type:</strong> {{ $lead->case_type }}</p>
        </div>
    </div>
    <a href="{{ route('leads.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
