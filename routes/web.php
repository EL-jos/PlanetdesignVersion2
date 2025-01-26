<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
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

Route::controller(\App\Http\Controllers\frontend\PageController::class)->group(function (){
    Route::get('/', 'home')->name('home.page');
    Route::get('/category', 'category')->name('category.page');
    Route::get('/arrival', 'arrival')->name('arrival.page');
    Route::get('/category/article', 'article')->name('article.page');
    Route::get('/catalog', 'catalog')->name('catalog.page');
    Route::get('/wishlist', 'wishlist')->name('wishlist.page');
    Route::get('/add/{id}/{model}/wishlist', 'addWishlist')->name('addWishlist.page')->where('model', '.*');
    Route::delete('/remove/wishlistItem/{wishlistItem}', 'removeFromWishlist')->name('wishlist.remove');
    Route::get('/cart', 'cart')->name('cart.page');
    Route::get('/destocking', 'destocking')->name('destocking.page');
    Route::get('/business', 'business')->name('business.page');
    Route::get('/catalogs', 'catalogs')->name('catalogs.page');
    Route::get('/identification', 'identification')->name('identification.page');
    Route::get('/add/{id}/{model}/cart', 'addCart')->name('addCart.page')->where('model', '.*');
    Route::delete('/remove/cartItem/{cartItem}', 'removeFromCart')->name('cart.remove');
    Route::post('/update/quantity/{cartItem}', 'updateCartQuantity')->name('cart.update.quantity');
    Route::get('/add/{id}/{model}/catalog', 'addCatalog')->name('addCatalog.page')->where('model', '.*');
    Route::delete('/remove/catalogItem/{catalogItem}', 'removeFromCatalog')->name('catalog.remove');
    Route::post('/page/search', 'search')->name('search.page');
    Route::get('/page/content/{article}', 'content')->name('content.page');

    Route::get('/category/{categorySlug}', 'show_category')->name('category.show');
    Route::get('/category/{categorySlug}/{subcategorySlug}', 'show_subcategory')->name('subcategory.show');
    Route::get('/article/{articleSlug}/{articleRef}', 'show_article')->name('article.show');

    Route::get('/articles/generate-pdf/catalog', 'generateCatalogPdf')->name('generate.catalog');
    Route::post('/cart/send', 'sendDevis')->name('sendCart.cart');
    Route::delete('/cart/destroy/', 'destroyAllCartOfThisUser')->name('destroyAllCartOfThisUser.cart');
    //Route::get('/favorite/add/cart/{id}/{model}', 'addCart')->name('wishlist.cart');
});

Route::controller(\App\Http\Controllers\AuthController::class)->group(function (){
    Route::post('/login', 'login')->name('login.user');
    Route::post('/logout', 'logout')->name('logout.user');
    Route::post('/register', 'register')->name('register.user');
    Route::get('/active/{user}', 'activeAccount')->name('activeAccount.auth');
});

Route::controller(\App\Http\Controllers\backend\ArticleController::class)->group(function (){
    Route::post('/article/{article}/addQuote', 'addQuote')->middleware("htmlx")->name('addQuote.article');
    //Route::post('/article/{article}/addCatalog', 'addCatalog')->middleware("htmlx")->name('addCatalog.article');
    Route::post('/ajax/filter-articles', 'filterArticles')->name('filter.articles');
    Route::get('/generate-pdf/{article}', 'generateCatalogPdf')->name('generate.pdf');
    Route::get('/article/read/{quote}', 'read')->name('read.article');
    Route::get('/article/export', 'export')->name('article.export');
});

/*Route::controller(\App\Http\Controllers\backend\QuoteController::class)->group(function (){
    Route::delete('/quote/destroy/{user}', 'destroyAllQuoteOfThisUser')->name('destroyAllQuoteOfThisUser.quote');
    Route::get('/modify-quantity-of-quote/quote/{quote}', 'modifyQuantityOfQuote')->middleware("htmlx")->name('modifyQuantityOfQuote.quote');
    Route::post('/send-devis/{user}', 'sendDevis')->name('sendDevis.quote');
    Route::post('/add/quote/public', 'sendQuotePublic')->name('send.quote.public');

});*/

