<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('damai', 'DamaiController');
    $router->resource('ctrip', 'CtripController');
    $router->post('ctrip/sync_data', 'CtripController@syncData');
    $router->post('damai/sync_data', 'DamaiController@syncData');
    $router->post('weibo/sync_data', 'WeiboController@syncData');
    $router->resource('weibos', 'WeiboController');
    $router->resource('hhx', 'HhxController');
    $router->resource('hebe', 'HebeController');
    $router->resource('yyy', 'YyyController');
    $router->resource('mycf', 'MycfController');
    $router->resource('wqf', 'WqfController');
    $router->resource('yeung', 'YeungController');
    $router->resource('net_ease', 'NetEaseController');
    $router->resource('csv', 'CsvController');
    $router->resource('weibo_user', 'WeiboUserController');
    $router->post('net_ease/import', 'NetEaseController@import');
    $router->resource('net_ease_hebe', 'NetEaseHebeController');
    $router->resource('net_ease_wqf', 'NetEaseWqfController');
    $router->resource('net_ease_yoga', 'NetEaseYogaController');
    $router->resource('net_ease_jj', 'NetEaseJJController');
    $router->resource('net_ease_eason', 'NetEaseEasonController');
    $router->resource('net_ease_yeung', 'NetEaseYeungController');
    $router->resource('net_ease_she', 'NetEaseSheController');
    $router->resource('travel', 'TravelController');
    $router->resource('daily', 'DailyController');
    $router->resource('interest', 'InterestController');
    $router->resource('interest_log', 'InterestLogController');
    $router->resource('direction', 'DirectionController');
    $router->resource('direction_log', 'DirectionLogController');
    $router->any('direction_log_week', 'DirectionLogController@week');
    $router->resource('flight', 'FlightController');
    $router->resource('direction_week', 'DirectionWeekController');
    $router->resource('to_do_list', 'ToDoListController');
    $router->resource('product', 'ProductController');
    $router->resource('coffee', 'CoffeeController');
    $router->resource('clothes', 'ClothesController');
    $router->resource('shoes', 'ShoesController');
    $router->resource('accessories', 'AccessoriesController');
    $router->resource('db_top', 'DbTopController');
    $router->resource('travel_traffic', 'TravelTrafficController');
    $router->resource('travel_bill', 'TravelBillController');
    $router->resource('hhx_travel', 'HhxTravelController');
    $router->resource('travel_equip', 'TravelEquipController');
    $router->resource('wish_list', 'WishListController');
    $router->resource('db_music_top', 'DbMusicTopController');
    $router->resource('luck', 'LuckController');
    $router->resource('yongle', 'YongLeController');
    $router->resource('hhx_concert', 'HhxConcertController');
    $router->any('direction_mouth', 'DirectionWeekController@mouth');
});
