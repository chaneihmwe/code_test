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
              <h6 class="text-uppercase mb-0 d-inline-block">Employee List</h6>
              @role('admin')
                <a href="{{route('employee.create')}}" class="btn btn-primary float-right"><i class="fas fa-plus">Add Employee</i> </a>
              @else - 
              @endrole
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                  <label for="company">Company</label>
                    <select class="form-control company_id" id="company" name="company_id">
                        <option value="">Choose Company</option>
                        @foreach($companies as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                  <label for="department">Department</label>
                    <select class="form-control department_id" id="department" name="department_id">
                        <option value="">Choose Department</option>
                        @foreach($departments as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                  <label for="name">Name</label>   
                  <input type="text" name="name" id="name" class="form-control name" value="{{ old('name') }}">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                  <label for="staff_id">Staff ID</label>   
                  <input type="text" name="staff_id" id="staff_id" class="form-control staff_id" value="{{ old('staff_id') }}">
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                  <label for="staff_id">CSV File</label>   
                  <input type="file" name="csv_file" id="csv_file" class="csv_file" value="{{ old('csv_file') }}">
                  <!-- Error -->
                  <p class='mt-2 d-none text-danger' id="err_csv_file"></p>
                </div>
                <div class="col-12 col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                  <label for="staff_id">&nbsp;</label>   
                  <button class="form-control btn btn-primary search">Search</button>
                </div>
              </div>
            </div>
            <div class="card-body" id="table-data">
              @include('backend.employee.pagination_table')
            </div>
         </div>
     </div>
 </div>
@endsection
@section('script')
  <script type="text/javascript">
    $(document).ready(function (argument) {
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.search' ,function (argument) {
            let company_id = $('.company_id').val();
            let department_id = $('.department_id').val();
            let name = $('.name').val();
            let staff_id = $('.staff_id').val();

            //CSV
            let files = $('.csv_file')[0].files;
            if(files.length > 0){
              let csv_file = new FormData();
              csv_file.append('csv_file',files[0]);
              getEmployeesByCSV(csv_file, 1)
            }else {
              getEmployees(company_id, department_id, name, staff_id, 1)
            }
        })

        $(document).on('click', '.pagination a', function(event){
          if ($('.card-footer').hasClass('ajax')) {
            event.preventDefault(); 
            let page = $(this).attr('href').split('page=')[1];
            let company_id = $('.filter').data('company-id')
            let department_id = $('.filter').data('department-id')
            let name = $('.filter').data('name')
            let staff_id = $('.filter').data('staff-id')
            getEmployees(company_id, department_id, name, staff_id, page)
          }
        })

        function getEmployees(company_id, department_id, name, staff_id, page){
          let url="employee?page="+page;
            $.ajax({
              type:'GET',
              url: url,
              data: {company_id: company_id, department_id: department_id, name: name, staff_id: staff_id} ,
              success: (data) => {
                $('#table-data').html(data)
                $('.card-footer').addClass('ajax');
              }
          });
        }

        function getEmployeesByCSV(csv_file, page){
          let url="get-employee?page="+page;
            $.ajax({
              type:'POST',
              url: url,
              data: csv_file,
              contentType: false,
              processData: false,
              success: (response) => {
                $('#err_csv_file').removeClass('d-block');
                $('#err_csv_file').addClass('d-none');
                  $('#table-data').html(response)
                  $('.card-footer').addClass('ajax');
                  $('.card-footer').addClass('csv');
                if(response.error){
                  $('#err_csv_file').text(response.error);
                  $('#err_csv_file').removeClass('d-none');
                  $('#err_csv_file').addClass('d-block');
                } 
              }
          });
        }
    })
  </script>
@endsection