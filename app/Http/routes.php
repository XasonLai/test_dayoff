<?php

Route::get('/' , function(){
	return view('welcome');
});
Route::get('/map' , function(){
	return view('s_map');
});
// Route::get('/marker' , function(){
// 	return view('marker');
// });
// Route::get('/3333' , function(){
// 	return view('3333');
// });

// Route::get('/44' , function(){
// 	return view('44');
// });

// Route::post('/map/add' , 'TestController@map');

// Route::post('/map/add' , function(){
// 	dd(Input::all());
// 	App\Map::create(Input::all());

// 	var_dump('map is added.....');
// });

Route::group(['middleware' => 'guest'] , function(){
	// 認證路由...
	Route::get('auth/login', 'Auth\AuthController@getLogin');
	Route::post('auth/login', 'Auth\AuthController@postLogin');
	// 註冊路由...
	Route::get('auth/register', 'Auth\AuthController@getRegister');
	Route::post('auth/register', 'Auth\AuthController@postRegister');
	// 密碼重置連結的路由...
	Route::get('password/email', ['as' => 'forgetpassword.index' , 'uses' => 'Auth\PasswordController@getEmail']);
	Route::post('password/email', ['as' => 'forgetpassword.process' , 'uses' => 'Auth\PasswordController@postEmail']);

	// 密碼重置的路由...
	Route::get('password/reset/{token}', ['as' => 'resetpassword.index' , 'uses' => 'Auth\PasswordController@getReset']);
	Route::post('password/reset', ['as' => 'resetpassword.process' , 'uses' => 'Auth\PasswordController@postReset']);

});

Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::group(['prefix' => 'staffs', 'middleware' => 'auth'], function() {
    
    Route::get('user','UserController@index');
    Route::get('user/count','UserController@personal_count');
	Route::get('user/data/show','UserController@show');
	Route::controller('user/data/index','UserController');
	// Route::controller('user/data/show','UserController');


	Route::get('create', 'UserController@create');

	Route::get('store/index',function(){
		$rea_id = Input::get('rea_id');
		$provision_way = App\Provision_way::where('provision_id', '=' , $rea_id)->get();
		return Response::json($provision_way);

	});
	Route::post('store','UserController@store');

	Route::get('staff',['as' => 'staff.id' ,'uses'=> 'UserController@staff' ]);
	Route::get('personal',['as' => 'personal.index' , 'uses' => 'UserController@personal']);

	
	Route::get('search/{id}' , ['as' => 'search' , 'uses' => 'UserController@search'])->where('id','[0-9]+');
	Route::get('search',function(){
		return redirect()->route('search',1);
	});
	Route::get('provision', 'ProvisionController@index');

	Route::resource('compensatory','CompensatoryController');

	Route::get('test/fix' , 'TestController@fix');
	Route::controller( 'test', 'TestController');

	Route::get('test' , ['as' => 'test.index' , 'uses' => 'TestController@getYou']);
	// Route::get('test' , ['as' => 'test.index' , 'uses' => 'TestController@index']);
	// Route::get('compensatory' , 'CompensatoryController@index');
	// Route::get('compensatory/store','CompensatoryController@store');
	// Route::get('compensatory/update' , 'CompensatoryController@update');
});



