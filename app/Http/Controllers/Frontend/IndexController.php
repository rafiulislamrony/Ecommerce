<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Product;
use App\Models\MultiImage;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)->orderby('id', 'DESC')->limit(6)->get();
        $sliders = Slider::where('status', 1)->orderby('id', 'DESC')->limit(3)->get();
        $categories = Category::orderby('category_name_en', 'ASC')->get();
        $featured = Product::where('featured', 1)->orderby('id', 'DESC')->limit(6)->get();

        $hot_deals = Product::where('hot_deals', 1)->where('discount_price', '!=', null)->orderby('id', 'DESC')->limit(3)->get();

        $special_offer = Product::where('special_offer', 1)->orderby('id', 'DESC')->limit(3)->get();
        $special_deals = Product::where('special_deals', 1)->orderby('id', 'DESC')->limit(3)->get();

        $skip_category_0 = Category::skip(0)->first();
        $skip_product_0 = Product::where('status', 1)->where('category_id', $skip_category_0->id)->orderby('id', 'DESC')->limit(6)->get();

        $skip_category_1 = Category::skip(1)->first();
        $skip_product_1 = Product::where('status', 1)->where('category_id', $skip_category_1->id)->orderby('id', 'DESC')->limit(6)->get();

        $skip_brand_1 = Brand::skip(1)->first();
        $skip_brand_product_1 = Product::where('status', 1)->where('brand_id', $skip_brand_1->id)->orderby('id', 'DESC')->limit(6)->get();


        return view('frontend.index', compact(
            'categories',
            'sliders',
            'products',
            'featured',
            'hot_deals',
            'special_offer',
            'special_deals',
            'skip_category_0',
            'skip_product_0',
            'skip_category_1',
            'skip_product_1',
            'skip_brand_1',
            'skip_brand_product_1'
        ));
    }
    public function UserLogout()
    {
        Auth::logout();
        return Redirect()->route('login');
    }
    public function UserProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('frontend.profile.user_profile', compact('user'));
    }
    public function UserProfileStore(Request $request)
    {
        $data = User::findOrFail(Auth::user()->id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;

        if($request->file('profile_photo_path')) {
            $file = $request->file('profile_photo_path');

            // Unlink the previous image file if it exists
            if($data->profile_photo_path && file_exists(public_path('upload/user_images/' . $data->profile_photo_path))) {
                @unlink(public_path('upload/user_images/' . $data->profile_photo_path));
            }

            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/user_images'), $filename);
            $data->profile_photo_path = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return Redirect()->route('dashboard')->with($notification);
    }
    public function UserChangePassword()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('frontend.profile.change_password', compact('user'));
    }
    public function UserPasswordUpdate(Request $request)
    {

        $validateData = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $hashedPassword = Auth::user()->password;

        if(Hash::check($request->oldpassword, $hashedPassword)) {
            $user = User::find(Auth::id());
            $user->password = Hash::make(trim($request->password));
            $user->save();
            Auth::logout();
            return redirect()->route('user.logout');
        } else {
            $notification = array(
                'message' => 'Old Password is Incorrect!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    public function ProductDetails($id, $slug)
    {
        $product = Product::findOrfail($id);
        $multiImg = MultiImage::where('product_id', $id)->get();
        $color_en = $product->product_color_en;
        $product_color_en = explode(',', $color_en);
        $color_hin = $product->product_color_hin;
        $product_color_hin = explode(',', $color_hin);
        $size_en = $product->product_size_en;
        $product_size_en = explode(',', $size_en);
        $size_hin = $product->product_size_hin;
        $product_size_hin = explode(',', $size_hin);

        $cat_id = $product->category_id;
        $relatedProduct = Product::where('category_id', $cat_id)->where('id','!=',$id)->orderBy('id', "DESC")->limit(8)->get();


        return view('frontend.product.product_details', compact('relatedProduct', 'product_size_hin', 'product_size_en','product_color_hin', 'product_color_en', 'product', 'multiImg'));
    }

    public function TagWiseProduct($tag)
    {
        $products = Product::where('status', 1)->where('product_tags_en', $tag)->where('product_tags_hin', $tag)->orderBy('id', 'DESC')->paginate(3);

        $categories = Category::orderBy('category_name_en', 'ASC')->get();

        return view('frontend.tags.tags_view', compact('products', 'categories'));
    }

      // Subcategory wise data
      public function SubCatWiseProduct($subcat_id, $slug)
      {
          $products = Product::where('status', 1)->where('subcategory_id', $subcat_id)->orderBy('id', 'DESC')->paginate(6);
          $categories = Category::orderBy('category_name_en', 'ASC')->get();
          return view('frontend.product.subcategory_view', compact('products', 'categories'));

      }
      // SubSubcategory wise data
      public function SubSubCatWiseProduct($subsubcat_id, $slug)
      {
          $products = Product::where('status', 1)->where('subsubcategory_id', $subsubcat_id)->orderBy('id', 'DESC')->paginate(6);
          $categories = Category::orderBy('category_name_en', 'ASC')->get();
          return view('frontend.product.subsubcategory_view', compact('products', 'categories'));

      }

      // Product View With Ajax
      public function ProductViewAjax($id)
      {
        $product = Product::with('category', 'brand')->findOrfail($id);

        $color = $product->product_color_en;
        $product_color = explode(',', $color);

        $size = $product->product_size_en;
        $product_size = explode(',', $size);

        return response()->json(array(
            'product' => $product,
            'color' => $product_color,
            'size' => $product_size,
        ));

      }//End Method

}
