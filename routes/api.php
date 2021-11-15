<?php

use Carbon\Carbon;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Catalog\CatalogController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/pay/result', function(Request $request) {
    file_put_contents('file.txt', json_encode($request->all()));
    $carbon = new Carbon($request->pg_payment_date);
    Store::where('id', $request->store_id)->update(['isPaid' => 1, 'paid_date' => Carbon::parse($request->pg_payment_date)->format('Y-m-d H:m'), 'end_paid_date' => $carbon->addMonth(), 'isActive' => 1, 'status' => 1]);
});

Route::get('catalogs/{id}', [CatalogController::class, 'get']);
Route::get('subcatalogs/{id}', [CatalogController::class, 'getSub']);
Route::get('items/{id}', [CatalogController::class, 'getItem']);

