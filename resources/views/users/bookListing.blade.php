@extends('layouts.userMaster')
 @section('content')
{{--<div class="ads-grid">  --}}
	<div class="container">
		<!-- tittle heading -->
		<h3 class="tittle-w3l">Our Books
			<span class="heading-style">
				<i></i>
				<i></i>
				<i></i>
			</span>
		</h3> 
<!-- banner -->
<div>
        <center><img src="/images/background2.png" alt="libraryhome"  ></center>             
</div>
<!-- product right -->
			@include('flash-message')
			  <center><div class="agileinfo-ads-display col-md-9"></center>
				<div class="wrapper">
					<!-- first section (nuts) -->
					<div class="product-sec1">
						<h3 class="heading-tittle">Books</h3>
						@foreach ($bookarray as $book)
					
						<div class="col-md-4 product-men">
							{{-- @foreach ($bookarray as $book) --}}
							<div class="men-pro-item simpleCart_shelfItem">
								<div class="men-thumb-item">
									<img src="{{url('images/'.$book->bookImage)}}" alt="" width="200" height="250">
									<div class="men-cart-pro">
										<div class="inner-men-cart-pro"> 
											 <a href="{{url('/users/bookdetails',$book->bookId)}}" class="link-product-add-cart">View Details</a> 
										 </div>
									</div>
									<span class="product-new-top">New</span>
								</div>
								<div class="item-info-product ">
									<h4>Name:
										<b>{{$book->bookName}}</b>
										 {{-- <a href="single.html">Almonds, 100g</a>  --}}
									</h4>
									<div class="info-product-price">
										<span >Price:<b>{{$book->bookPrice}}Rs</b></span>
										{{-- <del>$280.00</del> --}}
									</div>
									@if($book->bookQty<=0)
									<div><h3><b>Out of Stock</b></h3></div>
									@else
									{{-- <a href="/users/bookdetails/{id}" >View Details</a> --}}
									<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
										<form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
											@csrf
											<input type="hidden" value="{{ $book->bookId }}" name="id">
											<input type="hidden" value="{{ $book->bookName }}" name="name">
											<input type="hidden" value="{{ $book->bookPrice }}" name="price">
											<input type="hidden" value="{{ 'images/'.$book->bookImage }}"  name="image">
											<input type="hidden" value="1" name="quantity">
											<button class="btn btn-primary">Add To Cart</button>
										</form>
									</div>
									@endif
								</div>
							</div>
						</div> 
						
						@endforeach 
						<div class="clearfix"></div>
					</div>  

			<!-- special offers -->
	
	<div class="featured-section" id="projects">
		<div class="container">
			<!-- tittle heading -->
			<h3 class="tittle-w3l">Special Offers
				<span class="heading-style">
					<i></i>
					<i></i>
					<i></i>
				</span>
			</h3>
			<!-- //tittle heading -->
			<div class="content-bottom-in">
				<ul id="flexiselDemo1">
					 @foreach($specialbooks as $book) 
					 <li>
						<div class="w3l-specilamk">
							<div class="speioffer-agile">
								<a href="single.html">
									<img src="{{url('images/'.$book->bookImage)}}" alt="">
								</a>
							</div>
							<div class="product-name-w3l">
								<h4>{{$book->bookName}}
									 <a href="single.html">Aashirvaad, 5g</a>
								 </h4>
								<div class="w3l-pricehkj">
									<h6>{{$book->bookPrice}}</h6>
									<p>Save $40.00</p>
								</div>
								@if($book->bookQty<=0)
								<div><h3><b>Out of Stock</b></h3></div>
								@else
								<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
									<form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
										@csrf
										<input type="hidden" value="{{ $book->bookId }}" name="id">
										<input type="hidden" value="{{ $book->bookName }}" name="name">
										<input type="hidden" value="{{ $book->bookPrice }}" name="price">
										<input type="hidden" value="{{ 'images/.$book->bookImage '}}"  name="image">
										<input type="hidden" value="1" name="quantity">
										<button class="btn btn-primary">Add To Cart</button>
									</form>
								</div>
								@endif
							</div>
						</div>
					</li>
					@endforeach 
					
@endsection