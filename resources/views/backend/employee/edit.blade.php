@extends('backend.backend_template')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h6 class="text-uppercase mb-0 d-inline-block">Edit Employee</h6>
              <a href="{{route('employee.index')}}" class="btn btn-primary float-right"><i class="fas fa-list-ul">Match List</i> </a>
            </div>
            <div class="card-body">  
                <form action="{{route('employee.update', \Crypt::encrypt($employee->id))}}" method="post" enctype="multipart/form-data">
                     @csrf
                    @method('PUT')
                    <div class="form-group row">                       
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="date">First Name<i class="require-star">*</i></label>   
                            <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ $employee->first_name }}" required>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="date">Last Name<i class="require-star">*</i></label>   
                            <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ $employee->last_name }}" required>
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
                                    <option value="{{$row->id}}" {{ ($employee->company_id == $row->id) ? 'selected' : '' }}>{{$row->name}}</option>
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
                                                <input class="custom-control-input" id="{{$department->id}}" type="checkbox" name="departments[]" value="{{$department->id}}"  @php
                                                    if (in_array($department->id, $user_departments))
                                                    echo "checked";
                                                @endphp>
                                                <label class="custom-control-label" for="{{$department->id}}">{{$department->name}} &nbsp;&nbsp;&nbsp;</span> </label>
                                            </div>
                                        @endforeach
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="phone">Phone:<i class="require-star">*</i></label>   
                            <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $employee->phone }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <label for="address">Address</label>   
                            <textarea name="address" class="form-control" id="address" rows="2">{{ $employee->address }}</textarea>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>   

                    <div class="form-group col-4 offset-4">
                        <input type="submit" value="Save" class="form-control btn btn-primary">
                    </div>
                </form> 
            </div>
          </div>
        </div>
    </div>  
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready( function () {

            $("input:checkbox[name='home_team_check']").click(function(){
            if($(this).prop("checked") == true){
                    $('.home_team_name').removeClass('d-none')
                }
                else if($(this).prop("checked") == false){
                    $('.home_team_name').addClass('d-none')
                }
            });


            $("input:checkbox[name='away_team_check']").click(function(){
            if($(this).prop("checked") == true){
                    $('.away_team_name').removeClass('d-none')
                }
                else if($(this).prop("checked") == false){
                    $('.away_team_name').addClass('d-none')
                }
            });
    } );
    </script>
@endsection