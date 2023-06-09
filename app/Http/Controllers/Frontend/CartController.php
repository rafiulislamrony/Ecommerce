<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Coupon;
use App\Models\ShipDivision;
use Gloudemans\Shoppingcart\Facades\Cart;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function AddToCart(Request $request, $id){

        if(Session::has('coupon')){
            Session::forget('coupon');
        }

    	$product = Product::findOrFail($id);

    	if ($product->discount_price == NULL) {
    		Cart::add([
    			'id' => $id,
    			'name' => $request->product_name,
    			'qty' => $request->quantity,
    			'price' => $product->selling_price,
    			'weight' => 1,
    			'options' => [
    				'image' => $product->product_thambnail,
    				'color' => $request->color,
    				'size' => $request->size,
    			],
    		]);
    		return response()->json(['success' => 'Successfully Added on Your Cart']);
    	}else{
    		Cart::add([
    			'id' => $id,
    			'name' => $request->product_name,
    			'qty' => $request->quantity,
    			'price' => $product->discount_price,
    			'weight' => 1,
    			'options' => [
    				'image' => $product->product_thambnial,
    				'color' => $request->color,
    				'size' => $request->size,
    			],
    		]);
    		return response()->json(['success' => 'Successfully Added on Your Cart']);
    	}

    } // End Mehtod

    // Mini Cart Mehtod
	public function AddMiniCart()
    {
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return response()->json(array(
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => round($cartTotal),
        ));
    } // end method

    /// remove mini cart
    public function RemoveMiniCart($rowId)
    {
        Cart::remove($rowId);
        return response()->json(['success' => 'Product Remove from Cart']);

    } // end mehtod

    public function AddToWishList(Request $request, $product_id)
    {
        if(Auth::check()){
            $exist = WishList::where('user_id', Auth::id())->where('product_id', $product_id)->first();

            if(!$exist){
                WishList::insert([
                    'user_id' => Auth::id(),
                    'product_id' => $product_id,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json(['success' => 'Product Added Wishlist Successfully']);
            }else{
                return response()->json(['error' => 'This Product has Allready on Your Wishlist']);
            }

        }else{
            return response()->json(['error' => 'Login First']);
        }

    } // end mehtod

    public function CouponApply(Request $request){

        $coupon = Coupon::where('coupon_name',$request->coupon_name)->where('coupon_validity','>=',Carbon::now()->format('Y-m-d'))->first();
        if ($coupon) {

            Session::put('coupon',[
                'coupon_name' => $coupon->coupon_name,
                'coupon_discount' => $coupon->coupon_discount,
                'discount_amount' => round(Cart::total() * $coupon->coupon_discount/100),
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->coupon_discount/100)
            ]);

            return response()->json(array(
                'validity' => true,
                'success' => 'Coupon Applied Successfully'
            ));

        }else{
            return response()->json(['error' => 'Invalid Coupon']);
        }

    } // end method

    public function CouponCalculation()
    {
        if (Session::has('coupon')) {
            $coupon = session()->get('coupon');
            $couponName = isset($coupon['coupon_name']) ? $coupon['coupon_name'] : null;
            $couponDiscount = isset($coupon['coupon_discount']) ? $coupon['coupon_discount'] : null;
            $discountAmount = isset($coupon['discount_amount']) ? $coupon['discount_amount'] : null;
            $totalAmount = isset($coupon['total_amount']) ? $coupon['total_amount'] : null;

            return response()->json([
                'subtotal' => Cart::total(),
                'coupon_name' => $couponName,
                'coupon_discount' => $couponDiscount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
            ]);
        } else {
            return response()->json([
                'total' => Cart::total(),
            ]);
        }
    }

    // Remove Coupon
    public function CouponRemove(){
        Session::forget('coupon');
        return response()->json(['success' => 'Coupon Remove Successfully']);
    }


    // Checkout All Method
    public function CheckoutCreate(){
        if(Auth::check()){
            if(Cart::total()>0){
                $carts = Cart::content();
                $cartQty = Cart::count();
                $cartTotal = Cart::total();
                $divisions = ShipDivision::orderBy('division_name', 'ASC')->get();

                return view('frontend.checkout.checkout_view', compact('carts','cartQty','cartTotal','divisions'));

            }else{
                $notification = array(
                    'message' => 'Shopping at list one Product',
                    'alert-type' => 'error'
                );
                return redirect()->to('/')->with($notification);
            }

        }else{
            $notification = array(
                'message' => 'You Need to Login First',
                'alert-type' => 'error'
            );
            return redirect()->route('login')->with($notification);
        }

    } //End Method

}
