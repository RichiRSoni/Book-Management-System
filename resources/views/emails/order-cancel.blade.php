<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Cancellation</title>
</head>
<body>
    <p>Hi,</p>
    <p>Your Order has been Successfully Cancelled</p>
    <br/>
    <table style="width:600px; text-align:right">
        {{-- <thead> --}}
        <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>OrderDate</th>
            <th>OrderCancel</th>
            <th>SubTotal</th>
        </tr>
        {{-- </thead> --}}
        {{-- <tbody> --}}
            @foreach($orderListing as $order)
                <tr>
                    <td>{{$order->product->bookName}}</td>
                    <td>{{$order->quantity}}</td>
                    <td>{{$order->product->bookPrice}}</td>
                    <td>{{$order->created_at}}</td>
                    <td>{{$order->updated_at}}</td>
                    <td>{{$order->price}}</td> 
                </tr>
            @endforeach
            <tr>
                <td colspan="5" style="border-top:1px solid #ccc;"></td>
                <td style="font-size:15px;font-weight:bold;border-top:1px solid #ccc;" >Total:{{$order->price}}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td style="font-size:15px;font-weight:bold"> Free Shipping</td>
            </tr>
        {{-- </tbody> --}}
    </table>
</body>
</html>