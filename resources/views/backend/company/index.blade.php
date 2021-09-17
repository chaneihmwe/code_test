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
              <h6 class="text-uppercase mb-0 d-inline-block">Company List</h6>
              @role('admin')
                <a href="{{route('company.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus">Add Company</i> </a>
              @endrole 
            </div>
            <div class="card-body table-responsive">
              <table class="table table-bordered" cellspacing="0">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Company Name</th>
                  <th>Company Email</th>
                  <th>Company Address</th>
                  <th>Action</th>
                </tr>
              </thead>

               <tbody>
                @foreach($companies as $key=> $company)
                <tr>
                  <td>{{$key + $companies->firstItem()}}</td>
                  <td>{{$company->name}}</td>
                  <td>{{ $company->email ? $company->email : '-' }}</td>
                  <td>{{ $company->address ? $company->address : '-' }}</td>
                  <td>
                  @role('admin')
                    <a href="{{route('company.edit',\Crypt::encrypt($company->id))}}" class="btn btn-primary btn-sm">Edit</a>
                    <form class="d-inline" method="post"  action = 
                    "{{route('company.destroy',\Crypt::encrypt($company->id))}}" onsubmit = "return confirm('Are You Sure Want To Delete?')">
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
                        @if($companies)
                            {{ $companies->render() }}
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