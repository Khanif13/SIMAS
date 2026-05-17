@extends('layouts.app')

@section('title', 'Dashboard - SIMAS')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2" style="color: var(--secondary-color);">Dashboard Overview</h1>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-muted">Total Surat Masuk</h5>
                    <h2 class="fw-bold" style="color: var(--secondary-color);">142</h2>
                </div>
            </div>
        </div>
        <!-- Additional Stat Cards -->
    </div>
@endsection
