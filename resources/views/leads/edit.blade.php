@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Lead</h2>

    <form action="{{ route('leads.update', $lead->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('leads.partials.form')
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('leads.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
