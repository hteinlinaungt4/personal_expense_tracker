@extends('layouts.master')
@section('title')
<div>
    <h1 class="h3 mb-0 text-gray-800">Income Chart</h1>
    <span class="badge badge-info fs-5">{{ number_format($totalIncomeAmount) }} MMK</span>
</div>
@endsection
@section('income', 'active')

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
          'last7DaysIncome', 'last6WeeksIncome', 'last6MonthsIncome'

            const last7DaysIncome = @json($last7DaysIncome);
            const last6WeeksIncome = @json($last6WeeksIncome);
            const last6MonthsIncome = @json($last6MonthsIncome);

            const dailyLabels = Object.keys(last7DaysIncome);
            const weeklyLabels = Object.keys(last6WeeksIncome);
            const monthlyLabels = Object.keys(last6MonthsIncome);

            // Bar Chart: Monthly Income
            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: {
                    labels: dailyLabels.map(day => day),
                    datasets: [{
                        label: 'Last 7 Days Income',
                        data: last7DaysIncome,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                }
            });

            // Line Chart: Daily Income (This Month)
            new Chart(document.getElementById('lineChart'), {
                type: 'line',
                data: {
                    labels: weeklyLabels.map(week => week),
                    datasets: [{
                        label: 'Last 6 Weeks Income',
                        data: last6WeeksIncome,
                        borderColor: 'rgb(255, 99, 132)',
                        fill: false,
                        tension: 0.3
                    }]
                }
            });


             // Bar Chart: Monthly Income
             new Chart(document.getElementById('barChart1'), {
                type: 'bar',
                data: {
                    labels: monthlyLabels.map(month => month),
                    datasets: [{
                        label: 'Last 6 Months Income',
                        data: last6MonthsIncome,
                        backgroundColor: 'rgba(20, 50, 235, 0.6)',
                        borderColor: 'rgba(20, 50, 235, 1)',
                        borderWidth: 1
                    }]
                }
            });

        });
    </script>
@endpush
