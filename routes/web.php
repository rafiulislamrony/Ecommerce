<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\CouponsController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ReportsController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\MyCartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\StripeController;
use App\Http\Controllers\User\AllUserController;
use App\Http\Controllers\User\CashController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

Route::group(['prefix'=> 'admin', 'middleware'=>['admin:admin']], function () {
    Route::get('/login', [AdminController::class, 'loginForm']);
    Route::post('/login', [AdminController::class, 'store'])->name('admin.login');
});

Route::middleware(['auth:admin'])->group(function () {
    Route::middleware(['auth:sanctum,admin', 'verified'])->get('/admin/dashboard', function () {
        return view('admin.index');
    })->name('dashboard')->middleware('auth:admin');

    // Admin All Routes
    Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
    Route::get('/admin/profile', [AdminProfileController::class, 'AdminProfile'])->name('admin.profile');
    Route::get('/admin/profile/edit', [AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');
    Route::post('/admin/profile/store', [AdminProfileController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminProfileController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/update/change/password', [AdminProfileController::class, 'AdminUpdateChangePassword'])->name('update.change.password');
});  // end Middleware admin

// User All Route
Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
    $id = Auth::user()->id;
    $user = User::find($id);
    return view('dashboard', compact('user'));
})->name('dashboard');

Route::get('/', [IndexController::class, 'index']);
Route::get('/user/logout', [IndexController::class, 'UserLogout'])->name('user.logout');
Route::get('/user/profile', [IndexController::class, 'UserProfile'])->name('user.profile');
Route::post('/user/profile/store', [IndexController::class, 'UserProfileStore'])->name('user.profile.store');
Route::get('/user/change/password', [IndexController::class, 'UserChangePassword'])->name('change.password');
Route::post('/user/password/update', [IndexController::class, 'UserPasswordUpdate'])->name('user.password.update');

// Admin Brand All Route

Route::prefix('brand')->group(function () {
    Route::get('/view', [BrandController::class, 'BrandView'])->name('all.brand');
    Route::post('/store', [BrandController::class, 'BrandStore'])->name('brand.store');
    Route::get('/edit/{id}', [BrandController::class, 'BrandEdit'])->name('brand.edit');
    Route::post('/update', [BrandController::class, 'BrandUpdate'])->name('brand.update');
    Route::get('/delete/{id}', [BrandController::class, 'BrandDelete'])->name('brand.delete');
});

// Admin Category All Route
Route::prefix('category')->group(function () {
    Route::get('/view', [CategoryController::class, 'CategoryView'])->name('all.category');
    Route::post('/store', [CategoryController::class, 'CategoryStore'])->name('category.store');
    Route::get('/edit/{id}', [CategoryController::class, 'CategoryEdit'])->name('category.edit');
    Route::post('/update/{id}', [CategoryController::class, 'CategoryUpdate'])->name('category.update');
    Route::get('/delete/{id}', [CategoryController::class, 'CategoryDelete'])->name('category.delete');

    // Admin Sub Category All Routes all.subcategory
    Route::get('/sub/view', [SubCategoryController::class, 'SubCategoryView'])->name('all.subcategory');
    Route::post('/sub/store', [SubCategoryController::class, 'SubCategoryStore'])->name('subcategory.store');
    Route::get('/sub/edit/{id}', [SubCategoryController::class, 'SubCategoryEdit'])->name('subcategory.edit');
    Route::post('/sub/update', [SubCategoryController::class, 'SubSubCategoryUpdate'])->name('subcategory.update');
    Route::get('/sub/delete/{id}', [SubCategoryController::class, 'SubCategoryDelete'])->name('subcategory.delete');

    // Admin Sub-> SubCategory All Routes all.subcategory
    Route::get('/sub/sub/view', [SubCategoryController::class, 'SubSubCategoryView'])->name('all.subsubcategory');
    Route::get('/subcategory/ajax/{category_id}', [SubCategoryController::class, 'GetSubCategory']);
    Route::get('/sub-subcategory/ajax/{subcategory_id}', [SubCategoryController::class, 'GetSubSubCategory']);
    Route::post('/sub/sub/store', [SubCategoryController::class, 'SubSubCategoryStore'])->name('subsubcategory.store');
    Route::get('/sub/sub/edit/{id}', [SubCategoryController::class, 'SubSubCategoryEdit'])->name('subsubcategory.edit');
    Route::post('/sub/sub/update', [SubCategoryController::class, 'SubSubCategoryUpdate'])->name('subsubcategory.update');
    Route::get('/sub/sub/delete/{id}', [SubCategoryController::class, 'SubSubCategoryDelete'])->name('subsubcategory.delete');
});

// Admin Products All Route
Route::prefix('product')->group(function () {
    Route::get('/add', [ProductController::class, 'AddProduct'])->name('add-product');
    Route::post('/store', [ProductController::class, 'StoreProduct'])->name('product-store');
    Route::get('/manage', [ProductController::class, 'ManageProduct'])->name('manage-product');
    Route::get('/edit/{id}', [ProductController::class, 'EditProduct'])->name('product.edit');
    Route::post('/data/update', [ProductController::class, 'ProductDataUpdate'])->name('product-update');
    Route::post('/image/update', [ProductController::class, 'MultiImageUpdate'])->name('update-product-image');
    Route::post('/thambnial/update', [ProductController::class, 'ThambnialImageUpdate'])->name('update-product-thambnial');
    Route::get('/multiimg/delete/{id}', [ProductController::class, 'MultiimgDeleteProduct'])->name('product.multiimg.delete');
    Route::get('/inactive/{id}', [ProductController::class, 'ProductInactive'])->name('product.inactive');
    Route::get('/active/{id}', [ProductController::class, 'ProductActive'])->name('product.active');
    Route::get('/delete/{id}', [ProductController::class, 'ProductDelete'])->name('product.delete');
    Route::get('/overview/{id}', [ProductController::class, 'ProductView'])->name('product.view');

});

// Admin Slider All Route
Route::prefix('slider')->group(function () {
    Route::get('/view', [SliderController::class, 'SliderView'])->name('manage-slider');
    Route::post('/store', [SliderController::class, 'SliderStore'])->name('slider.store');
    Route::get('/edit/{id}', [SliderController::class, 'SliderEdit'])->name('slider.edit');
    Route::post('/update', [SliderController::class, 'SliderUpdate'])->name('slider.update');
    Route::get('/inactive/{id}', [SliderController::class, 'SliderInactive'])->name('slider.inactive');
    Route::get('/active/{id}', [SliderController::class, 'SliderActive'])->name('slider.active');
    Route::get('/delete/{id}', [SliderController::class, 'SliderDelete'])->name('slider.delete');
});

//// Frontend All Routes /////
/// Multi Language All Routes ////
Route::get('/language/hindi', [LanguageController::class, 'Hindi'])->name('hindi.language');
Route::get('/language/english', [LanguageController::class, 'English'])->name('english.language');
/// Product Details page Url ////
Route::get('/product/details/{id}/{slug}', [IndexController::class, 'ProductDetails']);
/// Frontend Product Tags ////
Route::get('/product/tag/{tag}', [IndexController::class, 'TagWiseProduct']);
/// Frontend SubCategory wise data Tags ////
Route::get('/subcategory/product/{subcat_id}/{slug}', [IndexController::class, 'SubCatWiseProduct']);
/// Frontend SubSubCategory wise data Tags ////
Route::get('/subsubcategory/product/{subsubcat_id}/{slug}', [IndexController::class, 'SubSubCatWiseProduct']);
/// Product View Modal With Ajax ////
Route::get('/product/view/model/{id}', [IndexController::class, 'ProductViewAjax']);
/// Add to Cart ////
Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);
/// Mini Cart Get data ////
Route::get('/product/mini/cart', [CartController::class, 'AddMiniCart']);
/// Remove Mini Cart data ////
Route::get('/minicart/product-remove/{rowId}', [CartController::class, 'RemoveMiniCart']);
/// Add to wishlit ////
Route::post('/add-to-wishlist/{product_id}', [CartController::class, 'AddToWishList']);

/// Wishlist Page ////
Route::group(['prefix'=>'user','middleware'=>['user','auth'],'namespace'=>'User'], function () {
    Route::get('/wishlist', [WishlistController::class, 'ViewWishlist'])->name('wishlist');
    Route::get('/get-wishlist-product', [WishlistController::class, 'GetWishlistProduct']);
    Route::get('/wishlist-remove/{id}', [WishlistController::class, 'RemoveWishlistProduct']);

    /// Payment system Route ////
    Route::post('/stripe/order', [StripeController::class, 'StripeOdrer'])->name('stripe.order');
    Route::get('/my/orders', [AllUserController::class, 'MyOrders'])->name('my.orders');
    Route::get('/order_details/{order_id}', [AllUserController::class, 'OrderDetails']);
    Route::post('/cash/order', [CashController::class, 'CashOrder'])->name('cash.order');
    Route::get('/invoice_download/{order_id}', [AllUserController::class, 'InvoiceDownload']);
});

/// Mycart Page ////
Route::get('/mycart', [MyCartController::class, 'MyCart'])->name('mycart');
Route::get('/user/get-cart-product', [MyCartController::class, 'GetCartProduct']);
Route::get('/user/cart-remove/{rowid}', [MyCartController::class, 'RemoveCartProduct']);
Route::get('/cart-increment/{rowId}', [MyCartController::class, 'CartIncrement']);
Route::get('/cart-decrement/{rowId}', [MyCartController::class, 'CartDecrement']);

// Coupons All Route Start
Route::prefix('coupons')->group(function () {
    Route::get('/view', [CouponsController::class, 'CouponView'])->name('manage-coupon');
    Route::post('/store', [CouponsController::class, 'CouponStore'])->name('coupon.store');
    Route::get('/edit/{id}', [CouponsController::class, 'CouponEdit'])->name('coupon.edit');
    Route::post('/update/{id}', [CouponsController::class, 'CouponUpdate'])->name('coupon.update');
    Route::get('/delete/{id}', [CouponsController::class, 'CouponDelete'])->name('coupon.delete');
});

// Shipping All Route Start
Route::prefix('shipping')->group(function () {
    // For Shipping Division
    Route::get('/division/view', [ShippingAreaController::class, 'DivisionView'])->name('manage-division');
    Route::post('/division/store', [ShippingAreaController::class, 'DivisionStore'])->name('division.store');
    Route::get('/division/edit/{id}', [ShippingAreaController::class, 'DivisionEdit'])->name('division.edit');
    Route::post('/division/update/{id}', [ShippingAreaController::class, 'DivisionUpdate'])->name('division.update');
    Route::get('/division/delete/{id}', [ShippingAreaController::class, 'DivisionDelete'])->name('division.delete');
    // For Shipping District
    Route::get('/district/view', [ShippingAreaController::class, 'DistrictView'])->name('manage-district');
    Route::post('/district/store', [ShippingAreaController::class, 'DistrictStore'])->name('district.store');
    Route::get('/district/edit/{id}', [ShippingAreaController::class, 'DistrictEdit'])->name('district.edit');
    Route::post('/district/update/{id}', [ShippingAreaController::class, 'DistrictUpdate'])->name('district.update');
    Route::get('/district/delete/{id}', [ShippingAreaController::class, 'DistrictDelete'])->name('district.delete');
    // For Shipping State
    Route::get('/state/view', [ShippingAreaController::class, 'StateView'])->name('manage-state');
    Route::post('/state/store', [ShippingAreaController::class, 'StateStore'])->name('state.store');
    Route::get('/state/edit/{id}', [ShippingAreaController::class, 'StateEdit'])->name('state.edit');
    Route::post('/state/update/{id}', [ShippingAreaController::class, 'StateUpdate'])->name('state.update');
    Route::get('/state/delete/{id}', [ShippingAreaController::class, 'StateDelete'])->name('state.delete');
    Route::get('/division/ajax/{division_id}', [ShippingAreaController::class, 'Getdistrict']);
});

// Frontend Coupon Option
Route::post('/coupon-apply', [CartController::class, 'CouponApply']);
Route::get('/coupon-calculation', [CartController::class, 'CouponCalculation']);
Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);
// Check Out Routes
Route::get('/checkout', [CartController::class, 'CheckoutCreate'])->name('checkout');
Route::get('/district-get/ajax/{division_id}', [CheckoutController::class, 'DistrictGetAjax']);
Route::get('/state-get/ajax/{district_id}', [CheckoutController::class, 'StateGetAjax']);
Route::post('/checkout/store', [CheckoutController::class, 'CheckOutStore'])->name('checkout.store');

