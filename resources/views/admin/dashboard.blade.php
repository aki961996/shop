@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Admin Dashboard</h4>
                </div>

                <div class="card-body">
                    <p>Welcome, <strong>{{ Auth::user()->name }}</strong>!</p>
                    <p>This is your admin dashboard where you can manage the application:</p>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="{{ route('admin.shops') }}">Manage Shops</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('admin.products') }}">Manage Products</a>
                        </li>
                        <!-- <li class="list-group-item">
                            <a href="{{ route('admin.stocks') }}">Manage Stocks</a>
                        </li> -->
                        <!-- <li class="list-group-item">
                            <a href="{{ route('admin.customers') }}">Manage Customers</a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection