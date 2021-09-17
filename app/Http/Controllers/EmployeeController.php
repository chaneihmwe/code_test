<?php
namespace App\Http\Controllers;

use App\Company;
use App\Department;
use Illuminate\Http\Request;
use App\Employee;
use App\Helper\General;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(Request $request) 
    {   
        $companies = Company::all();
        $departments = Department::all();
        if ($request->ajax()) {
            $filter_arr = [];
            $company_id = $request->company_id;
            $department_id = $request->department_id;
            $name = $request->name;
            $staff_id = $request->staff_id;
            $filter_arr['company_id'] = $company_id;
            $filter_arr['department_id'] = $department_id;
            $filter_arr['name'] = $name;
            $filter_arr['staff_id'] = $staff_id;
            $employees = General::search($company_id, $department_id, $name, $staff_id);
            return view('backend.employee.pagination_table', compact('employees', 'companies', 'departments', 'filter_arr'))->render();
        }else {
            $employees = Employee::orderBy('id','desc')->paginate(10);
            return view('backend.employee.index', compact('employees', 'companies', 'departments'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $companies = Company::all();
        $departments = Department::all();
        return view('backend.employee.create', \compact('companies','departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "first_name" => "required|max:50",
            "last_name" => "required|max:50",
            "email" => "required|unique:users|max:255",
            "password" => "required|min:8|max:255",
            "company_id" => "required",
            "departments" => "required",
            "phone" => "required|max:30",
        ]);
        DB::beginTransaction();
            try {
                $user = new User();
                $user->user_name = $request->first_name . " $request->last_name";
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->role = 'employee';
                $user->save();
            } catch(Exception $e) {
                DB::rollback();
                return  redirect()->back()->with('status', "You can't add employee into your data");
            }
            try {
                if ($user->id) {
                    $latest_employee = Employee::latest()->first();
                    $staffId = $latest_employee ? 'STF-'. ($latest_employee->id + 1) : 'STF-1';

                    $employee = new Employee();
                    $employee->first_name = $request->first_name;
                    $employee->last_name = $request->last_name;
                    $employee->user_id = $user->id;
                    $employee->company_id = $request->company_id;
                    $employee->phone = $request->phone;
                    $employee->staffId = $staffId;
                    $employee->address = $request->address;
                    $employee->save();

                    if($employee->id) {
                        foreach ($request->departments as $key => $value) {
                            $employee->departments()->attach($value);
                        }
                    }
                }
            } catch(Exception $e){
                DB::rollback();
                return redirect()->back()->with('status', "You can't add employee into your data");
            }
        DB::commit();
        return redirect()->route('employee.index')->with('status','New Employee is added into your data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find(\Crypt::decrypt($id));
        $companies = Company::all();
        $departments = Department::all();
        $user_departments = [];
        foreach ($employee->departments as $value) {
            array_push($user_departments, $value->id);
        }
        return view('backend.employee.edit',compact('employee','companies', 'departments', 'user_departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "first_name" => "required|max:50",
            "last_name" => "required|max:50",
            "company_id" => "required",
            "departments" => "required",
            "phone" => "required|max:30",
        ]);
        $employee = Employee::find(\Crypt::decrypt($id));
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->company_id = $request->company_id;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->save();
        $employee->departments()->sync($request->departments);
        
        $user = User::find($employee->user_id);
        $user->user_name = $employee->first_name . " $employee->last_name";
        $user->save();

        return redirect()->route('employee.index')->with('status','Existing Employee is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find(\Crypt::decrypt($id));         
        $employee->delete();
        return redirect()->route('employee.index')->with('status','Existing Employee is deleted from your data');
    }

    public function employeesByCSV(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|min:csv|max:2048'
        ]);
        if ($validator->fails()) {
            $data['success'] = 0;
            $data['error'] = $validator->errors()->first('csv_file');
            return response()->json($data);
        }else {
            if ($request->file('csv_file')) {
                $csv_file = $request->file('csv_file');
                $path = $request->file('csv_file')->getRealPath();
                $data = array_map('str_getcsv', file($path));
                $csv_data = array_slice($data, 0, 2);
                array_shift($csv_data);
                $companies = Company::all();
                $departments = Department::all();
                foreach ($csv_data as $value) {
                    $filter_arr = [];
                    $company_id = $value[0];
                    $department_id = $value[1];
                    $name = $value[2];
                    $staff_id = $value[3];
                    $filter_arr['company_id'] = $company_id;
                    $filter_arr['department_id'] = $department_id;
                    $filter_arr['name'] = $name;
                    $filter_arr['staff_id'] = $staff_id;
                }
                $employees = General::search($company_id, $department_id, $name, $staff_id);
                return view('backend.employee.pagination_table', compact('employees', 'companies', 'departments', 'filter_arr'))->render();
            }
        }
    }
}
