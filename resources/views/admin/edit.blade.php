@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <u><h1 style="color:Blue"><center>Edit UserData</center></h1></u>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="Home.php">Home</a></li>
            </ol>
          </div>
        </div>
      </div>
    </section>
@include('flash-message') 
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit user</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {{-- @if($errors->any())
              <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
              </ul>
              @endif --}}
              
              <form method="post" action="{{route('user.update',$userarray->id)}}" enctype="multipart/form-data">
              @method('PATCH')
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">User Name:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="exampleInputEmail1" value="{{$userarray->name}}" placeholder="Enter Product Name" >
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">User Email:</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="exampleInputEmail1" value="{{$userarray->email}}" placeholder="Enter Author Name" >
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email Verified at:</label><br/>
                    {{-- <textarea name="bookDetails" rows="3" cols="65" placeholder="Enter Book Details" readonly>{{$userarray->email_verified_at}}</textarea>  --}}
                    <input type="text" class="form-control" name="email_verified_at" id="exampleInputEmail1" readonly value="{{$userarray->email_verified_at}}"> 
                  </div>
                  
                  <div class="form-group">
                         <label for="exampleInputPassword1">User Type:</label>
                    <input type="text" class="form-control" name="user_type" id="exampleInputPassword1" readonly value="{{$userarray->user_type}}" placeholder="Enter Price" required="true">
                  </div>
                   
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" name="updatebtn">Update user</button>
                    {{-- <button type="reset" class="btn btn-primary" >Reset</button> --}}
                </div>
              </form>
            </div>
          </div>
      </section>
    <!-- /.content -->
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>  
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
@endsection