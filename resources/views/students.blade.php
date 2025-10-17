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
                                <th idth="3%">SL</th>
                                <th>Reg No.</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Father name</th>
                                <th>Date of birth</th>
                                <th>Print</th>
                            </thead>
                            <tbody>
								@foreach ($students as $key => $item)
									<tr>
                                        <td {{!! $item->id !!}}>{!! $loop->iteration !!}</td>
                                        <td>{!! $item->reg_number !!}</td>
                                       	@php
											$imagePath = $item->image && file_exists(public_path($item->image))
												? asset($item->image)
												: asset('uploads/profile.jpg');
										@endphp

										<td class="center">
											<img src="{{ $imagePath }}" class="rounded-circle border" width="80" height="80" alt="{{ $item->name }}">
										</td>
                                        <td>{!! $item->name !!}</td>	
                                        <td>{!! $item->father !!}</td>	
                                        <td>{!! $item->dob !!}</td>	
										<td>
											<a href="{{ route('student.print', $item->id) }}" target="_blank" class="btn btn-primary">
												<i class="bi bi-printer pe-2"></i> Print Registration
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
@endsection

@section('js')
@endsection
