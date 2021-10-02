        <style type="text/css">
            table td, table th{
                border:1px solid black;
            }
        </style>
        <div class="container">
        
        
            <br/>
            {{-- <a href="{{ route('pdfview',['download'=>'pdf']) }}">Download PDF</a> --}}
        
        <h3>Your Order History</h3>
            <table>
                <tr>
                    <th>SL No.</th>  
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>SubTotal</th>
                    <th>OrderStatus</th>
                    <th> OrderDate</th>
                    <th>OrderCancel/Update</th>
                    <th>Action</th>
                </tr>
                @php $count=1; @endphp
                @foreach ($orderListing as $key => $order)
                @if($order->user_id==Auth::user()->id)
                <tr>
                    <td>{{ $count }}</td>
                    <td>{{$order->product->bookName}}</td>
                    <td>{{$order->quantity}}</td>
                    <td >{{$order->product->bookPrice}}</td>
                    <td >{{ $order->price}}</td> 
                    <td >{{$order->status}}</td>
                    <td>{{$order->created_at}}</td>
                    <td>{{$order->updated_at}}</td>
                     @if($order->status=='cancelled')
                    <td > Order Cancelled</td>
                     @else
                    <td > Order Processing</td>  
                    @endif
                </tr>
                @php $count++; @endphp  
                 @endif
                @endforeach
            </table>
        </div>         