@extends('backend.backend_template')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
          <div class="card">
            <div class="card-header">
              <h6 class="text-uppercase mb-0 d-inline-block">Create Department</h6>
              <a href="{{route('department.index')}}" class="btn btn-primary float-right"><i class="fas fa-list-ul">Department List</i> </a>
            </div>
            <div class="card-body">
                <form action="{{route('department.store')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="name">Department Name<i class="require-star">*</i></label>   
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> 
                    <div class="form-group col-4 offset-4">
                        <input type="submit" value="Save" class="form-control btn btn-primary " >
                    </div>
                </form>   
            </div>
          </div> 
        </div>
    </div>    
</div>
@endsection