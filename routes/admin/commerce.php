<?php
/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
*/
Route::resource('products', 'ProductController', ['except' => ['show']]);
Route::post('products/search', 'ProductController@search');

Route::post('products/variants/{id}', 'ProductVariantController@variants');
Route::post('products/download/{id}', 'ProductController@updateAlternativeData');
Route::post('products/dimensions/{id}', 'ProductController@updateAlternativeData');
Route::post('products/discounts/{id}', 'ProductController@updateAlternativeData');
Route::post('products/images', 'ProductController@setImages');
Route::delete('products/images/{id}', 'ProductController@deleteImage');

Route::group(['middleware' => 'isAjax'], function () {
    Route::post('products/variant/save', 'ProductVariantController@saveVariant');
    Route::post('products/variant/delete', 'ProductVariantController@deleteVariant');
});
Route::get('products/{id}/delete', [
    'as' => 'products.delete',
    'uses' => 'ProductController@destroy',
]);


/*
|--------------------------------------------------------------------------
| Plan Routes
|--------------------------------------------------------------------------
*/
if (config('market.have-plans', false)) {
    Route::resource('plans', 'PlanController', ['except' => ['show']]);
    Route::post('plans/search', 'PlanController@search');
    Route::get('plans/{id}/state-change/{state}', 'PlanController@stateChange');
    Route::delete('plans/{id}/cancel-subscription/{user}', 'PlanController@cancelSubscription');
}

/*
|--------------------------------------------------------------------------
| Coupon Routes
|--------------------------------------------------------------------------
*/
if (config('market.have-coupons', false)) {
    Route::resource('coupons', 'CouponController', ['except' => ['edit', 'update']]);
    Route::post('coupons/search', 'CouponController@search');
}