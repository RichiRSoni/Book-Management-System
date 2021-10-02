<!DOCTYPE html>
<html lang="en">
<head>
    {{-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>Order Confirmation</title>
</head>
<body>
    <p>Hi,</p>
    <p>Your Order has been Successfully Placed</p>
    <br/>
    <table style="width:600px; text-align:right">
        {{-- <thead> --}}
            <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>SubTotal</th>
        </tr>
        {{-- </thead> --}}
        {{-- <tbody> --}}
            @foreach($items as $item)
            {{-- @foreach($orderListing as $item) --}}
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->quantity * $item->price}}</td> 
                    
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="border-top:1px solid #ccc;"></td>
                <td style="font-size:15px;font-weight:bold;border-top:1px solid #ccc;" >Total:{{Cart::getTotal()}}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td style="font-size:15px;font-weight:bold"> Free Shipping</td>
            </tr>
        {{-- </tbody> --}}
    </table>
</body>
</html>