Route::controller(\App\Http\Controllers\DevisController::class)->group(function (){
    Route::delete('/devis/destroy/{user_agent}/{ip_address}', 'destroyAllQuoteOfThisUser')->name('destroyAllQuoteOfThisUser.devis');
    Route::get('/modify-quantity-of-quote/devis/{devis}', 'modifyQuantityOfQuote')->middleware("htmlx")->name('modifyQuantityOfQuote.devis');
    Route::post('/devis/send-devis', 'sendDevis')->name('send.devis.public');

});

Route::controller(\App\Http\Controllers\FavoriteController::class)->group(function (){
    //Route::get('/favorite/{article}/{user?}', 'toggle')->middleware("htmlx")->name('favorite');
    Route::get('/favorite/add/cart/{id}/{model}', 'addToQuote')->name('wishlist.cart');

});


//Route::get('/catalog/{user}/{article}', ['as' => 'catalog', 'uses' => 'App\\Http\\Controllers\\CatalogController@toggle'])->middleware("htmlx");
//Route::get('/articles/generate-pdf/catalog', ['as' => 'generate.catalog', 'uses' => 'App\\Http\\Controllers\\CatalogController@generateCatalogPdf']);
Route::get('/images/article/{path}', ['as' => 'show.image', 'uses' => 'App\\Http\\Controllers\\ImageController@show'])->where('path', '.*');
//Route::post('/add/quote/public/{article}', ['as' => 'send.quote.public', 'uses' => 'App\\Http\\Controllers\\QuoteController@sendQuotePublic']);


Route::group(['prefix' => 'deleted'], function (){
    Route::get('/category', ['as' => 'category.deleted', 'uses' => 'App\\Http\\Controllers\\CategoryController@deleted']);
    Route::get('/subcategory', ['as' => 'subcategory.deleted', 'uses' => 'App\\Http\\Controllers\\SubcategoryController@deleted']);
    Route::get('/color', ['as' => 'color.deleted', 'uses' => 'App\\Http\\Controllers\\ColorController@deleted']);
    Route::get('/material', ['as' => 'material.deleted', 'uses' => 'App\\Http\\Controllers\\MaterialController@deleted']);
    Route::get('/article', ['as' => 'article.deleted', 'uses' => 'App\\Http\\Controllers\\ArticleController@deleted']);
    Route::get('/size', ['as' => 'size.deleted', 'uses' => 'App\\Http\\Controllers\\SizeController@deleted']);
});

Route::group(['prefix' => 'restore'], function (){
    Route::get('/category/{category}', ['as' => 'category.restore', 'uses' => 'App\\Http\\Controllers\\CategoryController@restore']);
    Route::get('/subcategory/{subcategory}', ['as' => 'subcategory.restore', 'uses' => 'App\\Http\\Controllers\\SubcategoryController@restore']);
    Route::get('/color/{color}', ['as' => 'color.restore', 'uses' => 'App\\Http\\Controllers\\ColorController@restore']);
    Route::get('/material/{material}', ['as' => 'material.restore', 'uses' => 'App\\Http\\Controllers\\MaterialController@restore']);
    Route::get('/article/{article}', ['as' => 'article.restore', 'uses' => 'App\\Http\\Controllers\\ArticleController@restore']);
    Route::get('/size/{size}', ['as' => 'size.restore', 'uses' => 'App\\Http\\Controllers\\SizeController@restore']);
});

Route::group(['prefix' => 'remove'], function (){
    Route::get('/category/{category}', ['as' => 'category.remove', 'uses' => 'App\\Http\\Controllers\\CategoryController@remove']);
    Route::get('/subcategory/{subcategory}', ['as' => 'subcategory.remove', 'uses' => 'App\\Http\\Controllers\\SubcategoryController@remove']);
    Route::get('/color/{color}', ['as' => 'color.remove', 'uses' => 'App\\Http\\Controllers\\ColorController@remove']);
    Route::get('/material/{material}', ['as' => 'material.remove', 'uses' => 'App\\Http\\Controllers\\MaterialController@remove']);
    Route::get('/article/{article}', ['as' => 'article.remove', 'uses' => 'App\\Http\\Controllers\\ArticleController@remove']);
    Route::get('/size/{size}', ['as' => 'size.remove', 'uses' => 'App\\Http\\Controllers\\SizeController@remove']);
});

