<?php

namespace App\Http\Controllers;

use App\Models\bookManagement;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartList()
    {
        $specialbooks = bookManagement::paginate(3);
        $cartItems = \Cart::getContent();
        // dd($cartItems);
        return view('users.cartListing', compact('cartItems', 'specialbooks'));
    }

    public function addToCart(Request $request)
    {
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => [
                'image' => $request->image,
            ],
       ]);

        session()->flash('success', 'Book is Added to Cart Successfully !');

        // return redirect()->route('cart.list');
        return redirect('/users/bookListing');
    }

    public function updateCart(Request $request)
    {
        $books = bookManagement::where('bookId',$request->id)->first();
       // foreach ($books as $book ) {
    
            if($request->quantity > $books->bookQty) {
            session()->flash('warning',$books->bookName.'is not enough in quantity,Available books are:'.$books->bookQty);
            }
          else {
        
             \Cart::update(
            
                $request->id,
                [
                    'quantity' => [
                        'relative' => false,
                        'value' => $request->quantity,
                    ],
                ]
            
             );
            session()->flash('success', 'Cart book Quantity Updated Successfully !');
        
        } 
        return redirect()->route('cart.list');
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'Cart book Remove Successfully !');

        return redirect()->route('cart.list');
    }

    public function clearAllCart()
    {
        \Cart::clear();

        session()->flash('success', 'All Book of Cart Clear Successfully !');

        // return redirect()->route('cart.list');
        return redirect('/users/bookListing');
    }
}
