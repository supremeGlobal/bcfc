@extends('layouts.app')
@section('title', 'Student list')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h4 class="card-header bg-success text-center p-1 mx-1 mt-1 text-light">Student list ({{$students->count()}})</h4>
                    <div class="card-body px-1 py-0">
                        <table class="table table-bordered align-middle text-center">
                            <thead>
								<th class="d-none"></th>
                                <th width="3%">Serial</th>
                                <th>Reg No.</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Father name</th>
                                <th>Date of birth</th>
                            </thead>
                            <tbody>
								@foreach ($students->sortByDesc('id')->values() as $key => $item)
									<tr>
										<td class="d-none"></td>
                                        <td width="30">{!! $item->id !!}</td>
                                        <td>{!! $item->reg_number !!}</td>
                                       	@php
											$imagePath = $item->image && file_exists(public_path($item->image))
												? asset($item->image)
												: asset('uploads/profile.png');
										@endphp

										<td class="center border">
											<img src="{{ $imagePath }}" class="rounded-circle border" width="80" height="80" alt="{{ $item->name }}">
										</td>
                                        <td class="px-3">{!! $item->name !!}</td>	
                                        <td class="px-3">{!! $item->father !!}</td>	
                                        <td class="px-3">{!! $item->dob !!}</td>	
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