Route::controller(\App\Http\Controllers\Admin\AdministratorController::class)->group(function (){
    Route::match(['GET', 'POST'], '/admin/login', 'login')->name('admin.login');
});

Route::group(['prefix' => 'backend'], function () {

    Route::controller(\App\Http\Controllers\backend\PageController::class)->group(function () {
        Route::get('/', 'dashboard')->name('backend.dashboard');
        route::get('/invoice-print/{order}', 'invoicePrint')->name('backend.invoice.print');
    });

    /*Route::controller(\App\Http\Controllers\backend\CategoryController::class)->group(function () {
        Route::post('category/update-document/{category}', 'uploadDocument')->name('category.uploadDocument');
        Route::get('/get-categories', 'getCategories')->name('category.getCategories');
    });*/
    Route::controller(\App\Http\Controllers\backend\ArticleController::class)->group(function () {
        Route::post('article/update-document/{article}', 'uploadDocument')->name('article.uploadDocument');
        Route::get('/get-articles', 'getArticles')->name('category.getArticles');
        Route::get('/trashed/articles', 'trashed')->name('article.trashed');
        Route::delete('/restore/article/{article}', 'restore')->name('article.restore');
        Route::delete('/remove/article{article}', 'remove')->name('article.remove');
    });

    Route::controller(\App\Http\Controllers\backend\VariantController::class)->group(function () {
        Route::post('variant/update-document/{variant}', 'uploadDocument')->name('variant.uploadDocument');
        Route::get('/trashed/variants', 'trashed')->name('variant.trashed');
        Route::delete('/restore/variant/{variant}', 'restore')->name('variant.restore');
        Route::delete('/remove/variant{variant}', 'remove')->name('variant.remove');
    });

    Route::controller(\App\Http\Controllers\backend\ColorController::class)->group(function () {
        Route::post('color/update-document/{color}', 'uploadDocument')->name('color.uploadDocument');
    });

    Route::controller(\App\Http\Controllers\backend\DocumentController::class)->group(function () {
        Route::delete('/document/{document}/{isMultiple}', 'destroy')->name('document.destroy');
        Route::post('/document/updateDocumentOrder', 'updateDocumentOrder')->name('updateDocumentOrder.document');
    });

    Route::resource('category', \App\Http\Controllers\backend\CategoryController::class)->except(['show']);
    Route::controller(\App\Http\Controllers\backend\CategoryController::class)->group(function () {
        Route::get('/trashed/categories', 'trashed')->name('category.trashed');
        Route::delete('/restore/category/{category}', 'restore')->name('category.restore');
        Route::delete('/remove/category{category}', 'remove')->name('category.remove');
        //Route::post('category/update-document/{category}', 'uploadDocument')->name('category.uploadDocument');
        Route::get('/get-categories', 'getCategories')->name('category.getCategories');
    });

    Route::resource('subcategory', \App\Http\Controllers\backend\SubcategoryController::class)->except(['show']);
    Route::controller(\App\Http\Controllers\backend\SubcategoryController::class)->group(function () {
        Route::get('/trashed/subcategories', 'trashed')->name('subcategory.trashed');
        Route::delete('/restore/subcategory/{subcategory}', 'restore')->name('subcategory.restore');
        Route::delete('/remove/subcategory{subcategory}', 'remove')->name('subcategory.remove');
        Route::get('/get-subCategories', 'getsubCategories')->name('subcategory.getSubCategories');
        Route::get('/get-subCategories/articles', 'getArticles')->name('subcategory.getArticles');
    });

    Route::resource('article', \App\Http\Controllers\backend\ArticleController::class)->except(['show']);
    Route::resource('variant', \App\Http\Controllers\backend\VariantController::class);
    Route::resource('color', \App\Http\Controllers\backend\ColorController::class);
    Route::resource('size', \App\Http\Controllers\backend\SizeController::class);
    Route::resource('quote', \App\Http\Controllers\backend\QuoteController::class);
    Route::resource('availability', \App\Http\Controllers\backend\AvailabilityController::class);
    Route::resource('offer', \App\Http\Controllers\backend\OfferController::class);
    Route::resource('material', \App\Http\Controllers\backend\MaterialController::class);


    /*Route::group(['prefix' => 'trash'], function () {
        Route::controller(\App\Http\Controllers\backend\ArticleController::class)->group(function () {
            Route::get('/article', 'trashed')->name('trashed.article');
            Route::get('/article/restore/{article}', 'restore')->name('restore.article');
        });
        Route::controller(\App\Http\Controllers\backend\VariantController::class)->group(function () {
            Route::get('/variant', 'trashed')->name('trashed.variant');
            Route::get('/variant/restore/{variant}', 'restore')->name('restore.variant');
        });
    });*/

});

