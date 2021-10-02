@extends('layouts.userMaster')
@section('content')
{{-- @guest
    @if(Route::has('/login'))
        return redirect('/login');
    @endif
@else --}}
<div class="container">
    <!-- tittle heading -->
    <h3 class="tittle-w3l">Your Cart Details
        <span class="heading-style">
            <i></i>
            <i></i>
            <i></i>
        </span>
    </h3>
<!-- banner -->
<div>
    <center><img src="/images/bookCart.jpeg" alt="libraryhome" width="700" height="500" ></center>             
</div>
 <!-- checkout page -->
 <div class="privacy">
    
        <div class="checkout-right">
            <h4>Your shopping cart contains:
                <span>{{\Cart::getContent()->count()}} Books</span>
            </h4>
            @if(\Cart::getContent()->count()>0)
            <div class="table-responsive">
                <table class="timetable_sub">
                    <thead>
                        <tr>
                            <th>SL No.</th>
                            <th>Image</th>
                            <th>Qty</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>SubTotal</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @include('flash-message')
                        
                        {{-- @if(Cart::getTotalQuantity()) --}}
                        <?php  $count=1; ?>
                         @foreach ($cartItems as $book) 
                        <tr class="rem1">
                            <td>{{$count}}</td>
                            <td class="invert-image">
                               
                                <img src="{{ url($book->attributes->image) }}" alt="{{$book->name}} " class="img-responsive" width="100">
                                
                            </td>
                           
                             <td>
                                <form action="{{ route('cart.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $book->id}}" >
                                    <input type="number" name="quantity" value="{{ $book->quantity }}" 
                                    class="w-6 text-center bg-gray-300" min="1" max="5" />
                                    <button type="submit" class="btn btn-primary">update</button>
                                </form>
                            </td>
                                            
                            <td class="invert">{{$book->name}}</td>
                            <td class="invert">{{$book->price}}</td>
                            
                            <td class="invert">{{ $book->quantity * $book->price}}</td> 
                            <td class="invert">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $book->id }}" name="id">
                                    <button class="btn btn-warning">Remove</button>
                                </form>
                            
                            </td>  
                            
                        </tr>
                        <?php $count++ ?>
                        
                        @endforeach
                 
                    </tbody>
                    <tfoot>
                      <td class="invert" colspan="2"><a href="{{url('/users/bookListing')}}" class="btn btn-primary"> Add More Books</a></td>
                      <td class="invert" colspan="3">Total</td>
                      <td><strong>{{Cart::getTotal()}}</strong></td>
                        <td>      
                      <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger">Remove All Cart</button>
                      </form>
                        </td>
                        @if (session('cart'))
                      <form method="post" action="{{url('/users/place-order')}}">
                          @csrf
                              <input type="submit" value="Place Order" class="btn btn-success">
                      </form>
                        @endif
                     
                 </tfoot>
                </table>
                <a href="{{ route('checkout.index') }}" class="btn btn-success btn-lg btn-block">Proceed To Checkout</a>
                @else

                <center><b style="font-size:30px">No item in cart</b></center>
                @endif
            </div>
        </div>  
        
    {{-- @endguest --}}
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