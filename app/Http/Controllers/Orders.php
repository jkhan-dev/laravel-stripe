<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use Stripe;
class Orders extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function place_order(Request $request,Order $order,Payment $payment)
    {
        $validator = Validator::make($request->all(),[
            'product_id' => 'required',
            'qty' => 'required'
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator);
        }
        $product = Product::find($request->product_id);
        $order->product_id = $request->product_id;
        $order->order_id = 'ord'.substr(time(),-5);
        $order->qty = $request->qty;
        $order->amount = $request->qty * $product->price;
        $order->status = 'new-order';
        
        if($order->save())
        {
            $payment->order_id = $order->id;
            $payment->txn_id = 'txn'.Hash::make(substr(time(),-6));
            $payment->status = 'incomplete';
            $payment->details = '';
            $payment->save();
            $stripe = new Stripe\StripeClient(env('STRIPE_SECRET'));

        $checkout_session = $stripe->checkout->sessions->create([
          'line_items' => [[
            
            'price_data' => [
              'currency' => 'inr',
              'product_data' => [
                'name' => $product->name,
              ],
              'unit_amount' => $product->price.'00',
            ],
            'quantity' => $order->qty,
          ]],
          'mode' => 'payment',
          'success_url' => url('/order-success?session_id={CHECKOUT_SESSION_ID}&order_id='.$order->order_id),
          'cancel_url' => url('/order-cancel'),
        ]);
      return redirect()->to($checkout_session->url);
        }
    }

    public function payment_success()
    {
        $stripe = new Stripe\StripeClient(env('STRIPE_SECRET'));
            try {
            $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);
                $order = Order::where('order_id',$_GET['order_id'])->first();
                $payment = $order->payment;

                $payment->details = json_encode($session);
                $payment->status = $session->status;
            $payment->save();
            return view('success',['order_id'=>$_GET['order_id']]);
            } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(),[
            'status' => 'required'
        ]);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator);
        }

        $order->status = $request->status;
        if($order->save())
        {
            return redirect()->back()->with('success','Order Updated successfully');
        }

        return redirect()->back()->with('failure','unable to update');
    }
}
