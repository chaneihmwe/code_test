@extends('backend.backend_template')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h6 class="text-uppercase mb-0 d-inline-block">Create Employee</h6>
              <a href="{{route('employee.index')}}" class="btn btn-primary float-right"><i class="fas fa-list-ul">Employee List</i> </a>
            </div>
            <div class="card-body">
                <form action="{{route('employee.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">                       
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="date">First Name<i class="require-star">*</i></label>   
                            <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="date">Last Name<i class="require-star">*</i></label>   
                            <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group row">                       
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="company">Company:<i class="require-star">*</i></label>
                            <select class="form-control" id="company" name="company_id">
                                <option disabled>Choose Company</option>
                                @foreach($companies as $row)
                                <option value="{{$row->id}}" {{(old('company_id') == $row->id) ? 'selected' : ''}}>{{$row->name}}</option>
                                @endforeach
                            </select>
                            <div class="form-control-feedback text-danger"> {{$errors->first('company_id') }} </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group custom-control custom-control-alternative custom-checkbox">
                                <label for="name">Department<i class="require-star">*</i></label>   
                                    <div class="row">
                                        @foreach($departments as $department)
                                            <div class="custom-control custom-control-alternative custom-checkbox">
                                                <input class="custom-control-input" id="{{$department->id}}" type="checkbox" name="departments[]" value="{{$department->id}}"
                                                @php
                                                    if(count((array)old('departments'))>0)
                                                        if(in_array($department->id, old('departments'))) echo 'checked'
                                                @endphp
                                                >
                                                <label class="custom-control-label" for="{{$department->id}}">{{$department->name}} &nbsp;&nbsp;&nbsp;</span> </label>
                                            </div>
                                        @endforeach
                                    </div>
                                
                                <div class="form-control-feedback text-danger"> {{$errors->first('departments') }} </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="email">Email:<i class="require-star">*</i></label>   
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            @php 
                                $passwords = \App\Helper\General::generatePassword();
                            @endphp
                            <label for="password">Password:<i class="require-star">*</i></label>   
                            <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') ? old('password') : $passwords }}" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>  
                    <div class="form-group row">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="phone">Phone:<i class="require-star">*</i></label>   
                            <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="address">Address</label>   
                            <textarea name="address" class="form-control" id="address" rows="2">{{ old('address') }}</textarea>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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
