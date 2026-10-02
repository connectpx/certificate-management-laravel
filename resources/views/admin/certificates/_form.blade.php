@php($certificate = $certificate ?? null)

<div class="row g-3">
    <div class="col-md-12">
        <label class="form-label">Handler Name</label>
        <input type="text" name="handler_name" value="{{ old('handler_name', $certificate?->handler_name) }}" class="form-control @error('handler_name') is-invalid @enderror" required>
        @error('handler_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-12">
        <label class="form-label">Certificate Number</label>
        <input type="text" name="certificate_number" value="{{ old('certificate_number', $certificate?->certificate_number ?? ($suggestedNumber ?? '')) }}" class="form-control @error('certificate_number') is-invalid @enderror">
        <div class="form-text">Format example: BASDU/OA/2025/0147 — editable manually.</div>
        @error('certificate_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Date of Assessment</label>
        <input type="date" name="date_of_assessment" value="{{ old('date_of_assessment', optional($certificate?->date_of_assessment)->format('Y-m-d')) }}" class="form-control @error('date_of_assessment') is-invalid @enderror" required>
        @error('date_of_assessment') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Result</label>
        <select name="result" class="form-select @error('result') is-invalid @enderror" required>
            <option value="PASS" @selected(old('result', $certificate?->result ?? 'PASS') === 'PASS')>PASS</option>
            <option value="FAIL" @selected(old('result', $certificate?->result) === 'FAIL')>FAIL</option>
        </select>
        @error('result') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Training Organization</label>
        <input type="text" name="training_organization" value="{{ old('training_organization', $certificate?->training_organization) }}" class="form-control @error('training_organization') is-invalid @enderror" required>
        @error('training_organization') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Assessor Name</label>
        <input type="text" name="assessor_name" value="{{ old('assessor_name', $certificate?->assessor_name) }}" class="form-control @error('assessor_name') is-invalid @enderror" required>
        @error('assessor_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="active" @selected(old('status', $certificate?->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $certificate?->status) === 'inactive')>Inactive</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
