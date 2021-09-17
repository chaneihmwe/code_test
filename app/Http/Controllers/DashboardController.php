<?php

namespace App\Http\Controllers;

use App\Company;
use App\Department;
use App\Employee;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $company_count = Company::all()->count();
        $employee_count = Employee::all()->count();
        $department_count = Department::all()->count();
    	return view('backend.dashboard', compact('company_count', 'employee_count', 'department_count'));
    }
}
