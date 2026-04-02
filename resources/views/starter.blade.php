<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
@extends('layouts.master')

@section('content')
<div id="content" class="content py-10">
    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="mb-6">
                    <h1 class="fs-3 mb-1">Dashboard</h1>
                    <p>Your main content goes here…</p>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-lg-3 col-12">
                <div class="card p-4 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-2">
                    <div class="d-flex gap-3 ">
                        <div class="icon-shape icon-md bg-primary text-white rounded-2">
                            <i class="ti ti-report-analytics fs-4"></i>
                        </div>
                        <div>
                            <h2 class="mb-3 fs-6">Total Sales</h2>
                            <h3 class="fw-bold mb-0">$25,000</h3>
                            <p class="text-primary mb-0 small">+5% since last month</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-12">
                <div class="card p-4 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-2">
                    <div class="d-flex gap-3 ">
                        <div class="icon-shape icon-md bg-success text-white rounded-2">
                            <i class="ti ti-repeat fs-4"></i>
                        </div>
                        <div>
                            <h2 class="mb-3 fs-6">Total Purchase</h2>
                            <h3 class="fw-bold mb-0">$18,000</h3>
                            <p class="text-success mb-0 small">+22% since last month</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-12">
                <div class="card p-4 bg-info bg-opacity-10 border border-info border-opacity-25 rounded-2">
                    <div class="d-flex gap-3 ">
                        <div class="icon-shape icon-md bg-info text-white rounded-2">
                            <i class="ti ti-currency-dollar fs-4"></i>
                        </div>
                        <div>
                            <h2 class="mb-3 fs-6">Total Expenses</h2>
                            <h3 class="fw-bold mb-0">$9,000</h3>
                            <p class="text-info mb-0 small">+10% since last month</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-12">
                <div class="card p-4 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-2">
                    <div class="d-flex gap-3 ">
                        <div class="icon-shape icon-md bg-warning text-white rounded-2">
                            <i class="ti ti-notes fs-4"></i>
                        </div>
                        <div>
                            <h2 class="mb-3 fs-6">Invoice Due</h2>
                            <h3 class="fw-bold mb-0">$25,000</h3>
                            <p class="text-warning mb-0 small">+35% since last month</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection