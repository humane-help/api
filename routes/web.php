<?php

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

Route::get('/', function () {
    return response()->json(['api'=> 'v1']);
});

Route::prefix('{lang?}')->middleware('locale')->group(function() {

    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/advantage', function () {
        return view('advantage');
    });
    Route::get('/job', function () {
       return view('job');
    });

    Route::group([
        'prefix' => 'solutions',
        'as'        => 'solutions.',
        'namespace' => 'Api\\v1',
    ], function () {

        Route::get('/', function () {
            return view('solution');
        });

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'NewspaperController@show',
        ]);

    });

    Route::group([
        'prefix' => 'projects',
        'as'        => 'projects.',
        'namespace' => 'Api\\v1',
    ], function () {

        Route::get('/', function () {
            return view('project');
        });

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'NewspaperController@show',
        ]);

    });
    Route::group([
        'prefix' => 'letters',
        'as'        => 'letters.',
        'namespace' => 'Api\\v1',
    ], function () {

        Route::get('/', function () {
            return view('letter');
        });

    });


    Route::group([
        'prefix' => 'services',
        'as'        => 'services.',
        'namespace' => 'Api\\v1',
    ], function () {

        Route::get('/', function () {
            return view('service');
        });

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'NewspaperController@show',
        ]);

    });

    Route::group([
        'prefix' => 'news',
        'as'        => 'news.',
        'namespace' => 'Api\\v1',
    ], function () {

	Route::get('/', function () {
            return view('news');
        });

        Route::get('/{id}', [
            'as'   => 'show',
            'uses' => 'ArticlesController@show',
        ]);

    });

    Route::group([
        'namespace' => 'Api\\v1',
    ], function () {

        Route::get('/about', [
            'as'   => 'about',
            'uses' => 'FrontendController@about',
        ]);

    });


    Route::get('/team', function () {
        return view('team');
    });
});



Auth::routes();
