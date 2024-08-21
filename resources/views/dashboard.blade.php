@extends('layouts.main')

@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col col-lg-2">
                            <h2>
                                <i class="fa-solid fa-laptop mt-4"></i>
                            </h2>
                        </div>
                        <div class="col">
                            <h4 class="m-0">Aplikasi</h4>
                            <h2 class="m-0">{{ $app }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col col-lg-2">
                            <h2>
                                <i class="fa-solid fa-plus mt-4"></i>
                            </h2>
                        </div>
                        <div class="col">
                            <h4 class="m-0">Positive</h4>
                            <h2 class="m-0">{{ $positive }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col col-lg-2">
                            <h2>
                                <i class="fa-solid fa-minus mt-4"></i>
                            </h2>
                        </div>
                        <div class="col">
                            <h4 class="m-0">Negative</h4>
                            <h2 class="m-0">{{ $negative }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12 col-md-12 col-12 mb-3">
            <h3 class="mb-0 text-dark fw-bold">Applications Sentiment Analysis</h3>
        </div>
    </div>

    <div class="row">
        <div class="col col-lg-9">
            <div class="card mb-5">
                <div class="card-body">
                    <table id="myTable" class="table text-nowrap w-full mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Application Name</th>
                                <th>Negative Reviews</th>
                                <th>Neutral Reviews</th>
                                <th>Positive Reviews</th>
                                <th>Positive Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applications as $index => $app)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $app['name'] }}</td>
                                    <td>{{ $app['negative'] }}</td>
                                    <td>{{ $app['neutral'] }}</td>
                                    <td>{{ $app['positive'] }}</td>
                                    <td>{{ number_format($app['positive_percentage'], 2) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col col-lg-3">
            <div class="card">
                <div class="card-body">
                    <span>Total Perecentage</span>
                    <div id="orderStatisticsChart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options = {
                chart: {
                    type: 'donut',
                    height: 350
                },
                series: @json($chartData->pluck('positive_percentage')),
                labels: @json($chartData->pluck('name')),
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toFixed(2) + "%";
                    },
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold',
                        colors: ["#304758"]
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }

            var chart = new ApexCharts(document.querySelector("#orderStatisticsChart"), options);
            chart.render();
        });
    </script>
@endsection
