@extends('backend.backend_template')
 @section('content')
 <div class="container">      
     <div class="row">
        @if (session('status'))
          <div class="alert alert-success col-md-6 offset-3 myalert">
              {{ session('status') }}
          </div>
        @endif
        <div class="col-lg-12 mb-4">
          <div class="card">
            <div class="card-header">
              <h6 class="text-uppercase mb-0 d-inline-block">Department List</h6>
              @role('admin')
              <a href="{{route('department.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus">Add Department</i> </a>
              @endrole
            </div>
            <div class="card-body table-responsive">
              <table class="table table-bordered" cellspacing="0">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>

               <tbody>
                @foreach($departments as $key=> $department)
                <tr>
                  <td>{{$key + $departments->firstItem()}}</td>
                  <td>{{$department->name}}</td>
                  <td>
                    @role('admin')
                      <a href="{{route('department.edit',\Crypt::encrypt($department->id))}}" class="btn btn-primary btn-sm">Edit</a>
                      <form class="d-inline" method="post"  action = 
                      "{{route('department.destroy',\Crypt::encrypt($department->id))}}" onsubmit = "return confirm('Are You Sure Want To Delete?')">
                      @csrf
                      @method('DELETE')
                      <input type="submit" value="Delete" class="btn btn-outline-danger btn-sm">
                    </form>
                    @else
                      -
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
                        @if($departments)
                            {{ $departments->render() }}
                        @endif
                    </div>
                </div>
              </div>
            </div>
          </div>
         </div>
     </div>
 </div>
@endsection