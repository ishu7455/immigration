@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Lead</h2>

    <form action="{{ route('leads.store') }}" method="POST">
        @csrf
        @include('leads.partials.form')
        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('leads.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
