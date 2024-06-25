<?php

use Illuminate\Support\Facades\Route;
use App\Domains\User\Repositories\UserRepository;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'language'], function () {

  
   
   
    Route::get('/', [App\Http\Controllers\Public\HomePageController::class,'index'])->name('home-page');
    Route::post('/site-lang', [App\Http\Controllers\Public\HomePageController::class,'site_lang'])->name('site-lang');
    Route::resource('contact', App\Http\Controllers\Public\ContactController::class);
    Route::resource('contact', App\Http\Controllers\Public\ContactController::class);
    Route::post('/contact-email', '\App\Http\Controllers\Public\ContactController@contact_email')->name('contact-email');
    //vendors
    Route::resource('vendors', App\Http\Controllers\VendorsController::class);

    Route::resource('suppliers', App\Http\Controllers\SuppliersController::class);
     //customers
     Route::resource('customers', App\Http\Controllers\CustomersController::class);
        
    Route::resource('blog', App\Http\Controllers\Public\BlogController::class);
    Route::resource('cart', App\Http\Controllers\Public\CartController::class);
    Route::resource('wishlist', App\Http\Controllers\Public\WishlistController::class);
    Route::resource('checkout', App\Http\Controllers\Public\CheckoutController::class);
    Route::resource('painting', App\Http\Controllers\Public\PaintingController::class);
    Route::resource('invoice', App\Http\Controllers\Public\InvoiceController::class);

    Route::post('/makePaintingAs', '\App\Http\Controllers\Public\PaintingController@makePaintingAs')->name('makePaintingAs');

    Route::resource('painting-category', App\Http\Controllers\Public\PaintingsCategoryController::class);
    Route::resource('artists/list', App\Http\Controllers\Public\ArtistsController::class);
    Route::get('/artist-profile/{id}',[App\Http\Controllers\Public\ArtistsController::class, 'profile'])->name('artist-profile');
    Route::resource('coupons', App\Http\Controllers\CouponsController::class);
    Route::post('/validate-coupon', '\App\Http\Controllers\CouponsController@validateCoupon')->name('validate-coupon');


    // Customer routes
    Route::group(['middleware' => 'auth:customer',], function () {
        Route::get('/customer',[App\Http\Controllers\CustomersController::class, 'profile'])->name('customer');
        Route::get('/edit-profile-customer',[App\Http\Controllers\CustomersController::class, 'edit_profile'])->name('edit-profile-customer');
        Route::POST('/cart_action', '\App\Http\Controllers\Public\CartController@cart_action')->name('cart_action');
        Route::prefix('customer')->group(function () {
            Route::resource('purchases', App\Http\Controllers\CustomerPurchasesController::class, ['names' => 'customer_purchases']);
            Route::resource('addresses', App\Http\Controllers\AddressesController::class, ['names' => 'customer_addresses']);
        });
    });

    Route::get('checkout/thank-you/{order_id}', '\App\Http\Controllers\Public\CheckoutController@thankYou')->name('thank_you');

    // Vendor routes
    Route::group(['middleware' => 'auth:vendor',], function () {
        Route::get('/vendor',[App\Http\Controllers\VendorsController::class, 'profile'])->name('vendor');
        Route::get('/edit-profile-vendor',[App\Http\Controllers\VendorsController::class, 'edit_profile'])->name('edit-profile-vendor');

        Route::prefix('vendor')->group(function () {
            Route::resource('paintings', App\Http\Controllers\VendorPaintingsController::class, ['names' => 'vendor_paintings']);
            Route::resource('sales', App\Http\Controllers\VendorSalesController::class, ['names' => 'vendor_sales']);
            Route::get('/find/rooms', '\App\Http\Controllers\RoomsController@findRooms');
            Route::post('/upload-image-gallery', '\App\Http\Controllers\PaintingsController@upload_image_gallery');
            Route::get('/remove_image_gallery', '\App\Http\Controllers\PaintingsController@remove_image_gallery')->name('vendor_remove_image_gallery');
            Route::resource('certificates', App\Http\Controllers\VendorCertificatesController::class, ['names' => 'vendor_certificates']);
        });
    });
    // dashboard routes
    Route::group(['middleware' => 'auth:web','auth:vendor'], function () {
        
    Route::group(['middleware' => 'permissions'], function () {
    Route::get('/admin',[App\Http\Controllers\HomeController::class, 'index'])->name('admin');

    //permissions
    Route::resource('permissions', App\Http\Controllers\PermissionsController::class);
    Route::get('/permissions', '\App\Http\Controllers\PermissionsController@index')->name('permissions');
    Route::get('/permissions', '\App\Http\Controllers\PermissionsController@index')->name('permissions');
    Route::get('/selected-role', '\App\Http\Controllers\PermissionsController@get_role_permissions')->name('selected-role');

   
    //auth
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
   
    //users
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('/edit-profile/{id}', '\App\Http\Controllers\UserController@edit_profile')->name('edit-profile');
    Route::resource('roles', App\Http\Controllers\RolesController::class);

    //navbar notifications
    Route::POST('/alerts-seen', '\App\Http\Controllers\UserController@alerts_seen')->name('alerts-seen');
    Route::get('/get-alerts', '\App\Http\Controllers\UserController@get_alerts')->name('get-alerts');

    //customers
    Route::get('/find/customers', '\App\Http\Controllers\CustomersController@findCustomers');

    //artists
    Route::resource('artists', App\Http\Controllers\ArtistsController::class);

   

    //categories
    Route::resource('categories', App\Http\Controllers\CategoriesController::class);
    
    //Themes
    Route::resource('themes', App\Http\Controllers\ThemesController::class);

    //Styles
    Route::resource('styles', App\Http\Controllers\StylesController::class);

    //Colors
    Route::resource('colors', App\Http\Controllers\ColorsController::class);

    //Locations
    Route::resource('locations', App\Http\Controllers\LocationsController::class);
    Route::get('/allCitiesByCountry','\App\Http\Controllers\LocationsController@allCitiesByCountry')->name('allCitiesByCountry');
    Route::get('/locations/stock/{id}','\App\Http\Controllers\LocationsController@stock')->name('locations.stock');
    Route::get('/locations/transfer/{id}/{item_id}','\App\Http\Controllers\LocationsController@transfer')->name('locations.transfer');
    Route::post('/locations/transfer/{from_location}/{item_id}', '\App\Http\Controllers\LocationsController@transferToLocation')->name('locations.transfer_to_location');



    //Paintings
    Route::resource('paintings', App\Http\Controllers\PaintingsController::class);
    Route::POST('/upload-image-gallery', '\App\Http\Controllers\PaintingsController@upload_image_gallery')->name('upload-image-gallery');
    Route::GET('/remove_image_gallery', '\App\Http\Controllers\PaintingsController@remove_image_gallery')->name('remove_image_gallery');
    Route::get('/find/paintings', '\App\Http\Controllers\PaintingsController@findPaintings');

    //Addons
    Route::resource('addons', App\Http\Controllers\AddonsController::class);
    Route::resource('addonsItems', App\Http\Controllers\AddonsItemsController::class);
    Route::get('/addonsItems-form/{id}', '\App\Http\Controllers\AddonsItemsController@form')->name('addonsItems-form');
    Route::get('/items/find', '\App\Http\Controllers\AddonsItemsController@findItems');

    //Certificates
    Route::resource('certificates', App\Http\Controllers\CertificatesController::class);

    


    //settings
    Route::POST('/save-settings', '\App\Http\Controllers\SettingsController@save_settings')->name('save-settings');
    Route::resource('settings', App\Http\Controllers\SettingsController::class);
    

    //cookie sidebar
    Route::POST('/cookie-set','\App\Http\Controllers\CookieController@setCookie')->name('cookie-set');
    Route::get('/cookie-get','\App\Http\Controllers\CookieController@getCookie')->name('cookie-get');

    //Purchase Orders
    Route::resource('purchase-orders', App\Http\Controllers\PurchaseOrdersController::class);

    //Sales Orders
    Route::resource('sales-orders', App\Http\Controllers\SalesOrdersController::class);
    Route::POST('/sales-orders/approve/{id}','\App\Http\Controllers\SalesOrdersController@approve')->name('sales-orders.approve');
    Route::POST('/sales-orders/reject/{id}','\App\Http\Controllers\SalesOrdersController@reject')->name('sales-orders.reject');

    //Returns Orders
    Route::resource('returns', App\Http\Controllers\ReturnsController::class);

    //vendors
    Route::resource('rooms', App\Http\Controllers\RoomsController::class);
    Route::get('/find/rooms', '\App\Http\Controllers\RoomsController@findRooms');
    
    //course categories
    Route::resource('course-categories', App\Http\Controllers\CourseCategoriesController::class);
    Route::resource('courses', App\Http\Controllers\CoursesController::class);
    Route::get('/courses-create/{id}', '\App\Http\Controllers\CoursesController@form')->name('courses-form');
    Route::get('/find/courses', '\App\Http\Controllers\CoursesController@findCourses');

    //assets / assets categories
    Route::resource('asset-categories', App\Http\Controllers\AssetCategoriesController::class);
    Route::resource('assets', App\Http\Controllers\AssetsController::class);
    Route::get('/assets-create/{id}', '\App\Http\Controllers\AssetsController@form')->name('assets-form');
    Route::get('/assets-owners/{id}', '\App\Http\Controllers\AssetsController@owners')->name('assets-owners');
    Route::get('/find/assets', '\App\Http\Controllers\AssetsController@findAssets');
    Route::post('/assets-assign/{id}', '\App\Http\Controllers\AssetsController@assign')->name('assign-assets');
    Route::delete('/assets-unassign/{id}', '\App\Http\Controllers\AssetsController@unassign')->name('unassign-assets');
    //history
    Route::get('/history/{model_name}/{model_id}', '\App\Http\Controllers\HistoryController@display')->name('display-history');

    //posts
    Route::resource('posts', App\Http\Controllers\BlogsController::class);
    //pages
    Route::resource('pages', App\Http\Controllers\PagesController::class);
    //slider
    Route::resource('slides', App\Http\Controllers\SlidesController::class);

    Route::resource('coupons', App\Http\Controllers\CouponsController::class);

});
    });

    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Auth::routes();
});