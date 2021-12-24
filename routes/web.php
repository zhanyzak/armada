<?php

use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Pages\FaqController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\NewsController;
use App\Http\Controllers\Pages\ShopController;
use App\Http\Controllers\Pages\TourController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Pages\AboutController;
use App\Http\Controllers\Pages\SchemeController;
use App\Http\Controllers\Pages\TenantController;
use App\Http\Controllers\Pages\CatalogController;
use App\Http\Controllers\Pages\ContactController;
use App\Http\Controllers\Pages\PaymentController;
use App\Http\Controllers\Pages\ProductController;
use App\Http\Controllers\Pages\ProjectController;
use App\Http\Controllers\Pages\ServiceController;
use App\Http\Controllers\Pages\DeliveryController;
use App\Http\Controllers\Pages\HowToBuyController;
use App\Http\Controllers\Pages\IdeaCareController;
use App\Http\Controllers\Pages\ForSellerController;
use App\Http\Controllers\Pages\AdvertiserController;
use App\Http\Controllers\Pages\FurnitureCareController;


// ,'middleware' => 'throttle:10|60,1'
Route::group(['prefix' => App\Http\Middleware\Locale::getLocale()],// максимум 10 запросов в минуту для гостей и 60 для пользователей
    function () {

        Auth::routes();

        require('_auth.php');
        require('_user.php');
        require('_seller.php');
        require('_admin.php');
//        require('_general.php');

//        Route::post('/payment',[NewsCommentController::class,'store'])
//            ->name('newsComments.store'); // ?????

        Route::get('test', function () {
            return 'Test';
        });

        Route::view('/clear','clear');
        Route::get('/pay',[IndexController::class,'pay'])
            ->name('pay');
        Route::post('/pay-ok',[IndexController::class,'payOk'])
            ->name('payOk');
        Route::post('/pay-error',[IndexController::class,'payError'])
            ->name('payError');

        Route::post('/subscription',[IndexController::class,'subscription'])
            ->name('subscription');

        Route::get('/catalogs/{slug}',[CatalogController::class,'index'])
            ->name('catalogs');
        Route::get('/catalog/{slug}',[CatalogController::class,'show'])
            ->name('catalog');
        Route::get('/subcatalog/{slug}',[CatalogController::class,'subcatalogShow'])
            ->name('subcatalog');
        Route::get('/item/{slug}',[CatalogController::class,'itemShow'])
            ->name('item');

        Route::get('/product/{id}-{slug}',[ProductController::class,'product'])
            ->name('product');
        Route::post('/product-like',[ProductController::class,'productLike'])
            ->name('productLike');
        Route::post('/product-review',[ProductController::class,'productReview'])
            ->name('productReview');

        Route::get('/',[HomeController::class,'home'])
            ->name('home');
        Route::get('/banner',[IndexController::class,'banner'])
            ->name('banner');
        Route::post('/callback',[IndexController::class,'callback'])
            ->name('callback');
        Route::get('/search',[IndexController::class,'searchGet'])
            ->name('searchGet');
        Route::post('/search',[IndexController::class,'search'])
            ->name('search');
        Route::post('/search-store',[IndexController::class,'searchStore'])
            ->name('searchStore');
        // Статические страницы
        Route::get('/payment',[PaymentController::class,'index']) //
            ->name('payment');
        Route::get('/tenants',[TenantController::class,'index']) //
            ->name('tenants');
        Route::get('/about',[AboutController::class,'index']) //
            ->name('about');
        Route::get('/faqs',[FaqController::class,'index']) //
            ->name('faqs');

        Route::get('/delivery',[DeliveryController::class,'index'])
            ->name('delivery');

        Route::get('/projects',[ProjectController::class,'index']) //+-
            ->name('projects');
        Route::get('/promoters',[AdvertiserController::class,'index'])
            ->name('advertisers');
        Route::post('/application-post',[ApplicationController::class,'store'])
            ->name('applicationPost');

        Route::get('/contacts',[ContactController::class,'index'])
            ->name('contacts');
        Route::post('/contacts-post',[ContactController::class,'store'])
            ->name('contactsPost');

        Route::get('/furniture-care',[FurnitureCareController::class,'index'])
            ->name('furnitureCare');
        Route::get('/how-to-buy',[HowToBuyController::class,'index'])
            ->name('howToBuy');
        Route::get('/for-seller',[ForSellerController::class,'index'])
            ->name('forSeller');
        Route::get('/ideas',[IdeaCareController::class,'index'])
            ->name('ideas');
        Route::get('/scheme',[SchemeController::class,'index'])
            ->name('scheme');
        Route::get('/scheme-search',[SchemeController::class,'search'])
            ->name('scheme-search');
        Route::get('/services',[ServiceController::class,'index'])
            ->name('services');

        Route::get('/tour',[TourController::class,'index'])
            ->name('tour');

        Route::group(['namespace' => 'Pages'], function () {
            Route::get('/sitemap', 'SitemapController@index')
                ->name('sitemap');
        });

        Route::get('/news',[NewsController::class,'index'])
            ->name('news.index');
        Route::get('/news/{slug}',[NewsController::class,'show'])
            ->name('news.show');
        Route::post('/news-comments',[NewsController::class,'newsComments'])
            ->name('newsComments.store');

        Route::get('/prodavcy',[ShopController::class,'index'])
            ->name('shops');
        Route::get('/prodavcy/{slug}',[ShopController::class,'show'])
            ->name('shop');
        Route::post('/prodavcy-comments',[ShopController::class,'shopComments'])
            ->name('shopComments');

        Route::get('/pay/success', function(Request $request) {
            file_put_contents('file.txt', $request->all());
            return redirect()->route('seller.stores.index');
        });

        Route::get('/exe', function(){
            // $sellers = DB::table('users')->select('email')->get()->pluck('email');
            // $users = DB::table('sellers2')->whereNotIn('email', $sellers)->get()->pluck('email');

            // file_put_contents('users.txt', $users.PHP_EOL, FILE_APPEND);

            // return $sellers;

            $stores = DB::table('stores_old')->select('id', 'logo', 'mini_img')->get();

            foreach($stores as $store)
            {
                DB::table('stores')->where('id', $store->id)->update(['logo' => json_encode($store->logo), 'mini_img' => json_encode($store->mini_img)]);
                print_r (["$store->logo"]);
                echo '<br />';
            }
        });
    });

