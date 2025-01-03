@extends('app')

@section('title', 'Dashboard')

@section('content')
    <h4>Welcome to the Dashboard</h4>
    <p>Select an option from the menu to proceed.</p>

    <form action="{{ route('monthlyAllowanceReport', ['month' => '__month__', 'year' => '__year__']) }}" method="get">
        @csrf
    
        <!-- Month Selection -->
        <label for="month">Month:</label>
        <select name="month" id="month">
            <option value="1" @if ($month == 1) selected @endif>January</option>
            <option value="2" @if ($month == 2) selected @endif>February</option>
            <option value="3" @if ($month == 3) selected @endif>March</option>
            <option value="4" @if ($month == 4) selected @endif>April</option>
            <option value="5" @if ($month == 5) selected @endif>May</option>
            <option value="6" @if ($month == 6) selected @endif>June</option>
            <option value="7" @if ($month == 7) selected @endif>July</option>
            <option value="8" @if ($month == 8) selected @endif>August</option>
            <option value="9" @if ($month == 9) selected @endif>September</option>
            <option value="10" @if ($month == 10) selected @endif>October</option>
            <option value="11" @if ($month == 11) selected @endif>November</option>
            <option value="12" @if ($month == 12) selected @endif>December</option>
        </select>
    
        <!-- Year Selection -->
        <label for="year">Year:</label>
        <select name="year" id="year">
            @for ($i = 2020; $i <= Carbon\Carbon::now()->year; $i++)
                <option value="{{ $i }}" @if ($year == $i) selected @endif>{{ $i }}</option>
            @endfor
        </select>
    
        <button type="submit">Generate Report</button>
    </form>
    

    <h1>Monthly Allowance Report for {{ Carbon\Carbon::createFromDate($year, $month)->format('F Y') }}</h1>

    <table>
        <thead>
            <tr>
                <th>Allowance Name</th>
                <th>Total Average</th>
                <th>Rank by Total</th>
                <th>Total Members</th>
                <th>Total Non-Members</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($rankedAllowances))
                @foreach ($rankedAllowances as $allowance)
                    <tr>
                        <td>{{ $allowance['allowance_name'] }}</td>
                        <td>{{ number_format($allowance['total_average'], 2) }}</td>
                        <td>{{ $allowance['rank_by_total'] }}</td>
                        <td>{{ $allowance['total_members'] }}</td>
                        <td>{{ $allowance['total_non_members'] }}</td>
                    </tr>
                @endforeach
            @endif
            
        </tbody>
    </table>

@endsection

@push('scripts')
    <script>
        console.log('Dashboard loaded.');
    </script>
@endpush
