@extends('layouts.app')

@section('title', 'Edit Cartridge #' . $cartridge->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Cartridge #{{ $cartridge->id }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('cartridges.update', $cartridge) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Owner / Department -->
                        <div class="col-md-6 mb-3">
                            <label for="owner" class="form-label">Department/Owner <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('owner') is-invalid @enderror"
                                   id="owner"
                                   name="owner"
                                   value="{{ old('owner', $cartridge->owner) }}"
                                   required>
                            @error('owner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Brand (Read-only) -->
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text"
                                   class="form-control"
                                   id="brand"
                                   value="{{ $cartridge->brand }}"
                                   readonly>
                            <small class="text-muted">Brand cannot be changed</small>
                        </div>

                        <!-- Model (Read-only) -->
                        <div class="col-md-6 mb-3">
                            <label for="marks" class="form-label">Model</label>
                            <input type="text"
                                   class="form-control"
                                   id="marks"
                                   value="{{ $cartridge->marks }}"
                                   readonly>
                            <small class="text-muted">Model cannot be changed</small>
                        </div>

                        <!-- Code -->
                        <div class="col-md-6 mb-3">
                            <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('code') is-invalid @enderror"
                                   id="code"
                                   name="code"
                                   value="{{ old('code', $cartridge->code) }}"
                                   required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Service Name -->
                        <div class="col-md-6 mb-3">
                            <label for="servicename" class="form-label">Service Center</label>
                            <input type="text"
                                   class="form-control @error('servicename') is-invalid @enderror"
                                   id="servicename"
                                   name="servicename"
                                   value="{{ old('servicename', $cartridge->servicename) }}">
                            @error('servicename')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Technical Life -->
                        <div class="col-md-6 mb-3">
                            <label for="technical_life" class="form-label">Condition <span class="text-danger">*</span></label>
                            <select class="form-select @error('technical_life') is-invalid @enderror"
                                    id="technical_life"
                                    name="technical_life"
                                    required>
                                <option value="1" {{ old('technical_life', $cartridge->technical_life) == 1 ? 'selected' : '' }}>Working</option>
                                <option value="0" {{ old('technical_life', $cartridge->technical_life) == 0 ? 'selected' : '' }}>Out of Service</option>
                            </select>
                            @error('technical_life')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Weight Before -->
                        <div class="col-md-6 mb-3">
                            <label for="weight_before" class="form-label">Weight Before (g) <span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control @error('weight_before') is-invalid @enderror"
                                   id="weight_before"
                                   name="weight_before"
                                   value="{{ old('weight_before', $cartridge->weight_before) }}"
                                   min="0"
                                   required>
                            @error('weight_before')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Weight After -->
                        <div class="col-md-6 mb-3">
                            <label for="weight_after" class="form-label">Weight After (g) <span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control @error('weight_after') is-invalid @enderror"
                                   id="weight_after"
                                   name="weight_after"
                                   value="{{ old('weight_after', $cartridge->weight_after) }}"
                                   min="0"
                                   required>
                            @error('weight_after')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date Outcome -->
                        <div class="col-md-6 mb-3">
                            <label for="date_outcome" class="form-label">Sent Date</label>
                            <input type="date"
                                   class="form-control @error('date_outcome') is-invalid @enderror"
                                   id="date_outcome"
                                   name="date_outcome"
                                   value="{{ old('date_outcome', $cartridge->date_outcome?->format('Y-m-d')) }}">
                            @error('date_outcome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date Income -->
                        <div class="col-md-6 mb-3">
                            <label for="date_income" class="form-label">Return Date</label>
                            <input type="date"
                                   class="form-control @error('date_income') is-invalid @enderror"
                                   id="date_income"
                                   name="date_income"
                                   value="{{ old('date_income', $cartridge->date_income?->format('Y-m-d')) }}">
                            @error('date_income')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Comments -->
                        <div class="col-12 mb-3">
                            <label for="comments" class="form-label">Comments</label>
                            <textarea class="form-control @error('comments') is-invalid @enderror"
                                      id="comments"
                                      name="comments"
                                      rows="3">{{ old('comments', $cartridge->comments) }}</textarea>
                            @error('comments')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('cartridges.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <div>
                            <a href="{{ route('cartridges.history', $cartridge) }}" class="btn btn-info">
                                <i class="fas fa-history"></i> View History
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update Cartridge
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
