<?php


Route::group(['middleware' => 'web'], function () {

	Route::auth();

	if(!Auth::user()){
		//return view('auth.login-signup');
	}

	Route::get('/', 'DashboardController@index');
    Route::get('/home', 'HomeController@index');
	Route::get('/dashboard', 'DashboardController@index');

	Route::group(['prefix'=>'badges'],function(){
		Route::get('','BadgesController@index');
		Route::get('add',['uses'=>'BadgesController@add','as'=>'badges.add']);
		Route::post('add',['uses'=>'BadgesController@store','as'=>'badges.store']);
		Route::get('{id}/edit',['uses'=>'BadgesController@edit','as'=>'badges.edit']);
		Route::put('{id}',['uses'=>'BadgesController@update','as'=>'badges.update']);
		Route::delete('{id}',['uses'=>'BadgesController@destroy','as'=>'badges.destroy']);
	});

});
