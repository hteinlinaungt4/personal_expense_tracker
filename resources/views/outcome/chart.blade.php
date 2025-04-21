@extends('layouts.master')
@section('title')
<div>
    <h1 class="h3 mb-0 text-gray-800">Outcome Chart</h1>
    <span class="badge badge-info fs-5">{{ number_format($totaloutcomeAmount) }} MMK</span>
</div>
@endsection
@section('outcome', 'active')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <canvas id="barChart"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="lineChart"></canvas>
        </div>
        <div class="col-md-6 offset-3 my-5">
            <canvas id="barChart1"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
          'last7Daysoutcome', 'last6Weeksoutcome', 'last6Monthsoutcome'

            const last7Daysoutcome = @json($last7Daysoutcome);
            const last6Weeksoutcome = @json($last6Weeksoutcome);
            const last6Monthsoutcome = @json($last6Monthsoutcome);

            const dailyLabels = Object.keys(last7Daysoutcome);
            const weeklyLabels = Object.keys(last6Weeksoutcome);
            const monthlyLabels = Object.keys(last6Monthsoutcome);

            // Bar Chart: Monthly outcome
            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: {
                    labels: dailyLabels.map(day => day),
                    datasets: [{
                        label: 'Last 7 Days outcome',
                        data: last7Daysoutcome,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                }
            });

            // Line Chart: Daily outcome (This Month)
            new Chart(document.getElementById('lineChart'), {
                type: 'line',
                data: {
                    labels: weeklyLabels.map(week => week),
                    datasets: [{
                        label: 'Last 6 Weeks outcome',
                        data: last6Weeksoutcome,
                        borderColor: 'rgb(255, 99, 132)',
                        fill: false,
                        tension: 0.3
                    }]
                }
            });


             // Bar Chart: Monthly outcome
             new Chart(document.getElementById('barChart1'), {
                type: 'bar',
                data: {
                    labels: monthlyLabels.map(month => month),
                    datasets: [{
                        label: 'Last 6 Months outcome',
                        data: last6Monthsoutcome,
                        backgroundColor: 'rgba(20, 50, 235, 0.6)',
                        borderColor: 'rgba(20, 50, 235, 1)',
                        borderWidth: 1
                    }]
                }
            });

        });
    </script>
@endpush
