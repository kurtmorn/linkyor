<?php
/**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
 */

Route::view('/docs', 'api.docs');

Route::group(['namespace' => 'Legacy', 'prefix' => 'legacy'], function() {
    Route::group(['prefix' => 'client'], function() {
        Route::get('/login', 'ClientController@login');
        Route::get('/games', 'ClientController@games');
        Route::get('/assetTexture', 'ClientController@assetTexture');
        Route::get('/assetD3D', 'ClientController@assetD3D');
        Route::get('/getAvatar', 'ClientController@getAvatar');
    });

    Route::group(['prefix' => 'games'], function() {
        Route::post('/publish', 'GamesController@publish');
        Route::post('/upload', 'GamesController@upload');
    });
});

Route::group(['namespace' => 'V1'], function() {
    Route::post('shop/render/preview', 'ShopController@renderPreview')->middleware('auth');

    Route::group(['prefix' => 'v1'], function() {
        Route::get('/comments/1/{id}', 'ShopController@comments');

        Route::group(['prefix' => 'auth'], function() {
            Route::get('/generateToken', 'AuthController@generateToken')->middleware('auth');
            Route::get('/verifyToken', 'AuthController@verifyToken');
            Route::get('/verifyTokenClient', 'AuthController@verifyTokenClient');
        });

        Route::group(['prefix' => 'sets'], function() {
            Route::get('/{setId}', 'GamesController@info');
        });

        Route::group(['prefix' => 'games'], function() {
            Route::get('/retrieveAsset', 'GamesController@retrieveAsset');
            Route::get('/retrieveAvatar', 'GamesController@retrieveAvatar');
        });

        Route::group(['prefix' => 'shop'], function() {
            Route::get('/list', 'ShopController@list');
            Route::get('/{itemId}', 'ShopController@info');
            Route::get('/{itemId}/owners', 'ShopController@owners');
            Route::get('/{itemId}/recommended', 'ShopController@recommended');
        });

        Route::group(['prefix' => 'user'], function() {
            Route::get('/profile', 'UserController@profile');
            Route::get('/id', 'UserController@id');
            Route::get('/{userId}/sets', 'UserController@sets');
            Route::get('/{userId}/crate', 'UserController@crate');
            Route::get('/{userId}/owns/{itemId}', 'UserController@owns');
            Route::get('/trades/{userId}/{category}', 'UserController@trades')->middleware('auth');
            Route::get('/trades/{tradeId}', 'UserController@trade')->middleware('auth');
        });

        Route::group(['prefix' => 'clans'], function() {
            Route::get('/members/{clanId}/{rank}', 'ClansController@members');
        });
    });
});
