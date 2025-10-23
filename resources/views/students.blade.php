@extends('layouts.app')
@section('title', 'Student list')

<style>
    .dataTables td,
    th {
        text-align: center !important;
        vertical-align: middle !important;
    }

    select.status-select {
        cursor: pointer !important;
    }
</style>

@php
    $statuses = [
        'pending' => 'bg-warning text-dark',
        'accepted' => 'bg-success text-white',
        'rejected' => 'bg-danger text-white',
    ];
@endphp
@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header bg-success text-center p-1 mx-1 mt-1 text-light">
                        Student list ({{ $students->count() }})
                    </h4>
                    <div class="card-body px-1 py-0">
                        <table class="table table-bordered align-middle text-center dataTables">
                            <thead>
                                <tr>
                                    <th>Server id</th>
                                    <th>Reg No.</th>
                                    <th>Photo</th>
                                    <th>Certificate</th>
                                    <th>Name</th>
                                    <th>Father name</th>
                                    <th>Mother name</th>
                                    <th>Mobile</th>
                                    <th>Date of birth</th>
                                    <th>Print</th>
                                    <th width="8%">Status</th>
                                    <th>Submit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $key => $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->reg_number }}</td>
                                        <td>
                                            <img src="{{ $item->image_url }}" class="border" width="70" height="70"
                                                alt="{{ $item->name }}">
                                        </td>

                                        <td>
                                            @if ($item->certificate_url)
                                                @if ($item->certificate_is_image)
                                                    <button class="btn btn-outline-success"
                                                        onclick="showCertificateModal('{{ $item->certificate_url }}', '{{ addslashes($item->name) }}')">
                                                        <i class="bi bi-eye pe-1"></i> View
                                                    </button>
                                                @elseif($item->certificate_extension === 'pdf')
                                                    <a href="{{ $item->certificate_url }}" target="_blank"
                                                        class="btn btn-outline-danger">
                                                        <i class="bi bi-file-earmark-pdf pe-1"></i> Download
                                                    </a>
                                                @endif
                                            @endif
                                        </td>

                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->father }}</td>
                                        <td>{{ $item->mother }}</td>
                                        <td>{{ $item->mobile }}</td>

                                        <td>
                                            {{ $item->dob_formatted }} <br>
                                            <span class="fw-bold">Age:</span> (Y: {{ $item->age['y'] }}, M:
                                            {{ $item->age['m'] }}, D: {{ $item->age['d'] }})
                                        </td>

                                        <td>
                                            <a href="{{ route('student.print', $item->id) }}" target="_blank"
                                                class="btn btn-outline-primary">
                                                <i class="bi bi-printer pe-2"></i> Print
                                            </a>
                                        </td>

                                        <td class="px-1">
                                            <select class="form-select status-select {{ $statuses[$item->status] ?? '' }}"
                                                data-id="{{ $item->id }}">
                                                @foreach ($statuses as $key => $class)
                                                    <option value="{{ $key }}"
                                                        {{ $item->status == $key ? 'selected' : '' }}
                                                        class="{{ $class }} my-4">
                                                        {{ ucfirst($key) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>{{ $item->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Certificate Modal --}}
    <div class="modal fade" id="certificateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold" id="certificateModalLabel">Certificate Preview</h5>
                    <button type="button" class="btn-close btn-close-black border border-2 rounded-circle p-1"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center bg-white py-3">
                    <img id="certificateImage" src="" alt="Certificate" class="img-fluid rounded shadow-sm">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function showCertificateModal(src, studentName) {
            const img = document.getElementById('certificateImage');
            const title = document.getElementById('certificateModalLabel');
            img.src = src; // only load when modal opens
            title.textContent = studentName + "'s Certificate";
            const modal = new bootstrap.Modal(document.getElementById('certificateModal'));
            modal.show();
        }
    </script>

    <script>
        $('.status-select').change(function() {
            let selectEl = $(this);
            let id = selectEl.data('id');
            let status = selectEl.val();

            $.ajax({
                type: 'POST',
                url: '/students/' + id + '/update-status',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        // Update select background immediately
                        selectEl.removeClass(
                                'bg-warning text-dark bg-success text-white bg-danger text-white')
                            .addClass(status === 'pending' ? 'bg-warning text-dark' : status ===
                                'accepted' ? 'bg-success text-white' : 'bg-danger text-white');

                        // SweetAlert success
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false,
                            position: 'top'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update status',
                        confirmButtonText: 'OK',
                        position: 'top'
                    });
                }
            });
        });
    </script>
@endsection
