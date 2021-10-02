@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
         <u><h1 style="color:Blue"><center>Book Data Details</center></h1></u>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">DataTables</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
@include('flash-message')
{{-- @if(session()->get('success'))
    {{session()->get('success')}}
@endif  --}}
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Book details</h3>
            <div style="text-align: right">
              <a href="{{url('admin/book/create')}}" class="btn btn-primary" >Add Book</a> 
            </div>
          </div>
          
             
          <!-- /.card-header -->
          <div class="card-body">
            {{-- <table id="example" class="table table-bordered table-striped"> --}}
              <table id="example" class="table table-striped table-bordered" style="width:100%"> 
              <thead>
              <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Author</th> 
                    <th>Details</th> 
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Image</th>
                    <th>created at</th>
                    <th>updated at</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    {{-- <th colspan="2">Action</th> --}}
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($bookarray as $book)
                  <tr>
                  <td>{{$book->bookId}}</td>
                  <td>{{$book->bookName}}</td>
                  <td>{{$book->bookAuthor}}</td>
                  <td>{{$book->bookDetails}}</td>
                  <td>{{$book->bookPrice}}</td>
                  <td>{{$book->bookQty}}</td>
                  {{-- <td><img src="{{url('imageOfBooks/'.$book->bookImage)}}" height="100px" width="100px"></td> --}}
                  <td><a href="{{url('images/'.$book->bookImage)}}"  data-lightbox='image-1' data-title='My caption' ><img src="{{url('images/'.$book->bookImage)}}"  height='80px' width='100px' data-fancybox='gallery' ></td>
                  <td>{{$book->created_at}}</td>
                  <td>{{$book->updated_at}}</td>
                  <td><a href="{{route('book.edit',$book->bookId)}}" class="btn btn-primary">Edit</td>
                  <td>
                  <form action="{{route('book.destroy',$book->bookId)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure to delete this?')">Delete</button>
                  </form>
                  </td>
                  </tr>
                  @endforeach
                  
                  </tbody>
                  <tfoot></tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>    
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../Lightbox/css/lightbox.css"> 
  <script type="text/javascript" src="../Lightbox/lightbox-plus-jquery.js"></script>
  <script type="text/javascript" src="../Lightbox/lightbox-plus-jquery.min.js"></script>
  
  <script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>
</body>
</html>
@endsection
