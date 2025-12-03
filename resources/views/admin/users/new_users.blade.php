@extends('admin.master_layout')
@section('content')
{{-- <!-- Main content -->
<form class="form-horizontal" action="{{ route('insert-user') }}" method="post">
  @csrf --}}
<section class="content">
<div class="container-fluid">
  <div class="row">
    <div class="col-3"></div>
    <div class="col-6" style="margin-top:20px;">
           <div class="card">
          
              <div class="row" style="padding:8px 15px;">
                <div class="col-6">
                  <div style="font-size:20px; color:#002D3E;"><b>Create New User</b></div>
                </div>
              
                <div class="col-6" style="text-align:right;">
                  <a href="{{ route('all-users') }}" class="btn btn-success btn-sm"><i class="fa fa-list"></i>&nbsp; Manage User</a>
                </div>
              </div>
              <hr>
              <!-- /.card-header -->
              <!-- form start -->

                <div class="card-body">

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-6">
                      <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-6">
                      <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Contact</label>
                    <div class="col-sm-6">
                      <input type="text" name="contact" class="form-control" value="{{ old('contact') }}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">User Type</label>
                    <div class="col-sm-4">
                      <select  class="form-control" name="user_type" id="user_type">
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-5">
                      <input type="password" class="form-control" name="password" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-5">
                      <input type="password" class="form-control" name="confirm_password" autocomplete="off" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-5">
                      <div class="custom-control custom-checkbox">
                        <input name="status" class="custom-control-input custom-control-input-success" type="checkbox" value="1" id="customCheckbox4" checked>
                        <label for="customCheckbox4" class="custom-control-label">Active</label>
                      </div>
                    </div>
                  </div> 

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-5">
                        <button type="submit" class="btn btn-info float-left">Submit</button>
                    </div>
                  </div> 


                  <hr>
              <form class="form-horizontal" action="{{ route('date-update') }}" method="post">
                @csrf
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Inv</label>
                    <div class="col-sm-6">
                      <input type="text" name="inv" class="form-control" value="" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Date</label>
                    <div class="col-sm-6">
                      <input type="text" name="cdate" class="form-control" value="" required>
                    </div>
                  </div>

                   <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-5">
                        <button type="submit" class="btn btn-info float-left">Submit</button>
                    </div>
                  </div> 

         </form>

                </div>

          
            </div>
        </div>
        <div class="col-3"></div>

      </div>
      </div>
</section>
{{-- </form> --}}

@endsection

