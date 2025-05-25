@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Admin Dashboard</h4>
                </div>
                <div class="card-body">
                    <p>Welcome, <strong>{{ Auth::user()->name }}</strong>!</p>
                    <p class="text-muted">Use the sections below to manage different parts of the system.</p>
                </div>
            </div>

            <div class="row">
                <!-- Manage Shops -->
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-shop me-3 fs-2 text-primary"></i>
                            <div>
                                <h5 class="card-title mb-1">Manage Shops</h5>
                                <a href="{{ route('admin.shops') }}" class="stretched-link text-decoration-none">Go to Shops</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Manage Products -->
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex align-items-center">
                            <i class="bi bi-box-seam me-3 fs-2 text-success"></i>
                            <div>
                                <h5 class="card-title mb-1">Manage Products</h5>
                                <a href="{{ route('admin.products') }}" class="stretched-link text-decoration-none">Go to Products</a>
                            </div>
                        </div>
                    </div>
                </div>

                

                <!-- You can add more blocks here -->

            </div>
        </div>
    </div>
</div>
@endsection