/*Route::group(['prefix' => 'admin',  'middleware' => 'admin'], function (){
    Route::resource('category', 'App\\Http\\Controllers\\CategoryController')->except(['show']);
    Route::resource('subcategory', 'App\\Http\\Controllers\\SubcategoryController')->except(['show']);
    Route::resource('image', 'App\\Http\\Controllers\\ImageController');
    Route::resource('color', 'App\\Http\\Controllers\\ColorController');
    Route::resource('material', 'App\\Http\\Controllers\\MaterialController');
    Route::resource('availability', 'App\\Http\\Controllers\\AvailabilityController');
    Route::resource('article', 'App\\Http\\Controllers\\ArticleController')->except(['show']);
    Route::post('/article/search', ['as' => 'search.article', 'uses' => 'App\\Http\\Controllers\\ArticleController@search']);
    Route::resource('quote', 'App\\Http\\Controllers\\QuoteController')->except(['show']);
    //Route::resource('order', 'App\\Http\\Controllers\\OrderController');
    Route::resource('favorite', 'App\\Http\\Controllers\\FavoriteController');
    Route::resource('catalog', 'App\\Http\\Controllers\\CatalogController');
    Route::resource('banner', 'App\\Http\\Controllers\\BannerController');
    Route::resource('deal', 'App\\Http\\Controllers\\DealController');
    Route::resource('size', 'App\\Http\\Controllers\\SizeController');
    Route::resource('offer', 'App\\Http\\Controllers\\OfferController');
    Route::resource('devis', 'App\\Http\\Controllers\\DevisController');

    Route::post('/category/{category}/uploadPhoto', ['as' => 'uploadPhoto.category', 'uses' => 'App\\Http\\Controllers\\CategoryController@uploadPhoto']);
    Route::post('/subcategory/{subcategory}/uploadPhoto', ['as' => 'uploadPhoto.subcategory', 'uses' => 'App\\Http\\Controllers\\SubcategoryController@uploadPhoto']);
    Route::post('/image/updateImageOrder', ['as' => 'updateImageOrder.image', 'uses' => 'App\\Http\\Controllers\\ImageController@updateImageOrder']);
    Route::post('/category/updateOrder', ['as' => 'updateOrder.category', 'uses' => 'App\\Http\\Controllers\\CategoryController@updateOrder']);
    Route::post('/subcategory/updateOrder', ['as' => 'updateOrder.subcategory', 'uses' => 'App\\Http\\Controllers\\SubcategoryController@updateOrder']);
    Route::post('/article/updateOrder', ['as' => 'updateOrder.article', 'uses' => 'App\\Http\\Controllers\\ArticleController@updateOrder']);
    Route::post('/size/updateOrder', ['as' => 'updateOrder.size', 'uses' => 'App\\Http\\Controllers\\SizeController@updateOrder']);
    Route::post('/offer/updateOrder', ['as' => 'updateOrder.offer', 'uses' => 'App\\Http\\Controllers\\OfferController@updateOrder']);
    Route::post('/article/{article}/uploadPhoto', ['as' => 'uploadPhoto.article', 'uses' => 'App\\Http\\Controllers\\ArticleController@uploadPhoto']);
    Route::post('/banner/{banner}/uploadPhoto', ['as' => 'uploadPhoto.banner', 'uses' => 'App\\Http\\Controllers\\BannerController@uploadPhoto']);
    Route::post('/deal/{deal}/uploadPhoto', ['as' => 'uploadPhoto.deal', 'uses' => 'App\\Http\\Controllers\\DealController@uploadPhoto']);
    Route::post('/offer/{offer}/uploadPhoto', ['as' => 'uploadPhoto.offer', 'uses' => 'App\\Http\\Controllers\\OfferController@uploadPhoto']);
});*/
