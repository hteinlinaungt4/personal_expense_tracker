<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Income Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 24px;
            color: #2c3e50;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            background-color: #17a2b8;
            color: #fff;
            border-radius: 5px;
            margin: 0 auto 20px auto;
            text-align: center;
        }

        .charts {
            width: 100%;
            margin-top: 30px;
        }

        .chart-row {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .chart-cell {
            display: table-cell;
            width: 50%;
            padding: 10px;
            vertical-align: top;
        }

        .center-chart {
            text-align: center;
            margin-top: 20px;
        }

        h4 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #555;
        }

        img {
            width: 100%;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <h1>Income Report</h1>
    <div class="badge">Total Income: {{ number_format($totalIncomeAmount) }} MMK</div>

    <div class="charts">
        <div class="chart-row">
            <div class="chart-cell">
                <h4>Last 7 Days</h4>
                <img src="{{ $chart1 }}">
            </div>
            <div class="chart-cell">
                <h4>Last 6 Weeks</h4>
                <img src="{{ $chart2 }}">
            </div>
        </div>

        <div class="center-chart">
            <h4>Last 6 Months</h4>
            <img src="{{ $chart3 }}" style="width: 60%;">
        </div>
    </div>

</body>
</html>
