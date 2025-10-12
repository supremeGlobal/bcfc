@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid pt-4">
        <div class="row">
            @php
                $colors = [
                    'text-bg-primary',
                    'text-bg-secondary',
                    'text-bg-success',
                    'text-bg-info',
                    'text-bg-warning',
                    'text-bg-danger',
                    'text-bg-light',
                    'text-bg-dark',
                ];

                $icon = [
                    'fa-solid fa-building',
                    'fa-solid fa-bell',
                    'fa-solid fa-lightbulb',
                    'fa-solid fa-user-gear',
                    'fa-solid fa-wifi',
                    'fa-solid fa-globe',
                ];
            @endphp

            @foreach ($types as $key => $item)
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="{{ $item['link'] }}" class="text-decoration-none">
                        <div class="small-box {{ $colors[$key % count($colors)] }} py-3">
                            <div class="inner">
                                <h3>{{ $item['value'] ?? 0 }}</h3>
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