//Переключение языков
//require('_setlocale.php');



Route::prefix('update')->group(function () {
    Route::get('/sellers', function() {
        $sellers_old = DB::table('sellers_old')->get();

        foreach($sellers_old as $item)
        {
            $sellers = DB::table('sellers')->insert([
                        'id'              => $item->id,
                        'isActive'        => $item->isActive,
                        'name'            => $item->name,
                        'email'           => $item->email,
                        'password'        => $item->password,
                        'created_at'      => $item->created_at,
                        'updated_at'      => now(),
                        'slug'            => $item->slug,
                        'remember_token'  => $item->remember_token,
                        'active'          => $item->active,
                        'last_login_date' => $item->last_login_date,
                        'ip_address'      => $item->ip_address,
                        'partner'         => $item->partner,
                        'hcb_link'        => $item->hcb_link,
                        'img'             => $item->img,
            ]);
            // $sellers = DB::table('sellers')
            //               //->where('id', $item->id)
            //               ->update([
            //                   'id' => $item->id
            //               ],[
            //                   'id'              => $item->id,
            //                   'isActive'        => $item->isActive,
            //                   'name'            => $item->name,
            //                   'email'           => $item->email,
            //                   'password'        => $item->password,
            //                   'created_at'      => $item->created_at,
            //                   'updated_at'      => now(),
            //                   'slug'            => $item->slug,
            //                   'remember_token'  => $item->remember_token,
            //                   'active'          => $item->active,
            //                   'last_login_date' => $item->last_login_date,
            //                   'ip_address'      => $item->ip_address,
            //                   'partner'         => $item->partner,
            //                   'hcb_link'        => $item->hcb_link,
            //                   'img'             => $item->img,
            //               ]);
        }

        if($sellers)
        {
            return 'Успех';
        }

        return 'Фэйл!';
    });

    Route::get('stores', function() {
        $oldStores = DB::table('stores_last')->get();

        //return count($oldStores);

        $chunk_data = array_chunk($oldStores->toArray(), 50);

        //dd($chunk_data);

        foreach($chunk_data as $chunk_oldStores)
        {
            foreach($chunk_oldStores as $oldStore)
            {

                // $stores = DB::table('stores_new')
                //             ->insert(
                //                 [
                //                     'id'               => $oldStore->id,
                //                 ]);
                //return $oldStore;
                $stores = DB::table('stores_new')
                            ->where('id', $oldStore->id)
                            ->update(
                                [
                                    //'id'               => $oldStore->id,
                                    'status'           => $oldStore->status,
                                    'isActive'         => $oldStore->status,
                                    'user_id'          => 0,
                                    'slug'             => $oldStore->slug,
                                    'title'            => $oldStore->title,
                                    'letter'           => mb_substr(ucfirst($oldStore->title), 0, 1),
                                    'seo_title'        => $oldStore->seo_title,
                                    'original_title'   => $oldStore->original_title,
                                    'meta_description' => $oldStore->meta_description,
                                    'mini_desc'        => $oldStore->mini_desc,
                                    'description'      => $oldStore->description,
                                    'logo'             => [$oldStore->logo],
                                    'mini_img'         => [$oldStore->mini_img],
                                    'email'            => $oldStore->email,
                                    'phones'           => $oldStore->phones,
                                    'web_url'          => $oldStore->web_url,
                                    'instagram'        => $oldStore->instagram,
                                    'facebook'         => $oldStore->facebook,
                                    'youtube'          => $oldStore->youtube,
                                    'vkontakte'        => $oldStore->vkontakte,
                                    'address'          => $oldStore->address,
                                    'block'            => $oldStore->block,
                                    'intersection'     => $oldStore->intersection,
                                    'butik'            => $oldStore->butik,
                                    'work_times'       => '["Пн-Вс 10:00-20:00"]',
                                    'works_days'       => 'Пн-Вс',
                                    'is_delivery'      => $oldStore->is_delivery,
                                    'tarif_id'         => $oldStore->tarif_id,
                                    'tarif_end_date'   => \Carbon\Carbon::now()->addMonth(),
                                    'msg_for_seller'   => $oldStore->msg_for_seller,
                                    'search_tags'      => $oldStore->search_tags,
                                    'search_map_tags'  => $oldStore->search_map_tags,
                                    'wallpaper'        => $oldStore->wallpaper,
                                    'slider'           => $oldStore->slider,
                                    'work_dop'         => $oldStore->work_dop,
                                    'hits'             => $oldStore->hits,
                                    'hot'              => $oldStore->hot,
                                    'mappoints'        => $oldStore->mappoints,
                                    'mob_phone'        => $oldStore->mob_phone,
                                    'updated_at'       => now(),
                                    'created_at'       => $oldStore->created_at,
                                ]);
            }
        }

        if($stores)
        {
            return 'Успех';
        }

        return 'Фэйл!';

    });


    Route::get('products', function() {
        $products = DB::table('products_last')->where('status', 1)->where('item_id', 125)->get();

        return count($products);

        $chunk_array = array_chunk($products->toArray(), 5000);

        foreach ($chunk_array as $products)
        {
            foreach($products as $product)
            {
                $stores = DB::table('products_new')
                            //->where('id', $product->id)
                            ->insert(
                                [
                                    'id'               => $product->id,
                                    'status'           => $product->status,
                                    'isActive'         => $product->status,
                                    'user_id'          => 0,
                                    'store_id'         => $product->store_id,
                                    'catalog_id'       => $product->catalog_id,
                                    'subcatalog_id'    => $product->subcatalog_id,
                                    'item_id'          => $product->item_id,
                                    'slug'             => $product->slug,
                                    'title'            => $product->title,
                                    'price'            => $product->price,
                                    'description'      => $product->description,
                                    'articul'          => $product->articul,
                                    'images'           => $product->images,
                                    'colors'           => $product->colors,
                                    'manufacture'      => $product->manufacture,
                                    'width'            => $product->width,
                                    'height'           => $product->height,
                                    'origin'           => $product->origin,
                                    'depth'            => $product->depth,
                                    'seo_title'        => $product->seo_title,
                                    'meta_description' => $product->meta_description,
                                    'meta_tags'        => $product->meta_tags,
                                    'hits'             => $product->hits,
                                    'fiver'            => $product->fiver,
                                    'used'             => $product->used,
                                    'update_date'      => $product->update_date,
                                    'updated_at'       => now(),
                                    'created_at'       => $product->created_at,
                                ]);
            }
        }



        if($stores)
        {
            return 'Успех';
        }

        return 'Фэйл!';

    });

    Route::get('/users', function() {
        $sellers_old = DB::table('sellers_old')->get();

        foreach($sellers_old as $item)
        {
            $sellers = DB::table('users')->insert([
                        'id'              => $item->id,
                        'isActive'        => $item->isActive,
                        'name'            => $item->name,
                        'email'           => $item->email,
                        'password'        => $item->password,
                        'created_at'      => $item->created_at,
                        'updated_at'      => now(),
                        //'slug'            => $item->slug,
                        'remember_token'  => $item->remember_token,
                        //'active'          => $item->active,
                        'last_login_date' => $item->last_login_date,
                        'ip_address'      => $item->ip_address,
                        'partner'         => $item->partner,
                        'hcb_link'        => $item->hcb_link,
                        'img'             => $item->img,
                        'seller_device_info' => $item->seller_device_info,
            ]);
            // $sellers = DB::table('sellers')
            //               //->where('id', $item->id)
            //               ->update([
            //                   'id' => $item->id
            //               ],[
            //                   'id'              => $item->id,
            //                   'isActive'        => $item->isActive,
            //                   'name'            => $item->name,
            //                   'email'           => $item->email,
            //                   'password'        => $item->password,
            //                   'created_at'      => $item->created_at,
            //                   'updated_at'      => now(),
            //                   'slug'            => $item->slug,
            //                   'remember_token'  => $item->remember_token,
            //                   'active'          => $item->active,
            //                   'last_login_date' => $item->last_login_date,
            //                   'ip_address'      => $item->ip_address,
            //                   'partner'         => $item->partner,
            //                   'hcb_link'        => $item->hcb_link,
            //                   'img'             => $item->img,
            //               ]);
        }

        if($sellers)
        {
            return 'Успех';
        }

        return 'Фэйл!';
    });
});

Route::prefix('truncate')->group(function () {
    Route::get('products', function () {
        DB::table('products_new')->truncate();
    });
});

Route::prefix('truncate')->group(function () {
    Route::get('stores', function () {
        DB::table('stores_new')->truncate();
    });
});


Route::get('get-stores', function(){
    $stores = Store::get();

    return $stores->count();
});
