<?php
Route::get('commerce-analytics', 'AnalyticsController@dashboard');



/*
|--------------------------------------------------------------------------
| Transactions
|--------------------------------------------------------------------------
*/
Route::resource('transactions', 'TransactionController', ['except' => ['create', 'store', 'show', 'destroy']]);
Route::post('transactions/search', 'TransactionController@search');
Route::post('transactions/refund', 'TransactionController@refund');

/*
|--------------------------------------------------------------------------
| Orders
|--------------------------------------------------------------------------
*/
Route::resource('orders', 'OrderController', ['except' => ['create', 'store', 'show', 'destroy']]);
Route::post('orders/search', 'OrderController@search');
Route::post('orders/cancel', 'OrderController@cancel');

Route::get('orders/item/{id}', 'OrderItemController@show');
Route::post('orders/item/cancel', 'OrderItemController@cancel');
