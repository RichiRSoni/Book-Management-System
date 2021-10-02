@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <u><h1 style="color:Blue"><center>Add Book</center></h1></u>
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
                <h3 class="card-title">Add Book</h3>
                <div style="text-align: right">
                  <a href="{{url('admin/book')}}" class="btn btn-success" >View Book</a> 
                </div>
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
              
              <form method="post" action="{{route('book.store')}}" name="form" enctype="multipart/form-data">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Book Name:</label>
                    <input type="text" class="form-control @error('bookName') is-invalid @enderror" name="bookName" id="exampleInputEmail1" value="{{old('bookName')}}" placeholder="Enter Product Name" >
                    @error('bookName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Author Name:</label>
                    <input type="text" class="form-control @error('bookAuthor') is-invalid @enderror" name="bookAuthor" id="exampleInputEmail1" value="{{old('bookAuthor')}}" placeholder="Enter Author Name" >
                    @error('bookAuthor')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Book Details:</label><br/>
                    <textarea name="bookDetails" class="form-control @error('bookDetails') is-invalid @enderror" rows="3" cols="65"  placeholder="Enter Book Details" >{{old('bookDetails')}}</textarea> 
                    @error('bookDetails')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
        
                  <div class="form-group">
                    <label for="exampleInputPassword1">Book price:</label>
                    <input type="text" class="form-control @error('bookPrice') is-invalid @enderror" name="bookPrice" id="exampleInputPassword1" value="{{old('bookPrice')}}" placeholder="Enter Price" >
                    @error('bookPrice')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                   <div class="form-group">
                    <label for="exampleInputPassword1">Quantity:</label>
                    <input type="int" class="form-control @error('bookQty') is-invalid @enderror" name="bookQty" id="exampleInputPassword1" value="{{old('bookQty')}}" placeholder="Enter Quantity number" >
                    @error('bookQty')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="custom-file">
                    <label for="exampleInputPassword1">Book Image:</label>
            
                    <input type="file" name="bookImage" class="form-control @error('bookImage') is-invalid @enderror" value="{{old('bookImage')}}"  id="exampleInputPassword">
                  @error('bookImage')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div><br/>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" name="addbtn">Add Book</button>
                    <button type="reset" class="btn btn-primary" onclick="window.location='{{url('/admin/book/create')}}'">Reset</button>
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