@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>All Leads</h2>
        <a href="{{ route('leads.create') }}" class="btn btn-success">+ Add New Lead</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($leads->count())
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>UCI</th>
                    <th>Case Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leads as $lead)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $lead->name }}</td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->phone }}</td>
                        <td>{{ $lead->uci }}</td>
                        <td>{{ $lead->case_type }}</td>
                        <td>
                            <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="{{ route('checklists.index', $lead->id) }}" class="btn btn-sm btn-warning">
                                Checklist
                            </a>

                                <a href="{{ route('documents.index', $lead->id) }}" class="btn btn-sm btn-info">Documents</a>


                            <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure to delete this lead?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning">No leads found.</div>
    @endif
</div>
@endsection
