@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card">
                    <h4 class="card-header py-2 text-center">{{ __('Search Results') }}</h4>
                    <div class="card-body">
						@if ($students->isEmpty())
							<div class="alert alert-warning">No student found with this number.</div>
						@else
							<table class="table table-bordered table-striped mt-2 text-center">
								<thead>
									<tr class="bg-info">
										<th>Reg no</th>
										<th>Student name</th>
										<th>Father name</th>
										<th class="d-none d-md-table-cell">Date of birth</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($students as $student)
										<tr>
											<td>{{ $student->reg_number }}</td>
											<td>{{ $student->name }}</td>
											<td>{{ $student->father }}</td>
											<td class="d-none d-md-table-cell">{{ \Carbon\Carbon::parse($student->dob)->format('F-d, Y') }}</td>
											<td>
												<a href="{{ route('student.print', $student->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
													<i class="bi bi-printer pe-2"></i> Print
												</a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
