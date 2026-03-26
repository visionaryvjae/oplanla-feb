@extends('layouts.providers')

@section('content')

    <style>
        :root {
            --oplanla-purple: #ad68e4;
            --oplanla-gold: #e4ad68;
            --oplanla-green: #68e4ad;
        }
        .btn-oplanla { background-color: var(--oplanla-purple); color: white; border-radius: 12px; transition: 0.3s; }
        .btn-oplanla:hover { background-color: #924dcc; color: white; transform: translateY(-2px); }
        .card-oplanla { border-radius: 20px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .badge-floor { background-color: var(--oplanla-gold); color: white; border-radius: 8px; padding: 5px 10px; }
        .form-control, .form-select { border-radius: 10px; border: 1px solid #e0e0e0; }
        .table-rounded { border-radius: 15px; overflow: hidden; }
        .checkbox-custom { accent-color: var(--oplanla-purple); width: 18px; height: 18px; }
    </style>

    <div class="container-fluid">
        <div class="row">
            @include('components.page-feedback')
            <div class="col-md-12">
                <h2 class="mb-4">Send Bulk Notifications</h2>
                
                <form action="{{ route('provider.bulk.notifications.send') }}" method="POST" id="bulkMessageForm">
                    @csrf
                    
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <strong>Step 1: Segment Your Audience</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Property</label>
                                    <select class="form-control" id="propertyFilter">
                                        <option value="">All Properties</option>
                                        @foreach($properties as $property)
                                            <option value="{{ $property->id }}">{{ $property->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Floor</label>
                                    <input type="text" class="form-control" id="floorFilter" placeholder="e.g., Level 3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-table table-responsive">
                            <table class="table table-hover align-middle" id="tenantTable">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>Building/Property</th>
                                        <th>Room #</th>
                                        <th>Floor</th>
                                        <th>Tenant Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rooms as $room)
                                    <tr data-property-id="{{ $room->provider_id }}" data-floor="{{ $room->floor_no }}">
                                        <td>
                                            <input type="checkbox" name="selected_tenants[]" value="{{ $room->tenant->id }}" class="tenant-checkbox">
                                        </td>
                                        <td>{{ $room->property->name ?? $room->provider->provider_name }}</td>
                                        <td>{{ $room->room_number }}</td>
                                        <td>{{ $room->floor_no ?? 'N/A' }}</td>
                                        <td>{{ $room->tenant->name ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light">
                            <strong>Step 2: Compose Message</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label>Channel Priority</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="channel" value="email" checked>
                                        <label class="form-check-label">Email (Standard)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="channel" value="whatsapp">
                                        <label class="form-check-label">WhatsApp (High Reach)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="channel" value="sms">
                                        <label class="form-check-label">SMS (Emergency)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Message Content</label>
                                <textarea name="message" class="form-control" rows="5" required placeholder="Type your maintenance alert or announcement here..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-oplanla">
                                Send Bulk Notification
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Logic for Property/Floor Filtering
        document.getElementById('propertyFilter').addEventListener('change', filterTable);
        document.getElementById('floorFilter').addEventListener('keyup', filterTable);

        function filterTable() {
            const propId = document.getElementById('propertyFilter').value;
            const floorVal = document.getElementById('floorFilter').value.toLowerCase();
            const rows = document.querySelectorAll('#tenantTable tbody tr');

            rows.forEach(row => {
                const matchProp = propId === "" || row.dataset.propertyId === propId;
                const matchFloor = floorVal === "" || row.dataset.floor.toLowerCase().includes(floorVal);
                row.style.display = (matchProp && matchFloor) ? "" : "none";
            });
        }

        // Select All logic
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.tenant-checkbox');
            checkboxes.forEach(cb => {
                if(cb.closest('tr').style.display !== 'none') {
                    cb.checked = this.checked;
                }
            });
        });
    </script>
@endsection