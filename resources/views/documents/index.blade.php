@extends('layouts.app')

@section('content')
@php
    $docCount = $lead->documents->count();
    $maxFiles = 3;
    $remainingSlots = $maxFiles - $docCount;
@endphp

<div class="container">
    <h3>Documents for <strong>{{ $lead->name }}</strong></h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('documents.store', $lead->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Upload Documents (Max 3 files)</label>
            <div id="fileInputs">
                @if($remainingSlots > 0)
                    <!-- Initial File Input -->
                    <div class="input-group mb-2 file-input-group">
                        <input type="file" name="documents[]" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                        <button type="button" class="btn btn-danger remove-btn d-none">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                @endif
            </div>

            <!-- + Button -->
            <button type="button" class="btn btn-outline-primary" id="addFileInput" @if($remainingSlots <= 0) disabled @endif>
                <i class="bi bi-plus-lg"></i> Add More
            </button>

            @if($remainingSlots <= 0)
                <div class="text-danger mt-2">You have already uploaded 3 documents.</div>
            @else
                <small class="text-muted d-block mt-2">Accepted: jpg, jpeg, png, pdf | You can add {{ $remainingSlots }} more file(s)</small>
            @endif
        </div>

        <button type="submit" class="btn btn-primary" @if($remainingSlots <= 0) disabled @endif>Upload</button>
    </form>

    <hr>

    <h5 class="mt-4">Uploaded Documents</h5>
    @if($docCount)
        <ul class="list-group">
            @foreach($lead->documents as $doc)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $doc->file_name }}
                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Download</a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted">No documents uploaded yet.</p>
    @endif
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- JavaScript -->
<script>
    const maxFiles = 3;
    const currentUploaded = {{ $docCount }};
    let addedInputs = 1; // 1 initial input already rendered
    const fileInputsContainer = document.getElementById('fileInputs');
    const addFileInputBtn = document.getElementById('addFileInput');

    function updateRemoveButtons() {
        const groups = fileInputsContainer.querySelectorAll('.file-input-group');
        groups.forEach((group, index) => {
            const removeBtn = group.querySelector('.remove-btn');
            removeBtn.classList.toggle('d-none', groups.length === 1);
        });
    }

    function updateAddButtonState() {
        const total = currentUploaded + fileInputsContainer.querySelectorAll('.file-input-group').length;
        if (total >= maxFiles) {
            addFileInputBtn.disabled = true;
        }
    }

    addFileInputBtn?.addEventListener('click', function () {
        const currentCount = fileInputsContainer.querySelectorAll('.file-input-group').length;
        const total = currentUploaded + currentCount;

        if (total >= maxFiles) {
            return;
        }

        const group = document.createElement('div');
        group.className = 'input-group mb-2 file-input-group';

        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'documents[]';
        input.className = 'form-control';
        input.accept = '.jpg,.jpeg,.png,.pdf';
        input.required = true;

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'btn btn-danger remove-btn';
        removeBtn.innerHTML = '<i class="bi bi-trash"></i>';
        removeBtn.onclick = () => {
            group.remove();
            updateRemoveButtons();
            updateAddButtonState();
        };

        group.appendChild(input);
        group.appendChild(removeBtn);
        fileInputsContainer.appendChild(group);

        updateRemoveButtons();
        updateAddButtonState();
    });

    updateRemoveButtons();
    updateAddButtonState();
</script>
@endsection
