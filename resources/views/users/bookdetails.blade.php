@extends('layouts.userMaster')
@section('content')
<div class="container py-xl-4 py-lg-2">
	<!-- tittle heading -->
	<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
		<span>P</span>roduct
		<span>D</span>etails</h3>
{{-- <div>
	<center><img src="/images/background2.png" alt="libraryhome"  ></center>             
</div> --}}

	<!-- Single Page -->
	<div class="banner-bootom-w3-agileits py-5">
		{{-- <div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span>P</span>roduct
				<span>D</span>etails</h3> --}}
			<!-- //tittle heading -->
			<div class="row">
				<div class="col-lg-5 col-md-8 single-right-left ">
					<div class="grid images_3_of_2">
						<div class="flexslider">
							<ul class="slides">
								<li data-thumb="images/si1.jpg">
									<div class="thumb-image">
										<img src="{{url('images/'.$bookarray->bookImage)}}" data-imagezoom="true" class="img-fluid" alt="" width=300 height=300>
							
										</div>
								</li>
								
							</ul>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<div class="col-lg-7 single-right-left simpleCart_shelfItem">
					<h3 class="mb-3">Title:{{$bookarray->bookName}}</h3>
					<p class="mb-3">
						<span class="item_price">Price: {{$bookarray->bookPrice}}Rs</span>
						<del class="mx-2 font-weight-light">$280.00</del>
						<label>Free delivery</label>
					</p>
					<div class="single-infoagile">
						<ul>
							<li class="mb-3">
								Cash on Delivery Eligible.
							</li>
							<li class="mb-3">
								Shipping Speed to Delivery.
							</li>
							<li class="mb-3">
								EMIs from $655/month.
							</li>
							<li class="mb-3">
								Bank OfferExtra 5% off* with Axis Bank Buzz Credit CardT&C
							</li>
						</ul>
					</div>
					<div class="product-single-w3l">
						<p class="my-3">
							<i class="far fa-hand-point-right mr-2"></i>
							<label>1 Year</label>Manufacturer Warranty</p>
						<ul>
							<li class="mb-1">
								{{$bookarray->bookDetails}}
							</li>
							
						</ul>
						<p class="my-sm-4 my-3">
							<i class="fas fa-retweet mr-3"></i>Net banking & Credit/ Debit/ ATM card
						</p>
					</div>
					@if($bookarray->bookQty<=0)
					<div><h3><b>Out of Stock</b></h3></div>
					@else
					<div class="occasion-cart">
						<div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
							
							<form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<input type="hidden" value="{{ $bookarray->bookId }}" name="id">
								<input type="hidden" value="{{ $bookarray->bookName }}" name="name">
								<input type="hidden" value="{{ $bookarray->bookPrice }}" name="price">
								<input type="hidden" value="{{ 'images/'.$bookarray->bookImage }}"  name="image">
								<input type="hidden" value="1" name="quantity">
								<button class="btn btn-primary">Add To Cart</button>
							</form>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- //Single Page -->

	<!-- middle section -->
	<div class="join-w3l1 py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<div class="row">
				<div class="col-lg-6">
					<div class="join-agile text-left p-4">
						<div class="row">
							<div class="col-sm-7 offer-name">
								<h6>Smooth, Rich & Loud Audio</h6>
								<h4 class="mt-2 mb-3">Branded Headphones</h4>
								<p>Sale up to 25% off all in store</p>
							</div>
							<div class="col-sm-5 offerimg-w3l">
								<img src="images/off1.png" alt="" class="img-fluid">
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 mt-lg-0 mt-5">
					<div class="join-agile text-left p-4">
						<div class="row ">
							<div class="col-sm-7 offer-name">
								<h6>A Bigger Phone</h6>
								<h4 class="mt-2 mb-3">Smart Phones 5</h4>
								<p>Free shipping order over $100</p>
							</div>
							<div class="col-sm-5 offerimg-w3l">
								<img src="images/off2.png" alt="" class="img-fluid">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- middle section -->
@endsection