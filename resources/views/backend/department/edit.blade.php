@extends('backend.backend_template')
@section('content')
<div class="container ">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
          <div class="card">
            <div class="card-header">
              <h6 class="text-uppercase mb-0 d-inline-block">Edit Department</h6>
              <a href="{{route('department.index')}}" class="btn btn-primary float-right"><i class="fas fa-list-ul">Team List</i> </a>
            </div>
            <div class="card-body">       
                <form method="post" action="{{ route('department.update',\Crypt::encrypt($department->id))}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label for="name">Team Name<i class="require-star">*</i></label>   
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $department->name }}" required autocomplete="title" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>   
                    <div class="form-group col-4 offset-4">
                        <input type="submit" value="Update" class="form-control btn btn-primary">
                    </div>
                </form>
            </div>
          </div>
        </div>
    </div>  
</div>
@endsection