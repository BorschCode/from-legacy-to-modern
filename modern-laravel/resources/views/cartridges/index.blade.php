@extends('layouts.app')

@section('title', 'All Cartridges - Cartridge Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-database"></i> Cartridge Database</h4>
                <a href="{{ route('cartridges.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus"></i> Add New Cartridge
                </a>
            </div>
            <div class="card-body">
                @if($cartridges->count() > 0)
                    <div class="table-responsive">
                        <table id="cartridgesTable" class="table table-striped table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Department/Owner</th>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>Code</th>
                                    <th>Refiller</th>
                                    <th>Condition</th>
                                    <th>Note</th>
                                    <th>Weight Before</th>
                                    <th>Weight After</th>
                                    <th>Weight Diff</th>
                                    <th>Sent Date</th>
                                    <th>Return Date</th>
                                    <th>In Service</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartridges as $cartridge)
                                <tr>
                                    <td>{{ $cartridge->id }}</td>
                                    <td>{{ $cartridge->owner }}</td>
                                    <td>{{ $cartridge->brand }}</td>
                                    <td>{{ $cartridge->marks }}</td>
                                    <td><span class="badge bg-secondary">{{ $cartridge->code }}</span></td>
                                    <td>{{ $cartridge->servicename ?? '-' }}</td>
                                    <td>
                                        @if($cartridge->technical_life == 1)
                                            <span class="badge bg-success">Working</span>
                                        @else
                                            <span class="badge bg-danger">Out of Service</span>
                                        @endif
                                    </td>
                                    <td>{{ $cartridge->comments ?? '-' }}</td>
                                    <td>{{ $cartridge->weight_before }}</td>
                                    <td>{{ $cartridge->weight_after }}</td>
                                    <td>
                                        @php
                                            $diff = $cartridge->weight_difference;
                                        @endphp
                                        <span class="badge {{ $diff > 0 ? 'bg-success' : ($diff < 0 ? 'bg-warning' : 'bg-secondary') }}">
                                            {{ $diff > 0 ? '+' : '' }}{{ $diff }}
                                        </span>
                                    </td>
                                    <td>{{ $cartridge->date_outcome ? $cartridge->date_outcome->format('d.m.Y') : '-' }}</td>
                                    <td>{{ $cartridge->date_income ? $cartridge->date_income->format('d.m.Y') : '-' }}</td>
                                    <td>
                                        @if($cartridge->inservice == 1)
                                            <span class="badge bg-warning"><i class="fas fa-tools"></i> Yes</span>
                                        @else
                                            <span class="badge bg-info"><i class="fas fa-check"></i> No</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('cartridges.edit', $cartridge) }}"
                                           class="btn btn-sm btn-warning"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('cartridges.history', $cartridge) }}"
                                           class="btn btn-sm btn-info"
                                           title="History">
                                            <i class="fas fa-history"></i>
                                        </a>
                                        <form action="{{ route('cartridges.destroy', $cartridge) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this cartridge?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle fa-3x mb-3"></i>
                        <h5>No records in the database</h5>
                        <p class="mb-0">
                            <a href="{{ route('cartridges.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add your first cartridge
                            </a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#cartridgesTable').DataTable({
            order: [[0, 'desc']],
            pageLength: 25,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });
    });
</script>
@endpush
