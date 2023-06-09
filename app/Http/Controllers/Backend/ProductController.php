<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\SubSubCategory;
use App\Models\Product;
use App\Models\Brand;
use App\Models\MultiImage;
use Carbon\Carbon;
use Image;

class ProductController extends Controller
{
    public function AddProduct()
    {
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        return view('backend.product.product_add', compact('categories', 'brands'));
    }
    public function StoreProduct(Request $request)
    {

        $image = $request->file('product_thambnial');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(917, 1000)->save('upload/products/thumbnail/'.$name_gen);
        $save_url = 'upload/products/thumbnail/'.$name_gen;

        $product_id = Product::insertGetId([
             'brand_id' => $request->brand_id,
             'category_id' => $request->category_id,
             'subcategory_id' => $request->subcategory_id,
             'subsubcategory_id' => $request->subsubcategory_id,
             'product_name_en' => $request->product_name_en,
             'product_name_hin' => $request->product_name_hin,
             'product_slug_en' => strtolower(str_replace(' ', '-', $request->product_name_en)),
             'product_slug_hin' => str_replace(' ', '-', $request->product_name_hin),
             'product_code' => $request->product_code,

             'product_qty' => $request->product_qty,
             'product_tags_en' => $request->product_tags_en,
             'product_tags_hin' => $request->product_tags_hin,
             'product_size_en' => $request->product_size_en,
             'product_size_hin' => $request->product_size_hin,
             'product_color_en' => $request->product_color_en,
             'product_color_hin' => $request->product_color_hin,
             'selling_price' => $request->selling_price,
             'discount_price' => $request->discount_price,
             'short_descp_en' => $request->short_descp_en,
             'short_descp_hin' => $request->short_descp_hin,
             'long_descp_en' => $request->long_descp_en,
             'long_descp_hin' => $request->long_descp_hin,

             'hot_deals' => $request->hot_deals,
             'featured' => $request->featured,
             'special_offer' => $request->special_offer,
             'special_deals' => $request->special_deals,

             'product_thambnial' => $save_url,
             'status' => 1,
             'created_at' => Carbon::now(),
         ]);

        /////// Multi Image Upload Start ///////
        $images = $request->file('multi_img');

        foreach($images as $img) {
            $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($img)->resize(917, 1000)->save('upload/products/multi_image/'.$make_name);
            $uploadPath = 'upload/products/multi_image/'.$make_name;

            MultiImage::insert([
                'product_id' => $product_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),
            ]);
        }
        /////// Multi Image Upload End ///////
        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('manage-product')->with($notification);
    }

    public function ManageProduct()
    {
        $products = Product::latest()->get();
        return view('backend.product.product_view', compact('products'));
    }
    public function EditProduct($id)
    {
        $multiImgs =  MultiImage::where('product_id', $id)->get();
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        $subcategory = Subcategory::latest()->get();
        $subsubcategory = SubSubCategory::latest()->get();
        $products = Product::findOrfail($id);
        return view('backend.product.product_edit', compact('categories', 'multiImgs', 'brands', 'subcategory', 'subsubcategory', 'products'));

    }

    public function ProductDataUpdate(Request $request)
    {
        $product_id = $request->id;

        Product::findOrFail($product_id)->update([
           'brand_id' => $request->brand_id,
           'category_id' => $request->category_id,
           'subcategory_id' => $request->subcategory_id,
           'subsubcategory_id' => $request->subsubcategory_id,
           'product_name_en' => $request->product_name_en,
           'product_name_hin' => $request->product_name_hin,
           'product_slug_en' => strtolower(str_replace(' ', '-', $request->product_name_en)),
           'product_slug_hin' => str_replace(' ', '-', $request->product_name_hin),
           'product_code' => $request->product_code,

           'product_qty' => $request->product_qty,
           'product_tags_en' => $request->product_tags_en,
           'product_tags_hin' => $request->product_tags_hin,
           'product_size_en' => $request->product_size_en,
           'product_size_hin' => $request->product_size_hin,
           'product_color_en' => $request->product_color_en,
           'product_color_hin' => $request->product_color_hin,
           'selling_price' => $request->selling_price,
           'discount_price' => $request->discount_price,
           'short_descp_en' => $request->short_descp_en,
           'short_descp_hin' => $request->short_descp_hin,
           'long_descp_en' => $request->long_descp_en,
           'long_descp_hin' => $request->long_descp_hin,

           'hot_deals' => $request->hot_deals,
           'featured' => $request->featured,
           'special_offer' => $request->special_offer,
           'special_deals' => $request->special_deals,
           'status' => 1,
           'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Product Updated Without Image Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('manage-product')->with($notification);

    }

     //// Multiple Image Update /////
    public function MultiImageUpdate(Request $request)
    {
        $imgs = $request->multi_img;
        foreach($imgs as $id => $img){
            $imgDetele = MultiImage::findOrFail($id);
            @unlink($imgDetele->photo_name);
            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(917, 1000)->save('upload/products/multi_image/'.$make_name);
            $upload_path = 'upload/products/multi_image/'.$make_name;

            MultiImage::where('id', $id)->update([
                'photo_name' => $upload_path,
                'updated_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Product Image Updated Successfully',
            'alert-type' => 'info'
        );
        return redirect()->back()->with($notification);

    }
    public function ThambnialImageUpdate(Request $request)
    {
        $pro_id = $request->id;
        $oldImage = $request->old_img;
        @unlink($oldImage);

        $image = $request->file('product_thambnial');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(917, 1000)->save('upload/products/thumbnail/'.$name_gen);
        $save_url = 'upload/products/thumbnail/'.$name_gen;

        Product::findOrFail($pro_id)->update([
            'product_thambnial' => $save_url,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Product Thambnial Image Updated Successfully',
            'alert-type' => 'info'
        );
        return redirect()->back()->with($notification);

    }

    //// Multi Image Delete ////
    public function MultiimgDeleteProduct($id){

        $oldimg = MultiImage::findOrFail($id);

        @unlink($oldimg->photo_name);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Product Image Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function ProductInactive($id)
    {
        Product::findOrFail($id)->update(['status' => 0]);
        $notification = array(
            'message' => 'Product Inactive ',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function ProductActive($id)
    {
        Product::findOrFail($id)->update(['status' => 1]);
        $notification = array(
            'message' => 'Product Active ',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function ProductDelete($id)
    {
        $product = Product::findOrFail($id);
        @unlink($product->product_thambnail);
        Product::findOrFail($id)->delete();

        $images = MultiImage::where('product_id', $id)->get();
        foreach($images as $img){
            @unlink($img->photo_name);
            MultiImage::where('product_id', $id)->delete();
        }

        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function ProductView($id){
        $multiImgs = MultiImage::where('product_id', $id)->get();
        $categories = Category::latest()->get();
        $brands = Brand::latest()->get();
        $subcategory = Subcategory::latest()->get();
        $subsubcategory = SubSubCategory::latest()->get();
        $products = Product::findOrfail($id);

        return view('backend.product.product_overview', compact('multiImgs', 'categories', 'brands', 'subcategory', 'subsubcategory', 'products'));

    }


}
