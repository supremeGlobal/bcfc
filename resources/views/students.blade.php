@extends('layouts.app')
@section('title', 'Student list')

<style>
	.dataTables td, th{
		text-align: center !important;
	}
</style>

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header bg-success text-center p-1 mx-1 mt-1 text-light">Student list ({{$students->count()}})</h4>
                    <div class="card-body px-1 py-0">
                        <table class="table table-bordered align-middle text-center dataTables">
                            <thead>
                                <th width="3%">SL</th>
                                <th>Reg No.</th>
                                <th>Photo</th>
                                <th>Certificate</th>								
                                <th>Name</th>
                                <th>Father name</th>
                                <th>Mobile</th>
                                <th>Date of birth</th>
                                <th width="10%">Print</th>
                            </thead>
                            <tbody>
								@foreach ($students as $key => $item)
									@php
										$imagePath = $item->image && file_exists(public_path($item->image)) ? asset($item->image) : asset('default/profile.png');
										$certificate = $item->certificate;
										$certificatePath = $certificate && file_exists(public_path($certificate)) ? asset($certificate) : null;
										$ext = $certificatePath ? strtolower(pathinfo($certificatePath, PATHINFO_EXTENSION)) : null;
										$isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
									@endphp
									<tr>
                                        <td {{!! $item->id !!}}>{!! $loop->iteration !!}</td>
                                       	<td>{{ $item->reg_number }}</td>
										<td>
											<img src="{{ $imagePath }}" class="rounded-circle border" width="80" height="80" alt="{{ $item->name }}">
										</td>

										<td>
											@if ($certificatePath)
												@if ($isImage)
													<img src="{{ $certificatePath }}" 
														class="rounded border cert-thumb"
														width="80" height="80"
														alt="{{ $item->name }}"
														style="cursor:pointer;"
														onclick="showCertificateModal('{{ $certificatePath }}', '{{ $item->name }}')">
												@else
													<a href="{{ $certificatePath }}" target="_blank" class="text-decoration-none">
														<i class="fa fa-file-download fa-2x text-primary"></i>
													</a>
												@endif
											@endif
										</td>

                                        <td>{!! $item->name !!}</td>	
                                        <td>{!! $item->father !!}</td>	
                                        <td>{!! $item->mobile !!}</td>	
                                        <td>
											@php
												$diff = \Carbon\Carbon::parse($item->dob)->diff('2025-10-24');
											@endphp
											
											{!! $item->dob->format('F-d, Y') !!}
											<br>
											<strong>
												Age: (Year: {{ $diff->y }}, Month: {{ $diff->m }}, Day: {{ $diff->d }})
											</strong>
										</td>	
										<td>
											<a href="{{ route('student.print', $item->id) }}" target="_blank" class="btn btn-outline-primary">
												<i class="bi bi-printer pe-2"></i> Print
											</a>
										</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<!-- Certificate Preview Modal -->
	<div class="modal fade" id="certificateModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-md">
			<div class="modal-content border-0 shadow-sm">
			
			<!-- Modal Header -->
			<div class="modal-header bg-light border-bottom">
				<h5 class="modal-title fw-bold" id="certificateModalLabel">Certificate Preview</h5>
				<button type="button" class="btn-close btn-close-black border border-2 rounded-circle p-1" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			
			<!-- Modal Body -->
			<div class="modal-body text-center bg-white py-3">
				<img id="certificateImage" src="" alt="Certificate" class="img-fluid rounded shadow-sm">
			</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script>
		function showCertificateModal(imageSrc, studentName) {
			const modalImage = document.getElementById('certificateImage');
			const modalTitle = document.getElementById('certificateModalLabel');

			modalImage.src = imageSrc;
			modalTitle.textContent = studentName + "'s Certificate";

			const modal = new bootstrap.Modal(document.getElementById('certificateModal'), {
				// backdrop: 'static',
				keyboard: true
			});
			modal.show();
		}
	</script>
@endsection