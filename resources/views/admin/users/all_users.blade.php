@extends('admin.master_layout')

@section('content')

<style>
  table th {
    border: solid 1px #818181;
    background-color: #002D3E;
    color: #FFF;
}
</style>
<!-- Main content -->
<section class="content">
<div class="container-fluid">
<div class="row">
  <div class="col-1"></div>
  <div class="col-10" style="margin-top:20px;">

    <div class="">
      <div class="">
      <div class="row" style="padding-bottom:15px;">
        <div class="col-6">
           <div style="font-size:20px; color:#002D3E;"><b>Manage  All Users</b></div>
        </div>
      
        <div class="col-6" style="text-align:right;">
          <a href="{{ route('new-users') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp; Add New User</a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <table class="table table-hover table-striped nowrap">
          <thead>
            <tr>
              <th>SL</th>
              <th>User Name</th>
              <th>Email</th>
              <th>Contact</th>
              <th>User Type</th>
              <th>Created</th>
              <th>Status</th>
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>

            @foreach ($user as $users)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>
                <div style="color:#002D3E;">
                  <b>{{ $users->name }}</b>
                  @if ($users->id == auth()->user()->id)
                     &nbsp;&nbsp;<i class="fa fa-user"></i>
                  @else
                      <i class=""></i>
                  @endif
                </div>
              </td>
              <td>{{ $users->email }}</td>
              <td>{{ $users->contact }}</td>
              <td>
          
                @if($users->user_type == "Admin")
                <div style="font-size:16px; color:#097D2C;"><b>Admin</b></div>
                @elseif($users->user_type == "School")
                <div style="font-size:16px; color:#9E0E1A;"><b>School</b></div>
                @else 
                <div style="font-size:16px; color:#002D3E;"><b>User</b></div>
                @endif
              </td>
              <td>{{ $users->created_at }}</td>
              <!-- <td>{{ $users->status == 1 ? 'Active' : 'Inactive' }}</td> -->
              <td>
                @if ($users->id == auth()->user()->id)
                  <button id="btn_active"  class="btn btn-success btn-xs"><i class="fa fa-check"></i>&nbsp; Active</button>
                @else
                  @if ($users->status == 1)
                    <form action="{{ route('user-inactive', $users->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-check"></i>&nbsp; Active</button>
                    </form>
                  @else
                        <form action="{{ route('user-active', $users->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-times"></i>&nbsp; Inactive</button>
                        </form>
                  @endif
                @endif
              </td>
              <td class="text-right">

                <div class="row">
                  <div class="col-9 text-right">
                    <a href="{{ route('edit-user', $users->id) }}" class="btn btn-warning btn-xs">Edit</a>
                  </div>
                  <div class="col-3">
                    @if ($users->id == auth()->user()->id)
                      <button id="btn_delete" class="btn btn-danger btn-xs" >Delete</button>
                    @else
                      <form action="{{ route('delete-user', $users->id) }}" method="post">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-xs" onClick="return confirmation()">Delete</button>
                     </form>
                   @endif
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
            <tr>
              <td colspan="8"><div>Total user: <b> {{ $user->count() }}</b> user</div></th>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
 <div class="col-1"></div>
</div>
</section>
<script type="text/javascript">
      function confirmation() {
       return confirm('Are you sure you want to Delete this?');
        }
 </script>

 <script>
        $(document).ready(function () {
            $("#btn_active").click(function () {
                alert("You cannot Inactive yourself");
            });
        });

        $(document).ready(function () {
            $("#btn_delete").click(function () {
                alert("You cannot Delete yourself");
            });
        });
    </script>
@endsection


@section('footer')
  @parent
@endsection
