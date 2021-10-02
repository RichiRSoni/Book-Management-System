@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Employee Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Add Salary</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@include('flash-message')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Employee details</h3>
                    </div>
                    {{-- @if(session()->get('success'))
                {{session()->get('success')}}
             @endif --}}
                    <!-- /.card-header -->
                    <div class="card-body" style="overflow-x: scroll;">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Email verified at</th>
                                <th>User Type</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th >Edit</th>
                                <th>Delete</th>
                             </tr>
                              </thead>
                              <tbody>
                                  @foreach ($usersarray as $user)
                                  <tr>
                                      <td>{{$user->id}}</td>
                                      <td>{{$user->name}}</td>
                                      <td>{{$user->email}}</td>
                                      <td>{{$user->email_verified_at}}</td>
                                      <td>{{$user->user_type}}</td>
                                      <td>{{$user->created_at}}</td>
                                      <td>{{$user->updated_at}}</td>
                                      <td><a href="{{ route('user.edit',$user->id)}}" class="btn btn-primary">Edit</a></td>
                                      <td>
                                          <form action="{{ route('user.destroy',$user->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure to delete this?')">Delete</button>

                                          </form>
                                      </td> 
                                  </tr>
                                      
                                  @endforeach
                              </tbody>
                              <tfoot>
                                  
                              </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>    
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    });
  </script>

@endsection