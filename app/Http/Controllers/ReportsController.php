<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Employee;
use App\Models\PaidAllowance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    //
    public function monthlyAllowanceReport($month=null, $year=null)
    {
        
        $month = $month ?: Carbon::now()->month;
        $year = $year ?: Carbon::now()->year;

        // Get all allowances
        $allowances = PaidAllowance::with(['employee', 'allowance'])
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        // Group by employee and calculate the total for each allowance
        $allwancesTypes = Allowance::all();
        $report = $allowances->groupBy('employee_id')->map(function ($allowanceGroup) use($allwancesTypes) {
            // Sum up the allowances for each type
            // $food = $allowanceGroup->where('allowance_id', 1)->sum('amount'); // Food ID is assumed as 1
            // $transport = $allowanceGroup->where('allowance_id', 2)->sum('amount'); // Transport ID assumed as 2
            // $communication = $allowanceGroup->where('allowance_id', 3)->sum('amount'); // Communication ID assumed as 3
            // $childCare = $allowanceGroup->where('allowance_id', 4)->sum('amount'); // Child Care ID assumed as 4
            // $schoolFee = $allowanceGroup->where('allowance_id', 5)->sum('amount'); // School Fee ID assumed as 5

            // Loop through each allowances
            foreach ($allwancesTypes as $allowanceType) {
                $totals[$allowanceType->name] = $allowanceGroup
                    ->where('allowance_id', $allowanceType->id)
                    ->sum('amount');
            }

            // Calculate the  average
            $total = array_sum($totals); // Sum of all allowances
            $totalAverage = $total / count($totals); // Calculate the average
            return array_merge(
                ['employer_name' => $allowanceGroup->first()->employee->name],
                $totals, // Add the totals for each allowance type
                ['total_average' => $totalAverage] // Add the total average
            );
        });
        return $report;
    }


    public function yearlySalaryReport($year=null)
    {
        // dd("Emanuel");
        $year = $year ?: Carbon::now()->year;
        $employees = Employee::all();
        $allowances = PaidAllowance::whereYear('date', $year)->get();
        // dd($allowances);

        $report = $employees->map(function ($employee) use ($year, $allowances) {
            $basicSalary = rand(500000, 1700000); // Randomly generate salary

            // Filter allowances 
            $employeeAllowances = $allowances->where('employee_id', $employee->id);

            // Initialize monthly salaries
            $monthlySalaries = [];
            $totalSalary = $basicSalary;

            // Loop through each month
            for ($month = 1; $month <= 12; $month++) {
                // Sum of allowances 
                $monthlyAllowance = $employeeAllowances->filter(function ($allowance) use ($month) {
                    return Carbon::parse($allowance->date)->month == $month;
                })->sum('amount');

                // (Basic salary + allowances)
                $monthlySalaries[Carbon::createFromFormat('m', $month)->format('M')] = $monthlyAllowance;
                $totalSalary += $monthlyAllowance;
            }

            // Calculate the average salary for the employee
            $averageSalary = $totalSalary / 12;

            return [
                'employer_name' => $employee->name,
                'monthly_salaries' => $monthlySalaries,
                'basic_salary' => $basicSalary,
                'total_salary' => $totalSalary,
                'average_salary' => $averageSalary,
                'gender' => $employee->gender, // Store gender for ranking by gender
            ];
        });

        // dd($report);

        // Sort 
        $sortedReport = $report->sortByDesc('average_salary');

        // Rank employees by gender :TODO
        $rankByGender = $report->groupBy('gender')->map(function ($group) {
            return $group->sortByDesc('average_salary');
        });

        return $sortedReport;
    }


    public function generateAnnualAllowanceReport($year=null)
    {
        // If no year is provided, set it to the current year
        $year = $year ?: Carbon::now()->year;

        // Fetch all the allowances for the given year
        $paidAllowances = PaidAllowance::whereYear('date', $year)->get();

        // Get all allowances (e.g., Food, Transport, etc.)
        $allowances = Allowance::all();

        // Prepare the report data
        $reportData = $allowances->map(function ($allowance) use ($paidAllowances, $year) {
            // Get all paid allowances for the current allowance type (Food, Transport, etc.)
            $allowancePaid = $paidAllowances->where('allowance_id', $allowance->id);

            // Calculate total allowance paid for the year
            $totalAmount = $allowancePaid->sum('amount');
            
            // Calculate total members and total non-members for the allowance
            $totalMembers = $allowancePaid->unique('employee_id')->count();
            $totalNonMembers = Employee::count() - $totalMembers;

            // Calculate the average allowance for this category
            $totalTransactions = $allowancePaid->count();
            $averageAmount = $totalTransactions > 0 ? $totalAmount / $totalTransactions : 0;

            return [
                'allowance_name' => $allowance->name,
                'total_amount' => $totalAmount,
                'total_average' => $averageAmount,
                'rank_by_total' => 0, // Will calculate after sorting
                'total_members' => $totalMembers,
                'total_non_members' => $totalNonMembers,
            ];
        });

        // Sort the data by total amount in descending order
        $sortedReport = $reportData->sortByDesc('total_amount');

        // Assign rank based on total amount in descending order
        $sortedReport = $sortedReport->map(function ($item, $index) {
            $item['rank_by_total'] = $index + 1;
            return $item;
        });

        return $sortedReport;
    }
}
