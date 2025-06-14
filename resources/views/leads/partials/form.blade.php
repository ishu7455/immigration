<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $lead->name ?? '') }}">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email', $lead->email ?? '') }}">
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="phone" class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
           value="{{ old('phone', $lead->phone ?? '') }}">
    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="uci" class="form-label">UCI</label>
    <input type="text" name="uci" class="form-control @error('uci') is-invalid @enderror"
           value="{{ old('uci', $lead->uci ?? '') }}">
    @error('uci') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="case_type" class="form-label">Case Type</label>
    <select name="case_type" class="form-select @error('case_type') is-invalid @enderror">
        <option value="">-- Select Case Type --</option>
        @foreach(['Express Entry', 'Study Permit', 'Work Permit', 'Visitor Visa', 'PR Card'] as $type)
            <option value="{{ $type }}" {{ (old('case_type', $lead->case_type ?? '') == $type) ? 'selected' : '' }}>
                {{ $type }}
            </option>
        @endforeach
    </select>
    @error('case_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
