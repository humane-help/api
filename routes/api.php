<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([
    'middleware' => 'cors',
    'prefix'    => 'v1',
    'as'        => 'api.',
    'namespace' => 'Api\\v1',
], function () {

        //languages
        Route::group([
            'prefix'    => 'languages',
            'as'        => 'languages.',
        ], function () {
            Route::get('/', [
                'as'   => 'index',
                'uses' => 'LanguagesController@index',
            ]);
        });

        // Laravel passport
        Route::group([
            'prefix' => 'auth',
            'as'        => 'auth.',
        ], function () {
            Route::post('login', 'AuthController@login');

            Route::post('signup', 'AuthController@signUp');

            Route::group([
                'middleware' => 'auth:api'
            ], function() {
                Route::get('info', 'AuthController@info');
                Route::get('logout', 'AuthController@logout');
                Route::post('logout', 'AuthController@logout');
                Route::get('details', 'AuthController@details');
            });
        });

        //admin
        Route::group([
            'middleware' => 'auth:api',
            'prefix'    => 'admin',
            'as'        => 'admin.',
            'namespace'        => 'Admin',
        ], function () {

            Route::group([
                'prefix'    => 'statistics',
                'as'        => 'statistics.',
            ], function () {
                Route::get('/get', [
                    'as' => 'dashboard',
                    'uses' => 'StatisticsController@dashboard',
                ]);
            });

            // images
            Route::group([
                'prefix'    => 'images',
                'as'        => 'images.',
            ], function () {
                Route::post('/upload', [
                    'as'   => 'upload',
                    'uses' => 'ImagesController@upload',
                ]);
                Route::get('/list', [
                    'as'   => 'list',
                    'uses' => 'ImagesController@list',
                ]);
                Route::get('/', [
                    'as'   => 'list',
                    'uses' => 'ImagesController@list',
                ]);
            });
            // categories
            Route::group([
                'prefix'    => 'categories',
                'as'        => 'categories.',
            ], function () {
                Route::post('/delete', [
                    'as'   => 'delete',
                    'uses' => 'CategoriesController@delete',
                ]);
                Route::post('/create', [
                    'as'   => 'create',
                    'uses' => 'CategoriesController@store',
                ]);
                Route::post('/update', [
                    'as'   => 'update',
                    'uses' => 'CategoriesController@update',
                ]);
                Route::get('/index', [
                    'as'   => 'index',
                    'uses' => 'CategoriesController@index',
                ]);
                Route::get('/menu', [
                    'as'   => 'index',
                    'uses' => 'CategoriesController@menu',
                ]);
                Route::get('/', [
                    'as'   => 'index',
                    'uses' => 'CategoriesController@index',
                ]);
                Route::get('/{id}', [
                    'as'   => 'show',
                    'uses' => 'CategoriesController@show',
                ]);
            });

            //articles
            Route::group([
                'prefix'    => 'articles',
                'as'        => 'articles.',
            ], function () {
                Route::post('/delete/{id}', [
                    'as'   => 'delete',
                    'uses' => 'ArticlesController@delete',
                ]);
                Route::post('/delete', [
                    'as'   => 'delete',
                    'uses' => 'ArticlesController@delete',
                ]);
                Route::post('/create', [
                    'as'   => 'create',
                    'uses' => 'ArticlesController@store',
                ]);
                Route::post('/update', [
                    'as'   => 'update',
                    'uses' => 'ArticlesController@update',
                ]);
                Route::get('/index', [
                    'as'   => 'index',
                    'uses' => 'ArticlesController@index',
                ]);
                Route::get('/', [
                    'as'   => 'index',
                    'uses' => 'ArticlesController@index',
                ]);
                Route::get('/{id}', [
                    'as'   => 'show',
                    'uses' => 'ArticlesController@show',
                ]);
                Route::get('/edit-data/{id}', [
                    'as'   => 'edit-data',
                    'uses' => 'ArticlesController@editData',
                ]);
                Route::post('/to-draft/{id}', [
                    'as'   => 'draft',
                    'uses' => 'ArticlesController@toDraft',
                ]);
                Route::post('/to-activate/{id}', [
                    'as'   => 'activate',
                    'uses' => 'ArticlesController@toActivate',
                ]);
                Route::post('/to-archive/{id}', [
                    'as'   => 'archive',
                    'uses' => 'ArticlesController@toArchive',
                ]);
                Route::get('/create-data/new', [
                    'as'   => 'create-data',
                    'uses' => 'ArticlesController@createData',
                ]);
                Route::post('/send-telegram/{id}', [
                    'as'   => 'send-telegram',
                    'uses' => 'ArticlesController@sendToTelegram',
                ]);
                Route::get('/{id}/change-status', [
                    'as'   => 'show',
                    'uses' => 'ArticlesController@changeStatus',
                ]);
            });

            //newspaper
            Route::group([
                'prefix'    => 'newspaper',
                'as'        => 'newspaper.',
            ], function () {
                Route::post('/delete', [
                    'as'   => 'delete',
                    'uses' => 'NewspaperController@delete',
                ]);
                Route::post('/delete/{id}', [
                    'as'   => 'delete',
                    'uses' => 'NewspaperController@delete',
                ]);
                Route::post('/create', [
                    'as'   => 'create',
                    'uses' => 'NewspaperController@store',
                ]);
                Route::post('/to-draft/{id}', [
                    'as'   => 'draft',
                    'uses' => 'NewspaperController@toDraft',
                ]);
                Route::post('/send-telegram/{id}', [
                    'as'   => 'send-telegram',
                    'uses' => 'NewspaperController@sendToTelegram',
                ]);
                Route::post('/to-activate/{id}', [
                    'as'   => 'activate',
                    'uses' => 'NewspaperController@toActivate',
                ]);
                Route::post('/to-archive/{id}', [
                    'as'   => 'archive',
                    'uses' => 'NewspaperController@toArchive',
                ]);
                Route::get('/edit-data/{id}', [
                    'as'   => 'edit-data',
                    'uses' => 'NewspaperController@editData',
                ]);
                Route::post('/update', [
                    'as'   => 'update',
                    'uses' => 'NewspaperController@update',
                ]);
                Route::get('/index', [
                    'as'   => 'index',
                    'uses' => 'NewspaperController@index',
                ]);
                Route::get('/', [
                    'as'   => 'index',
                    'uses' => 'NewspaperController@index',
                ]);
                Route::get('/{id}', [
                    'as'   => 'show',
                    'uses' => 'NewspaperController@show',
                ]);
                Route::get('/{id}/change-status', [
                    'as'   => 'show',
                    'uses' => 'NewspaperController@changeStatus',
                ]);
                Route::get('/{id}/change-status', [
                    'as'   => 'show',
                    'uses' => 'NewspaperController@changeStatus',
                ]);
            });

            //tech
            Route::group([
                'prefix'    => 'techs',
                'as'        => 'techs.',
            ], function () {
                Route::post('/delete', [
                    'as'   => 'delete',
                    'uses' => 'TechController@delete',
                ]);
                Route::post('/to-draft/{id}', [
                    'as'   => 'draft',
                    'uses' => 'TechController@toDraft',
                ]);
                Route::post('/send-telegram/{id}', [
                    'as'   => 'send-telegram',
                    'uses' => 'TechController@sendToTelegram',
                ]);
                Route::post('/to-activate/{id}', [
                    'as'   => 'activate',
                    'uses' => 'TechController@toActivate',
                ]);
                Route::post('/to-archive/{id}', [
                    'as'   => 'archive',
                    'uses' => 'TechController@toArchive',
                ]);
                Route::post('/create', [
                    'as'   => 'create',
                    'uses' => 'TechController@store',
                ]);
                Route::get('/edit-data/{id}', [
                    'as'   => 'edit-data',
                    'uses' => 'TechController@editData',
                ]);
                Route::post('/update', [
                    'as'   => 'update',
                    'uses' => 'TechController@update',
                ]);
                Route::get('/index', [
                    'as'   => 'index',
                    'uses' => 'TechController@index',
                ]);
                Route::get('/', [
                    'as'   => 'index',
                    'uses' => 'TechController@index',
                ]);
                Route::get('/{id}', [
                    'as'   => 'show',
                    'uses' => 'TechController@show',
                ]);
                Route::get('/{id}/change-status', [
                    'as'   => 'show',
                    'uses' => 'TechController@changeStatus',
                ]);
                Route::get('/{id}/change-status', [
                    'as'   => 'show',
                    'uses' => 'TechController@changeStatus',
                ]);
            });

            //tags
            Route::group([
                'prefix'    => 'tags',
                'as'        => 'tags.',
            ], function () {
                Route::post('/delete', [
                    'as'   => 'delete',
                    'uses' => 'TagsController@delete',
                ]);
                Route::post('/create', [
                    'as'   => 'create',
                    'uses' => 'TagsController@store',
                ]);
                Route::post('/update', [
                    'as'   => 'update',
                    'uses' => 'TagsController@update',
                ]);
                Route::get('/index', [
                    'as'   => 'index',
                    'uses' => 'TagsController@index',
                ]);
                Route::get('/', [
                    'as'   => 'index',
                    'uses' => 'TagsController@index',
                ]);
                Route::get('/{id}', [
                    'as'   => 'show',
                    'uses' => 'TagsController@show',
                ]);
            });
        });

        // end admin


            // categories
            Route::group([
                'prefix'    => 'categories',
                'as'        => 'categories.',
            ], function () {
                Route::get('/index', [
                    'as'   => 'index',
                    'uses' => 'CategoriesController@index',
                ]);
                Route::get('/menu', [
                    'as'   => 'index',
                    'uses' => 'CategoriesController@menu',
                ]);
                Route::get('/', [
                    'as'   => 'index',
                    'uses' => 'CategoriesController@index',
                ]);
                Route::get('/{id}', [
                    'as'   => 'show',
                    'uses' => 'CategoriesController@show',
                ]);
            });

            //articles
            Route::group([
                'prefix'    => 'articles',
                'as'        => 'articles.',
            ], function () {
                Route::get('/index', [
                    'as'   => 'index',
                    'uses' => 'ArticlesController@index',
                ]);
                Route::get('/latest', [
                    'as'   => 'index',
                    'uses' => 'ArticlesController@latest',
                ]);
                Route::get('/search', [
                    'as'   => 'index',
                    'uses' => 'ArticlesController@search',
                ]);
                Route::get('/', [
                    'as'   => 'index',
                    'uses' => 'ArticlesController@index',
                ]);
                Route::get('/{id}', [
                    'as'   => 'show',
                    'uses' => 'ArticlesController@show',
                ]);
                Route::get('/alike/{id}', [
                    'as'   => 'alike',
                    'uses' => 'ArticlesController@alike',
                ]);
            });

            //newspaper
            Route::group([
                'prefix'    => 'newspaper',
                'as'        => 'newspaper.',
            ], function () {
                Route::get('/index', [
                    'as'   => 'index',
                    'uses' => 'NewspaperController@index',
                ]);
                Route::get('/', [
                    'as'   => 'index',
                    'uses' => 'NewspaperController@index',
                ]);
                Route::get('/{id}', [
                    'as'   => 'show',
                    'uses' => 'NewspaperController@show',
                ]);
            });

            //tags
            Route::group([
                'prefix'    => 'tags',
                'as'        => 'tags.',
            ], function () {
                Route::get('/index', [
                    'as'   => 'index',
                    'uses' => 'TagsController@index',
                ]);
                Route::get('/', [
                    'as'   => 'index',
                    'uses' => 'TagsController@index',
                ]);
                Route::get('/{id}', [
                    'as'   => 'show',
                    'uses' => 'TagsController@show',
                ]);
            });

            //tech with lang
            Route::group([
                'prefix'    => 'techs',
                'as'        => 'techs.',
            ], function () {
                Route::get('/index', [
                    'as'   => 'index',
                    'uses' => 'TechController@index',
                ]);
                Route::get('/', [
                    'as'   => 'index',
                    'uses' => 'TechController@index',
                ]);
                Route::get('/{id}', [
                    'as'   => 'show',
                    'uses' => 'TechController@show',
                ]);
            });

        // categories
        Route::group([
            'prefix'    => 'categories',
            'as'        => 'categories.',
        ], function () {
            Route::get('/index', [
                'as'   => 'index',
                'uses' => 'CategoriesController@index',
            ]);
            Route::get('/menu', [
                'as'   => 'index',
                'uses' => 'CategoriesController@menu',
            ]);
            Route::get('/', [
                'as'   => 'index',
                'uses' => 'CategoriesController@index',
            ]);
            Route::get('/{id}', [
                'as'   => 'show',
                'uses' => 'CategoriesController@show',
            ]);
        });

        //articles
        Route::group([
            'prefix'    => 'articles',
            'as'        => 'articles.',
        ], function () {
            Route::get('/index', [
                'as'   => 'index',
                'uses' => 'ArticlesController@index',
            ]);
            Route::get('/latest', [
                'as'   => 'index',
                'uses' => 'ArticlesController@latest',
            ]);
            Route::get('/search', [
                'as'   => 'index',
                'uses' => 'ArticlesController@search',
            ]);
            Route::get('/', [
                'as'   => 'index',
                'uses' => 'ArticlesController@index',
            ]);
            Route::get('/{id}', [
                'as'   => 'show',
                'uses' => 'ArticlesController@show',
            ]);
        });

        //newspaper
        Route::group([
            'prefix'    => 'newspaper',
            'as'        => 'newspaper.',
        ], function () {
            Route::get('/index', [
                'as'   => 'index',
                'uses' => 'NewspaperController@index',
            ]);
            Route::get('/', [
                'as'   => 'index',
                'uses' => 'NewspaperController@index',
            ]);
            Route::get('/{id}', [
                'as'   => 'show',
                'uses' => 'NewspaperController@show',
            ]);
        });

        //tech without lang
        Route::group([
            'prefix'    => 'techs',
            'as'        => 'techs.',
        ], function () {
            Route::get('/index', [
                'as'   => 'index',
                'uses' => 'TechController@index',
            ]);
            Route::get('/', [
                'as'   => 'index',
                'uses' => 'TechController@index',
            ]);
            Route::get('/{id}', [
                'as'   => 'show',
                'uses' => 'TechController@show',
            ]);
        });

        //tags
        Route::group([
            'prefix'    => 'tags',
            'as'        => 'tags.',
        ], function () {
            Route::get('/index', [
                'as'   => 'index',
                'uses' => 'TagsController@index',
            ]);
            Route::get('/', [
                'as'   => 'index',
                'uses' => 'TagsController@index',
            ]);
            Route::get('/{id}', [
                'as'   => 'show',
                'uses' => 'TagsController@show',
            ]);
        });

});