// Admin Order All Route Start
Route::prefix('orders')->group(function () {
    Route::get('/pending/orders', [OrderController::class, 'PendingOrders'])->name('pending-orders');
    Route::get('/pending/orders/details/{order_id}', [OrderController::class, 'PendingOrdersDetails'])->name('pending.orders.details');
    Route::get('/confirmed/orders', [OrderController::class, 'ConfirmedOrders'])->name('confirmed-orders');
    Route::get('/processing/orders', [OrderController::class, 'ProcessingOrders'])->name('processing-orders');
    Route::get('/picked/orders', [OrderController::class, 'PickedOrders'])->name('picked-orders');
    Route::get('/shipped/orders', [OrderController::class, 'ShippedOrders'])->name('shipped-orders');
    Route::get('/dalivered/orders', [OrderController::class, 'DaliveredOrders'])->name('dalivered-orders');
    Route::get('/cancel/orders', [OrderController::class, 'CancelOrders'])->name('cancel-orders');
    // Update Status
    Route::get('/pending/confirm/{order_id}', [OrderController::class, 'PendingToConfirm'])->name('pending-confirm');
    Route::get('/confirm/processing/{order_id}', [OrderController::class, 'ConfirmToProcessing'])->name('confirm.processing');
    Route::get('/processing/picked/{order_id}', [OrderController::class, 'ProcessingToPicked'])->name('processing.picked');
    Route::get('/picked/shipped/{order_id}', [OrderController::class, 'PickedToShipped'])->name('picked.shipped');
    Route::get('/shipped/dalivered/{order_id}', [OrderController::class, 'ShippedToDalivered'])->name('shipped.dalivered');

    Route::get('/dalivered/cancel/{order_id}', [OrderController::class, 'DaliveredTocancle'])->name('dalivered.cancel');

    Route::get('/invoice/download/{order_id}', [OrderController::class, 'AdminInvoiceDownload'])->name('invoice.download');

    Route::get('/order/delete/{order_id}', [OrderController::class, 'DeleteOrder'])->name('delete_order');

    Route::post('/return/order/{order_id}', [OrderController::class, 'ReturnOrder'])->name('return.order');

    Route::get('/return/order/list', [OrderController::class, 'ReturnOrderList'])->name('return.order.list');
    Route::get('/all/cancel/orders', [OrderController::class, 'UserCancelOrders'])->name('cancel.orders');

});

// Admin Reports Route
Route::prefix('reports')->group(function () {
    Route::get('/view', [ReportsController::class, 'ReportView'])->name('all-reports');
    Route::post('/search/by/date', [ReportsController::class, 'ReportByDate'])->name('search-by-date');
    Route::post('/search/by/month', [ReportsController::class, 'ReportByMonth'])->name('search-by-month');
    Route::post('/search/by/year', [ReportsController::class, 'ReportByYear'])->name('search-by-year');
});

// Admin Get All User Route
Route::prefix('alluser')->group(function () {

    Route::get('/view', [AdminProfileController::class, 'AllUsers'])->name('all-users');

});

