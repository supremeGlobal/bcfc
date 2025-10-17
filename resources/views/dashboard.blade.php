@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid pt-4">
        <div class="row">
            @php
                $colors = [
                    'text-bg-primary',
                    // 'text-bg-secondary',
                    'text-bg-success',
                    'text-bg-info',
                    'text-bg-danger',
                    'text-bg-warning',
                    // 'text-bg-light',
                    // 'text-bg-dark',
                ];

                $icon = [
					'fa-solid fa-users',
					'fa-solid fa-users',
					'fa-solid fa-users',
					'fa-solid fa-users',
					'fa-solid fa-users',
                ];
            @endphp

            @foreach ($types as $key => $item)
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="{{ $item['link'] }}" class="text-decoration-none">
                        <div class="small-box {{ $colors[$key % count($colors)] }} p-3">
                            <div class="inner">
                                <h3 lass="ps-4">{{ $item['value'] ?? 0 }}</h3>
                                <h4>{{ $item['title'] }}</h4>
                            </div>
                            <i class="{{ $icon[$key] }} small-box-icon"></i>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
