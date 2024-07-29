@extends('layouts.main')

@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>

    <div class="row">
      <!-- Order Statistics -->
      <div class="col-md-12 col-lg-12 col-xl-12 order-0 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="d-flex flex-column align-items-center gap-1">
                <h2 class="mb-2">8,258</h2>
                <span>Total Orders</span>
              </div>
              <div id="orderStatisticsChart"></div>
            </div>
          </div>
        </div>
      </div>
      <!--/ Order Statistics -->
    </div>
@endsection
