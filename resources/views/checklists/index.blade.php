@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Checklist for <strong>{{ $lead->name }}</strong></h2>
    <div class="mb-4">
        <label class="form-label">Progress:</label>
        <div class="progress" style="height: 25px;">
            <div id="progressBar" class="progress-bar bg-success" role="progressbar"
                style="width: {{ $progress = round(($lead->checklists->where('is_complete', true)->count() / max($lead->checklists->count(), 1)) * 100) }}%;"
                aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                {{ $progress }}%
            </div>
        </div>
    </div>
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>Checklist Item</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($lead->checklists as $item)
            <tr class="checklist-row {{ $item->is_completed ? 'table-success' : '' }}">
                <td class="{{ $item->is_complete ? 'text-success text-decoration-line-through' : '' }}">
                    {{ $item->item }}
                </td>
                <td>
                    <input
                        type="checkbox"
                        class="form-check-input toggle-status"
                        data-id="{{ $item->id }}"
                        @if($item->is_complete) checked @endif
                    >
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
document.querySelectorAll('.toggle-status').forEach(function(checkbox) {
    checkbox.addEventListener('change', function () {
        const itemId = this.dataset.id;
        fetch("{{ route('checklists.toggle') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: itemId })
        })
        .then(response => response.json())
        .then(data => {
            const row = this.closest('tr');
            const cell = row.querySelector('td');

            if (this.checked) {
                row.classList.add('table-success');
                cell.classList.add('text-success', 'text-decoration-line-through');
            } else {
                row.classList.remove('table-success');
                cell.classList.remove('text-success', 'text-decoration-line-through');
            }

            const progressBar = document.getElementById('progressBar');
            progressBar.style.width = data.progress + '%';
            progressBar.setAttribute('aria-valuenow', data.progress);
            progressBar.textContent = data.progress + '%';
        });
    });
});
</script>
@endsection
