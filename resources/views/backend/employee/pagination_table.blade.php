
<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-bordered" cellspacing="0">
            <thead>
                <tr>
                <th>No</th>
                <th>Name</th>
                <th>Company</th>
                <th>Departments</th>
                <th>StaffId</th>
                <th>Action</th>
                </tr>
            </thead>

            <tbody>
            @foreach($employees as  $key => $employee)
            <tr>
                <td>{{$key + $employees->firstItem()}}</td>
                <td>{{$employee->user->user_name}}</td>
                <td>{{$employee->company->name}}</td>
                <td class="align-middle">
                @foreach($employee->departments as $department)
                    <span class="badge badge-info">{{$department->name}}</span>
                @endforeach
                </td>
                <td>{{$employee->staffId}}</td>
                <td>
                @role('admin')
                    <a href="{{route('employee.edit',\Crypt::encrypt($employee->id))}}" class="btn btn-primary btn-sm">Edit</a>
                    <form class="d-inline" method="post"  action = 
                        "{{route('employee.destroy',\Crypt::encrypt($employee->id))}}" onsubmit = "return confirm('Are You Sure Want To Delete?')">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" class="btn btn-outline-danger btn-sm">
                    </form>
                @else - 
                @endrole
                </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Card footer -->
    <div class="card-footer py-4">
        <div class="row">
            <div class="col-12">
                <div class=" float-right">
                    @if($employees)
                        {{ $employees->render() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @php $company_id = null; $department_id = null; $name = null; $staff_id = null; 
    if(isset($filter_arr)){
       $company_id = $filter_arr['company_id']; 
       $department_id = $filter_arr['department_id']; 
       $name = $filter_arr['name']; 
       $staff_id = $filter_arr['staff_id']; 
    }
    @endphp
    
    <input type="hidden" name="" class="filter" data-company-id="{{$company_id}}" data-department-id="{{$department_id}}" data-name="{{$name}}" data-staff-id="{{$staff_id}}">