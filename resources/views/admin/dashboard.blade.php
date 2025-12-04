@extends('admin.master_layout')
@section('content')

@push('scripts')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin_assets/data_table_custom_style.css')}}">


@endpush

<style>

</style>
 
 <!-- Main content -->
 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-2"></div>
          <div class="col-8">
            

            <div class="card" style="margin-top:10px;">
              <div class="card-header">
                <table style="width:100%">
                  <tr>
                    <td><h2>Total Uploaded Photo:<b> {{ $photos->count(); }}</b></h2></td>
                    <td style="text-align:center;">
                           <a href="{{ route('new-frame') }}" class="btn btn-info">
                            <i class="fa fa-plus"></i>&nbsp; Add New Frame
                          </a>
                    </td>
                  </tr>
                </table>

                   @if(session('message'))
                        <div class="alert alert-{{ session('msg_type') == 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                  
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>SL</th>
                    <th>Photo</th>
                    <th>Date</th>
                    <th style="text-align: right">Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($photos as $photo)  
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td> <img src="{{ asset('images/upload/' . $photo->photo) }}" alt="image" width="100"></td>
                        <td>{{ $photo->cdate }}</td>
                        <td style="text-align: right">
                            <a href="{{ url('images/upload/' . $photo->photo) }}" target="blank" class="btn btn-info btn-sm">View Photo</a>&nbsp;&nbsp;&nbsp;
                            <a class="btn btn-danger btn-sm" href="{{ route('delete-photo', $photo->id) }}" onClick="return confirmation()">Delete</a> 
                        </td>
                    </tr>
                    @endforeach
                    </tbody>

                </table>
             
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-2"></div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@push('js_scripts')
<!-- DataTables  & Plugins -->
<script src="{{asset('admin_assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('admin_assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('admin_assets/data_table_custom_script.js')}}"></script>

  <script type="text/javascript">
        function confirmation() {
        return confirm('Are you sure you want to Delete this?');
          }
  </script>

@endpush

@endsection
