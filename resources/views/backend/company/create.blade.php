@extends('backend.backend_template')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
          <div class="card">
            <div class="card-header">
              <h6 class="text-uppercase mb-0 d-inline-block">Create Company</h6>
              <a href="{{route('company.index')}}" class="btn btn-primary float-right"><i class="fas fa-list-ul">Company List</i> </a>
            </div>
            <div class="card-body">
                <form action="{{route('company.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="name">Company Name<i class="require-star">*</i></label>   
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="email">Company Email</label>   
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>   
                    <div class="form-group row">
                        <label for="address">Company Address</label>   
                        <textarea id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address">{{ old('address') }}</textarea>
                        @error('address')
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

@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    $('.league-multiple').select2();
  });
</script>
@endsection