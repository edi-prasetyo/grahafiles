@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            {{-- <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div> --}}

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Pageview
                        </div>
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Downloaded
                        </div>
                        <div class="card-body">
                            <canvas id="myChart_second"></canvas>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const data = {
            labels: @json($data->map(fn($data) => date('d M Y', strtotime($data->date)))),
            datasets: [{
                label: 'Pageviews',
                // backgroundColor: 'rgba(255, 99, 132, 0.3)',
                // borderColor: 'rgb(255, 99, 132)',
                // fill: true,
                backgroundColor: '#2f8d46',
                borderColor: '#1b5e20',
                borderWidth: 1,

                data: @json($data->map(fn($data) => $data->aggregate)),
            }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    },
                    y: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            display: true
                        },
                    }
                },
            },
        };
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
    {{-- Chart Downloaded --}}
    <script>
        const ctx2 = document.getElementById("myChart_second").getContext("2d");

        const labels2 = @json($downloaded->map(fn($downloaded) => date('d M Y', strtotime($downloaded->date))));

        const data2 = {
            labels: labels2,
            datasets: [{
                data: @json($downloaded->map(fn($downloaded) => $downloaded->aggregate)),
                label: 'Dowloaded',
                fill: true,
                backgroundColor: '#2f8d46',
                borderColor: '#1b5e20',
                borderWidth: 1,
            }, ],
        };

        const config2 = {
            type: 'bar',
            data: data2,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    },
                    y: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            display: true
                        },
                    }
                },
            },
        };

        const myChart2 = new Chart(ctx2, config2);
    </script>
@endsection
