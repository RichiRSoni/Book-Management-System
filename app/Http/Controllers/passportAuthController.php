<?php

namespace App\Http\Controllers;

use App\Models\bookManagement;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Validator;

class passportAuthController extends Controller
{
    /**
     * handle user registration request.
     */
    public function registerUserExample(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|min:8',
        //     'user_type' => 'required',
        // ]);
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'user_type' => 'required|in:user',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'user_type' => 'user',
            ]);

            $access_token_example = $user->createToken('PassportExample@Section.io')->accessToken;
            //return the access token we generated in the above step
            return response()->json(['token' => $access_token_example], 200);
        }
    }

    /**
     * login user to our application.
     */
    public function loginUserExample(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $login_credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            if (auth()->attempt($login_credentials)) {
                //generate the token for the user
                $user_login_token = auth()->user()->createToken('PassportExample@Section.io')->accessToken;
                //now return this token on success login attempt
                return response()->json(['token' => $user_login_token], 200);
            } else {
                //wrong login credentials, return, user not authorised to our system, return error code 401
                return response()->json(['error' => 'UnAuthorised Access'], 401);
            }
        }
    }

    /**
     * This method returns authenticated user details.
     */
    public function authenticatedUserDetails()
    {
        //returns details
        return response()->json(['authenticated-user' => auth()->user()], 200);
    }

    public function editProfileExample(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:25'],
            'email' => [
                'required', 'email',
                 Rule::unique('users')->ignore($request->id),
            ],
           'id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $userarray = User::find($request->get('id'));

            $userarray->name = $request->get('name');
            $userarray->email = $request->get('email');

            $result = $userarray->save();
            if ($result) {
                return ['success' => 'Successfully updated', 200];
            } else {
                return ['success' => 'not updated'];
            }
        }
    }

    public function changePasswordExample(Request $request)
    {
        $rules = [
            'current_password' => 'required',
            'new_password' => ['required', 'string', 'min:8'],
            'new_confirm_password' => ['required', 'same:new_password'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $user = User::find($request->get('id'));

            if (Hash::check($request->get('current_password'), $user->password)) {
                $user->update(['password' => Hash::make($request->new_password)]);

                return ['success' => 'Successfully Changed Your Password', 200];
            } else {
                return ['error', 'Your current password is not matched'];
            }
        }
    }

    public function bookListingExample()
    {
        $books = bookManagement::all();

        return response()->json($books, 200);
    }

    public function bookDetailsExample($id)
    {
        $details = bookManagement::find($id);
        if(is_null($details)) {
            return ['error','bookid not found'];
        }
        return response()->json($details, 200);
    }

    public function validationExample(Request $request)
    {
        $rules = [
           'bookid' => 'required',
           'quantity' => ['required', 'min:1', 'max:5'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $books = bookManagement::where('bookId', $request->bookid)->first();
            if ($books->bookQty == 0) {
                return ['error' => 'book is out of Stock ,Qty=0 '];
            } elseif ($request->quantity > $books->bookQty) {
                return ['error' => 'Not enough Stock Available'];
            } else {
                return ['Stock' => 'Okay'];
            }
        }
    }

    public function addCartExample(Request $request)
    {
        $rules = [
            'id' => 'required',
            'name' => 'required',
            'price' => 'required|integer',
            'image' => 'required',
            'quantity' => ['required', 'min:1', 'max:5'],
         ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $success = \Cart::add([
                'id' => $request->get('id'),
                'name' => $request->get('name'),
                'price' => $request->get('price'),
                'quantity' => $request->get('quantity'),
                'attributes' => [
                    'image' => $request->image,
                ],
            ]);
            if (!$success) {
                return['error', 'item ias not added'];
            }

            return ['sucess', 'item is addded into the cart'];
        }
    }

    public function viewCartExample()
    {
        $cartItems = \Cart::getContent();
        return response()->json($cartItems,200);
    }

    public function updateCartExample(Request $request)
    {
        $rules = [
            'id' => 'required',
            'quantity' => ['required', 'min:1', 'max:5'],
         ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $books = bookManagement::where('bookId', $request->id)->first();

            if ($request->quantity > $books->bookQty) {
                return['error', $books->bookName.'is not enough in quantity,Available books are:'.$books->bookQty];
            } else {
                $result = \Cart::update(
                    $request->id,
                    [
                        'quantity' => [
                            'relative' => false,
                            'value' => $request->quantity,
                        ],
                    ]
                );
                if (!$result) {
                    return['error', 'Cart book Quantity not Updated'];
                }

                return ['success', 'Cart book Quantity Updated Successfully !'];
            }
        }
    }

    public function removeCartExample(Request $request)
    {
        $rules = [
            'id' => 'required',
         ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $result = \Cart::remove($request->id);
            if (!$result) {
                return['error', 'Cart book has not Removed'];
            }

            return['success', 'Cart book Remove Successfully !'];
        }
    }

    public function getCheckoutExample(Request $request)
    {
        //$items = \Cart::getContent();
        $items = ['id' => $request->id, 'name' => $request->name, 'quantity' => $request->quantity];
        foreach ($items as $item) {
            $book = bookManagement::where('bookName', $request->name)->first();
            if ($request->quantity > $book->bookQty) {
                return ['error', 'Sorry we recently lost stock of'.$book->bookName.'!Please purchase another book'];
            } else {
                return['success', 'Successfully checkout'];
            }
        }
    }

    public function placeOrderExample(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            //'status' => 'required',
            'grand_total' => 'required',
            'item_count' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'post_code' => 'required',
            'phone_number' => 'required',
            'quantity' => ['required', 'min:1', 'max:5'],
         ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        } else {
            $order = Order::create([
                //'user_id' => auth()->user()->id,
                'user_id' => $request->get('user_id'),
                'status' => 'pending',
                //'grand_total' => Cart::getSubTotal(),
                //'item_count' => Cart::getTotalQuantity(),
                'grand_total' => $request->get('grand_total'),
                'item_count' => $request->get('item_count'),
            // 'payment_status'    =>  0,
                //'payment_method'    =>  null,
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'address' => $request->get('address'),
                'city' => $request->get('city'),
                'country' => $request->get('country'),
                'post_code' => $request->get('post_code'),
                'phone_number' => $request->get('phone_number'),
                'notes' => $request->get('notes'),
                //'first_name' => $params['first_name'],
                // 'last_name' => $params['last_name'],
                // 'address' => $params['address'],
                // 'city' => $params['city'],
                // 'country' => $params['country'],
                // 'post_code' => $params['post_code'],
                // 'phone_number' => $params['phone_number'],
                // 'notes' => $params['notes'],
            ]);

            if (!$order) {
                return ['error', 'Sorry your order is not placed'];
            }
            //  $items = \Cart::getContent();
            //$items = ['id'=>$request->id,'user_id'=>$request->userid,'name'=>$request->name,'quantity'=>$request->quantity,'price'=>$request->price];
            // foreach ($items as $item) {
            $book = bookManagement::where('bookName', $request->name)->first()->decrement('bookQty', $request->quantity);

            $orderItem = new OrderItem([
                   // 'book_id' => $book->bookId,
                    'book_id' => $request->id,
                    'quantity' => $request->quantity,
                    'price' => $request->quantity * $request->price,
                    //'price' => $item->getPriceSum(),
                    //'user_id' => Auth::user()->id,
                    'user_id' => $request->user_id,
                    'status' => 'processing',
                ]);

            $result = $order->items()->save($orderItem);
            // }
            if (!$result) {
                return['error', 'Your order is not placed'];
            }

            return ['success' => 'Your Order Successfully Placed'];
            // $pdf = PDF::loadView('emails.order-mail',['items' => $items]);
                // Mail::send('emails.order-send',$data,function($message)use($pdf) {
                //        $message->to(Auth::user()->email)
                //                ->subject('Order Confirmation')
                //                ->attachData($pdf->output(),"order_confirmation.pdf");
                //       });
        }
    }
}
