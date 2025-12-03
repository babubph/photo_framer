@extends('admin.master_layout')
@section('content')
<!-- Main content -->
<form class="form-horizontal" action="{{ route('update-user', $user->id) }}" method="post">
@csrf
 @method('PUT')
<section class="content">
<div class="container-fluid">
  <div class="row">
     <div class="col-3"></div>
    <div class="col-6" style="margin-top:20px;">
           <div class="card">
              <div class="card-header"  style="background-color:#343A40; color:#FFF;">
                <h3 class="card-title"><i class="fa fa-user"></i>&nbsp; Edit User</h3>
                <div class="card-tools">
                <a href="{{ route('all-users') }}" class="btn btn-success btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
                  <a href="{{ route('password-change', $user->id) }}" class="btn btn-info btn-sm"><i class="fa fa-key"></i> Change Password</a>
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-8">
                      <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-8">
                      <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Contact</label>
                    <div class="col-sm-6">
                      <input type="text" name="contact" class="form-control" value="{{ $user->contact }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">User Type</label>
                    <div class="col-sm-5">
                      <select  class="form-control" name="user_type" id="user_type">
                        <option value="Admin" @if($user->user_type == 'Admin') selected @endif>Admin</option>
                        <option value="User" @if($user->user_type == 'User') selected @endif>User</option>
                      </select>
                    </div>
                  </div>
       
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-5">
                    <button type="submit" class="btn btn-warning float-left">Update</button>
                    </div>
                  </div>

                </div>
     
              
            </div>
        </div>

      </div>
      </div>
</section>
</form>
@endsection


