@extends('layouts.app')
@section('title', 'Dashboard')

<style>
    .table-no-bg,
    .table-no-bg td,
    .table-no-bg th {
        background: inherit !important;
        color: #fff !important;
		border: 1px solid #000 !important;
    }
</style>

@section('content')
    <div class="row">
        @php
            $colors = [
				'text-bg-primary', 
				'text-bg-success', 
				'text-bg-info', 
				'text-bg-secondary',
				'text-bg-danger', 
			];
        @endphp

        @foreach ($types as $key => $item)
            <div class="col-lg-3 col-md-6 col-sm-12">
                <a href="{{ $item['link'] }}" class="text-decoration-none">
                    <div class="small-box {{ $colors[$key % count($colors)] }} p-3 shadow-sm">
                        <table class="table table-bordered table-rounded table-no-bg mb-0 text-center">
                            <tr>
                                <td rowspan="4" class="align-middle">
                                    <h3 class="mb-0">
                                        {{ ($item['pending'] ?? 0) + ($item['accepted'] ?? 0) + ($item['rejected'] ?? 0) }}
                                    </h3>
                                    <h5 class="mb-0">{{ $item['title'] }}</h5>
                                </td>
                                <td>Pending</td>
                                <td>
									{{ $item['pending'] ?? 0 }}
								</td>
                            </tr>
                            <tr>
                                <td>Accepted</td>
                                <td>{{ $item['accepted'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>Rejected</td>
                                <td>{{ $item['rejected'] ?? 0 }}</td>
                            </tr>
                        </table>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
