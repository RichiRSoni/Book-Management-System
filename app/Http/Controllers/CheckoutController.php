<?php

namespace App\Http\Controllers;

use App\DataTables\OrderDataTable;
use App\DataTables\OrderItemDataTable;
use App\Mail\OrderMail;
use App\Models\bookManagement;
use App\Models\Order;
use App\Models\OrderItem;
use Auth;
use Cart;
use DB;
use Illuminate\Http\Request;
//use App\Exports\UsersExport;
//use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use PDF;

class CheckoutController extends Controller
{
    public function __construct(Order $model)
    {
        // parent::__construct($model);
        $this->model = $model;
    }

    public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.orderIndex');
    }

    public function orderDetails(OrderItemDataTable $dataTable)
    {
        return $dataTable->render('admin.orderDetails');
    }

    public function storeOrderDetails($params)
    {
        $order = Order::create([
        //'order_number'      =>  'ORD-'.strtoupper(uniqid()),
        'user_id' => auth()->user()->id,
        'status' => 'pending',
        'grand_total' => Cart::getSubTotal(),
        'item_count' => Cart::getTotalQuantity(),
       // 'payment_status'    =>  0,
        //'payment_method'    =>  null,
        'first_name' => $params['first_name'],
        'last_name' => $params['last_name'],
        'address' => $params['address'],
        'city' => $params['city'],
        'country' => $params['country'],
        'post_code' => $params['post_code'],
        'phone_number' => $params['phone_number'],
        'notes' => $params['notes'],
    ]);

        if ($order) {
            $items = \Cart::getContent();

            foreach ($items as $item) {
                $book = bookManagement::where('bookName', $item->name)->first()->decrement('bookQty', $item->quantity);

                $orderItem = new OrderItem([
               // 'book_id' => $book->bookId,
                'book_id' => $item->id,
                'quantity' => $item->quantity,
                'price' => $item->getPriceSum(),
                'user_id' => Auth::user()->id,
                'status' => 'processing',
            ]);

                $order->items()->save($orderItem);
            }
            $data=['name'=>'Your Order Successfully Placed'];
            $pdf = PDF::loadView('emails.order-mail',['items' => $items]);
            Mail::send('emails.order-send',$data,function($message)use($pdf) {
                   $message->to(Auth::user()->email)
                           ->subject('Order Confirmation')
                           ->attachData($pdf->output(),"order_confirmation.pdf");
                  });
          // }
       // Mail::to(Auth::user()->email)->send(new OrderMail($items));
        }
        return $order;
    }
   
    public function getCheckout()
    {
        $items = \Cart::getContent();
        foreach ($items as $item) {
            $book = bookManagement::where('bookName', $item->name)->first();
            if($item->quantity>$book->bookQty){
                session()->flash('error','Sorry we recently lost stock of'.$book->bookName.'!Please purchase another book');
                return redirect('/users/cart');
                //->with('errors','Sorry we recently lost stock of'.$book->bookName);

            }else{
                return view('users.checkout');
            }
        }
        
    }

    public function placeOrder(Request $request)
    {
        $order = $this->storeOrderDetails($request->all());
        \Cart::clear();

        return redirect('users/thankyou')->with('success','Your Order Placed Successfuly');
    }

    public function orderListing()
    {
        $orderListing = OrderItem::select(['orderItemId', 'order_id', 'user_id', 'book_id', 'price', 'status', 'quantity'])
        ->withExists('product')
        ->get();

        return view('users.orderListing', ['orderListing'=>$orderListing]);
    }

    public function orderCancel(Request $request)
    {
        // $order = DB::table('orders')
        //          ->where('orderId', $request->orderId)
        //         ->update(['status' => 'decline']);


        $order = DB::table('order_items')
              ->where('orderItemId', $request->orderItemId)
              ->update(['status' => 'cancelled','updated_at'=>now()]);

        $quantity = DB::table('book_management')->select('bookQty')->where('bookId', $request->bookId)->first();
        foreach ($quantity as $qty) {
            $book = DB::table('book_management')
                ->where('bookId', $request->bookId)
                ->update(['bookQty' => $qty + $request->quantity]);
        }
        
        $orderListing = OrderItem::select(['orderItemId','updated_at', 'created_at','order_id', 'user_id', 'book_id', 'price', 'status', 'quantity'])->where('orderItemId', $request->orderItemId)
         ->withExists('product')
         ->get();

        $data=['name'=>'Your Order Successfully Cancelled'];
        $pdf = PDF::loadView('emails.order-cancel',['orderListing'=> $orderListing]);
       
        Mail::send('emails.order-cancel1',$data, function($message)use($orderListing,$pdf) {
            $message->to(Auth::user()->email)
                    ->subject('Order Cancellation')
                    ->attachData($pdf->output(),"order_cancellation.pdf");
        });
        session()->flash('success','Your order Cancelled Successfully');
        return redirect()->route('order.listing');
    }

    public function createPDF()
    {
        // retreive all records from db
        // $orderListing = OrderItem::select(['orderItemId', 'order_id', 'user_id', 'book_id', 'price', 'status', 'quantity'])
        // ->withExists('product')
        // ->get();
        $orderListing = OrderItem::all();
    
        $pdf = PDF::loadView('users.pdf_view', ['orderListing' => $orderListing]);

        // download PDF file with download method
        return $pdf->download('order_history.pdf');
    }
}
