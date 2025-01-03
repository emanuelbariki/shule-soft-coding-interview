<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Employee Reports')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles') <!-- For additional page-specific styles -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Employee Reports</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="{{ route('monthlyAllowanceReport') }}" class="list-group-item list-group-item-action">Monthly Allawance</a>
                    <a href="{{ route('yearlySalaryReport') }}" class="list-group-item list-group-item-action">Yearly Salary Report</a>
                    <a href="{{ route('generateAnnualAllowanceReport') }}" class="list-group-item list-group-item-action">Annual Allowance Report</a>
                </div>
            </div>
            <div class="col-md-9">
                @yield('content') <!-- For page-specific content -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts') <!-- For additional page-specific scripts -->
</body>
</html>
