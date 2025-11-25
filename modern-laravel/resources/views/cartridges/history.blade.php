@extends('layouts.app')

@section('title', 'Cartridge History #' . $cartridge->id)

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Cartridge Info Card -->
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0"><i class="fas fa-info-circle"></i> Cartridge Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <strong>ID:</strong> {{ $cartridge->id }}
                    </div>
                    <div class="col-md-3">
                        <strong>Brand:</strong> {{ $cartridge->brand }}
                    </div>
                    <div class="col-md-3">
                        <strong>Model:</strong> {{ $cartridge->marks }}
                    </div>
                    <div class="col-md-3">
                        <strong>Code:</strong> <span class="badge bg-secondary">{{ $cartridge->code }}</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <strong>Owner:</strong> {{ $cartridge->owner }}
                    </div>
                    <div class="col-md-3">
                        <strong>Service Center:</strong> {{ $cartridge->servicename ?? '-' }}
                    </div>
                    <div class="col-md-3">
                        <strong>Condition:</strong>
                        @if($cartridge->technical_life == 1)
                            <span class="badge bg-success">Working</span>
                        @else
                            <span class="badge bg-danger">Out of Service</span>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <strong>In Service:</strong>
                        @if($cartridge->inservice == 1)
                            <span class="badge bg-warning">Yes</span>
                        @else
                            <span class="badge bg-info">No</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Change History Card -->
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-history"></i> Change History for Cartridge #{{ $cartridge->id }}</h4>
            </div>
            <div class="card-body">
                @if($cartridge->histories->count() > 0)
                    <div class="table-responsive">
                        <table id="historyTable" class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Department/Owner</th>
                                    <th>Refiller</th>
                                    <th>Condition</th>
                                    <th>Weight Before</th>
                                    <th>Weight After</th>
                                    <th>Weight Diff</th>
                                    <th>Sent Date</th>
                                    <th>Return Date</th>
                                    <th>Change Date</th>
                                    <th>Change Log</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartridge->histories as $history)
                                <tr>
                                    <td>{{ $history->id }}</td>
                                    <td>{{ $history->owner }}</td>
                                    <td>{{ $history->servicename }}</td>
                                    <td>
                                        @if($history->technical_life == 1)
                                            <span class="badge bg-success">Working</span>
                                        @else
                                            <span class="badge bg-danger">Out of Service</span>
                                        @endif
                                    </td>
                                    <td>{{ $history->weight_before }}</td>
                                    <td>{{ $history->weight_after }}</td>
                                    <td>
                                        @php
                                            $diff = $history->weight_difference;
                                        @endphp
                                        <span class="badge {{ $diff > 0 ? 'bg-success' : ($diff < 0 ? 'bg-warning' : 'bg-secondary') }}">
                                            {{ $diff > 0 ? '+' : '' }}{{ $diff }}
                                        </span>
                                    </td>
                                    <td>{{ $history->date_outcome ? $history->date_outcome->format('d.m.Y') : '-' }}</td>
                                    <td>{{ $history->date_income ? $history->date_income->format('d.m.Y') : '-' }}</td>
                                    <td>{{ $history->date_of_changes ? $history->date_of_changes->format('d.m.Y') : $history->created_at->format('d.m.Y') }}</td>
                                    <td>
                                        @if($history->log)
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#logModal{{ $history->id }}">
                                                <i class="fas fa-eye"></i> View Log
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="logModal{{ $history->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Change Log Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6><strong>Short Log:</strong></h6>
                                                            <p class="text-muted">{{ $history->log }}</p>

                                                            @if($history->log_full)
                                                                <hr>
                                                                <h6><strong>Full Change Log:</strong></h6>
                                                                <p class="text-muted">{{ $history->log_full }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Latest Change Summary -->
                    @if($cartridge->histories->first())
                        <div class="alert alert-light mt-3">
                            <h6><strong>Latest Change:</strong></h6>
                            <p class="mb-0">{{ $cartridge->histories->first()->log }}</p>
                        </div>
                    @endif
                @else
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p class="mb-0">No history records available for this cartridge.</p>
                    </div>
                @endif

                <div class="mt-3">
                    <a href="{{ route('cartridges.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    <a href="{{ route('cartridges.edit', $cartridge) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Cartridge
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#historyTable').DataTable({
            order: [[0, 'desc']],
            pageLength: 25,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries"
            }
        });
    });
</script>
@endpush
