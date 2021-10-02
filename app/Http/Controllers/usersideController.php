<?php

namespace App\Http\Controllers;

use App\Models\bookManagement;
use App\Models\OrderDetails;
use App\Models\OrderMaster;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Auth;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Session;

class usersideController extends Controller
{
    // public function home()
    // {
    //     return view('users.home');
    // }

    public function __construct()
    {
        $this->middleware(['auth', 'verified'], ['except' => ['home','bookListing', 'bookdetails']]);
        // $this->middleware('auth', ['except' => ['home', 'bookListing', 'bookdetails']],'verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $topbooks = bookManagement::paginate(6);
        $specialbooks = bookManagement::paginate(3);

        return view('users.home', compact('specialbooks', 'topbooks'));
    }

    public function showProfile()
    {
        $abc = Auth::user();

        return view('users.editProfile', compact('abc'));
    }

    public function editProfile($id)
    {
        $abc = User::where('Id', $id)->first();

        return view('users.editProfile', compact('abc'));
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:25'],
            'email' => [
                'required', 'email:rfc,dns',
                Rule::unique('users')->ignore($id),
            ],
        ]);

        $userarray = User:: where('Id', $id)->first();
        $userarray->name = $request->get('name');
        $userarray->email = $request->get('email');

        $userarray->save();

        return redirect('/users/profile')->with('success', 'Profile updated successfully');
    }

    public function index()
    {
        return view('users.changePassword');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword()],
            'new_password' => ['required', 'string', 'min:8'],
            'new_confirm_password' => ['required', 'same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password changed successfully!');
    }

    public function bookListing()
    {
        $bookarray = bookManagement::all();
        $specialbooks = bookManagement::paginate(3);

        return view('users.bookListing', compact('bookarray', 'specialbooks'));
    }

    public function bookdetails($id)
    {
        $bookarray = bookManagement::where('bookId', $id)->first();
        //$bookarray = bookManagement::all();
        if (!$bookarray) {
            abort(404);
        }

        return view('users.bookdetails', compact('bookarray'));
    }

    public function store1($bookId, $bookName, $bookPrice)
    {
        Cart::add($bookId, $bookName, 1, $bookPrice)->associate('App\Models\bookManagement');
        session()->flash('sucess_message', 'book addded into the cart');

        return redirect('')->route('users.cartListing');
    }

    public static function cartItem()
    {
        $userId = Auth::user()->id;

        return cart::where('userId', $userId)->count();
    }

    public function cartListing()
    {
        $userId = Auth::user()->id;
        $books = DB::table('cart')
        ->join('book_management', 'cart.bookId', '=', 'book_management.bookId')
        ->where('cart.userId', $userId)
        ->select('book_management.*', 'cart.id as cartId')
        ->get();

        return view('users.cartListing', ['books' => $books]);
    }

    public function removeCart($id)
    {
        if ($id) {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }

            return redirect('/users/cart')->with('success', 'Book removed from the cart');
        }
    }

    public function updateCart(Request $request, $id)
    {
        $id = $id;
        $qty = $request->qty;
        if ($id and $qty) {
            $cart = session()->get('cart');
            $cart[$request->id]['quantity'] = $qty;
            session()->put('cart', $cart);

            return redirect('/users/cart')->with('success', 'cart updated successfully');
        }
    }

    // public function placeOrder(Request $request)
    // {
    //     $orderDate = date('d-m-y');
    //     $orderStatus = 'pending';
    //     //$uid=$id;
    //     $uid = Auth::user()->id;

    //     $ordermasterq = new OrderMaster([
    //         'orderDate' => $orderDate,
    //         'orderStatus' => $orderStatus,
    //         'id' => $uid,
    //     ]);
    //     $ordermasterq->save();

    //     //get last Record insert id
    //     $orderId = $ordermasterq->orderId;
    //     //fetch product details and store in order details
    //     foreach (session('cart') as $id => $details) {
    //         $orderdetailsq = new OrderDetails([
    //             'orderId' => $orderId,
    //             'bookId' => $id,
    //             'bookQty' => $details['quantity'],
    //             'bookPrice' => $details['price'],
    //         ]);
    //         $orderdetailsq->save();
    //     }
    //     if ($orderdetailsq) {
    //         session()->forget('cart');
    //     }

    //     return redirect('/users/thank-you')->with('success', 'cart updated successfully');
    // }
}
