@extends('school_admin.layouts.app')

@section('title', 'System Activity Log')

@section('content')
    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">System Activity Log</h2>
            <span class="text-muted"><i class="fas fa-shield-alt me-1 text-primary"></i> Secure Audit Trail</span>
        </div>

        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Date & Time</th>
                                <th>User</th>
                                <th>Module</th>
                                <th>Action</th>
                                <th class="pe-4">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td class="ps-4">
                                        <span
                                            class="fw-semibold text-dark">{{ $log->created_at->format('d M Y') }}</span><br>
                                        <small class="text-muted">{{ $log->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width:32px; height:32px; font-weight:bold;">
                                                {{ substr($log->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <span class="fw-medium">{{ $log->user->name ?? 'System User' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">
                                            {{ $log->module }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $actionClass = 'bg-info';
                                            if (strtolower($log->action) == 'created') {
                                                $actionClass = 'bg-success';
                                            }
                                            if (strtolower($log->action) == 'updated') {
                                                $actionClass = 'bg-warning text-dark';
                                            }
                                            if (strtolower($log->action) == 'deleted') {
                                                $actionClass = 'bg-danger';
                                            }
                                        @endphp
                                        <span class="badge {{ $actionClass }}">{{ $log->action }}</span>
                                    </td>
                                    <td class="pe-4 text-muted">
                                        {{ $log->description }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($logs->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-history fa-3x mb-3 opacity-25"></i>
                        <p>No activities recorded yet.</p>
                    </div>
                @endif
            </div>

            @if ($logs->hasPages())
                <div class="card-footer bg-white border-top p-3 d-flex justify-content-end">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
