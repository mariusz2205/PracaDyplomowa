<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::group(['middleware' => ['web']], function () {

    Route::get('/','WelcomePageController@index')->name("welcome");

    Route::get('/assortment/{page_num}', 'AssortmentController@DispleyAllBooks')->name('assortment');

    Route::get('/book-details/{book_id}', 'AssortmentController@DispleyBookDetails')->name('book-details');

    Route::post('/setProductFiltersSessionVariable', 'AssortmentController@setProductFiltersSessionVariable')->name('setProductFiltersSessionVariable');

    Route::get('/ShopingCard', 'ShopingCardController@DispleyShopingCard')->name('shopingCard');

    Route::post('/addToShopingCard', 'ShopingCardController@UpdateItemNumber')->name('addToShopingCard');

    Route::get('/AddOneItem/{bookId}', 'ShopingCardController@AddOneItem')->name('AddOneItem');

    Route::get('/RemoveOneItem/{bookId}', 'ShopingCardController@RemoveOneItem')->name('RemoveOneItem');

    Route::get('/RemoveItemFromShopingCard/{bookId}', 'ShopingCardController@RemoveItem')->name('RemoveItem');

    Route::get('/AddressDetails', 'CheckoutController@DisplayAddressForm')->name('AddressDetails');

    Route::post('/SaveOrder', 'CheckoutController@SaveOrder')->name('SaveAddressInformation');

    Route::get('/ProductImage/{filename}', 'ProductManagementPanelController@getProductImage')->name('getProductImage');

    Route::get('/RemoveBook/{bookId}', 'ProductManagementPanelController@RemoveBook')->name('RemoveBook');

    Route::post('/setProductFiltersSessionVariable', 'AssortmentController@setProductFiltersSessionVariable')->name('setProductFiltersSessionVariable');


});




Route::group(['middleware' => ['web','UsersManagementPanel']], function () {

    Route::get('/AddNewUser', 'UsersManagementPanel@AddNewUser')->name('AddNewUser');

    Route::get('/ShowUsers/{page_num}', 'UsersManagementPanel@ShowUsers')->name('ShowUsers');

    Route::get('/JsonUserDetail/{user_id}', 'UsersManagementPanel@JsonUserDetail')->name('JsonUserDetail');

    Route::get('/JsonAllRoles', 'UsersManagementPanel@JsonAllRoles')->name('JsonAllRoles');

    Route::post('/EditUserRole', 'UsersManagementPanel@EditUserRole')->name('EditUserRole');

    Route::get('/DeleteUser/{user_id}', 'UsersManagementPanel@DeleteUser')->name('DeleteUser');

    Route::post('/InsertNewUser', 'UsersManagementPanel@InsertNewUser')->name('InsertNewUser');

    Route::post('/setRolesFilterSessionVariable', 'UsersManagementPanel@setRolesFilterSessionVariable')->name('setRolesFilterSessionVariable');

});


Route::group(['middleware' => ['web','UsersManagementPanel']], function () {

  Route::get('/Orders', 'OrdersManagementPanel@ShowOrders')->name('ShowOrders');

  Route::get('{id}/{status}', 'OrdersManagementPanel@changeOrderStatus')->name('changeOrderStatus');

  Route::post('/setOrderNumberSessionVariable', 'OrdersManagementPanel@setOrderNumberSessionVariable')->name('setOrderNumberSessionVariable');

});


Route::group(['middleware' => ['web','UsersManagementPanel']], function () {

  Route::get('/AddNewProduct', 'ProductManagementPanelController@AddNewProduct')->name('AddNewProduct');

  Route::post('/PostNewProduct', 'ProductManagementPanelController@PostNewProduct')->name('PostNewProduct');

  Route::post('/PostNewCategorie', 'ProductManagementPanelController@PostNewCategorie')->name('PostNewCategorie');

  Route::post('/PostNewAuthor', 'ProductManagementPanelController@PostNewAuthor')->name('PostNewAuthor');

  Route::get('/AddCategories', 'ProductManagementPanelController@AddCategories')->name('AddCategories');

  Route::get('/AddAuthors', 'ProductManagementPanelController@AddAuthors')->name('AddAuthors');

  Route::get('/AddImg', 'ProductManagementPanelController@AddImg')->name('AddImg');

  Route::get('/RemoveItemFromCategoriesSessionVariable/{categorie}/{categorie2}', 'ProductManagementPanelController@RemoveItemFromCategoriesSessionVariable')->name('RemoveItemFromCategoriesSessionVariable');

  Route::get('/RemoveItemFromAuthorsSessionVariable/{name}/{surname}', 'ProductManagementPanelController@RemoveItemFromAuthorsSessionVariable')->name('RemoveItemFromAuthorsSessionVariable');

  Route::post('/AddImgAndConfirmProduct', 'ProductManagementPanelController@AddImgAndConfirmProduct')->name('AddImgAndConfirmProduct');

});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index')->name('home');
});
