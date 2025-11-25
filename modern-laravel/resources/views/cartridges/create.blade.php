@extends('layouts.app')

@section('title', 'Add New Cartridge')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Add New Cartridge</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('cartridges.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Owner / Department -->
                        <div class="col-md-6 mb-3">
                            <label for="owner" class="form-label">Department/Owner <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('owner') is-invalid @enderror"
                                   id="owner"
                                   name="owner"
                                   value="{{ old('owner') }}"
                                   required>
                            @error('owner')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Brand -->
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label">Brand <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('brand') is-invalid @enderror"
                                   id="brand"
                                   name="brand"
                                   value="{{ old('brand') }}"
                                   required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Model -->
                        <div class="col-md-6 mb-3">
                            <label for="marks" class="form-label">Model <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('marks') is-invalid @enderror"
                                   id="marks"
                                   name="marks"
                                   value="{{ old('marks') }}"
                                   required>
                            @error('marks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Code -->
                        <div class="col-md-6 mb-3">
                            <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('code') is-invalid @enderror"
                                   id="code"
                                   name="code"
                                   value="{{ old('code') }}"
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
                                   value="{{ old('servicename') }}">
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
                                <option value="1" {{ old('technical_life', 1) == 1 ? 'selected' : '' }}>Working</option>
                                <option value="0" {{ old('technical_life') == 0 ? 'selected' : '' }}>Out of Service</option>
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
                                   value="{{ old('weight_before', 0) }}"
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
                                   value="{{ old('weight_after', 0) }}"
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
                                   value="{{ old('date_outcome') }}">
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
                                   value="{{ old('date_income', date('Y-m-d')) }}">
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
                                      rows="3">{{ old('comments') }}</textarea>
                            @error('comments')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('cartridges.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Add Cartridge
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
