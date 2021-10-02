@extends('layouts.userMaster')
@section('content')
{{-- @guest
    @if(Route::has('/login'))
        return redirect('/login');
    @endif
@else --}}
<div class="container">
    <!-- tittle heading -->
    <h3 class="tittle-w3l">Your Order Details
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
            <a href="{{url('/users/bookListing')}}" class="btn btn-primary"> Purchase More Books</a>
            <a class="btn btn-primary" href="{{ URL::to('/users/pdf') }}" style="margin:10px">Export to PDF</a>
            <div class="table-responsive">
            
                <table class="timetable_sub">
                    <thead>
                        <tr>
                            <th>SL No.</th>  
                            <th>Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>SubTotal</th>
                            <th>OrderStatus</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('flash-message')
                        <?php  $count=1; ?>
                        
                        @foreach ($orderListing as $order)
                        @if($order->user_id==Auth::user()->id)
                        <tr class="rem1">
                            <td aria-readonly="true" class="invert" >{{$count}}</td>                                        
                            <td class="invert" aria-readonly="true">{{$order->product->bookName}}</td>
                            <td class="invert" >{{$order->quantity}}</td>
                            <td class="invert" aria-readonly="true">{{$order->product->bookPrice}}</td>
                            
                            <td class="invert" aria-readonly="true">{{ $order->price}}</td> 
                            
                            <td class="invert">{{$order->status}}</td>
                            @if($order->status=='cancelled')
                            <td class="invert"> Order Cancelled</td>
                            @else
                            <td class="invert">
                                <form action="{{ route('order.cancel') }}" method="POST">
                                    @csrf
                                     <input type="hidden" value="{{ $order->orderId }}" name="orderId">  
                                    <input type="hidden" value="{{$order->orderItemId}}" name="orderItemId">
                                    <input type="hidden" value="{{ Auth::user()->id }}" name="userId">
                                    <input type="hidden" value="{{ $order->book_id }}" name="bookId">
                                    <input type="hidden" value="{{$order->quantity}}" name="quantity">
                                    <button class="btn btn-warning">Cancel Order</button>
                                </form>
                            </td>  
                            @endif
                        </tr>
                     <?php $count++ ?>
                     
                     @endif 
                        
                    @endforeach  
                    
                    {{-- <p>You do not order yet</p>--}}
                 </tbody>
                <tfoot> 
                    
                    
                 </tfoot>
                </table>
            </div>
        </div>  
@endsection