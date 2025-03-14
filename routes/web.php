<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    dd('optimize ran');
});

Route::group(['namespace' => 'App\Http\Controllers\Home'], function()
{  
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/privacy', 'HomeController@privacy')->name('home.privacy');
    Route::get('/service', 'HomeController@service')->name('home.service');
    Route::get('/terms', 'HomeController@terms')->name('home.terms');

    //resetpassword
    Route::match(['get','post'],'/resetpassword/{slug}', 'HomeController@resetpassword')->name('home.resetpassword');
});


Route::prefix('/user')->namespace('App\Http\Controllers\User')->group(function(){
    Route::group(['middleware' => ['guest']], function() {
        Route::get('/', function () {
            return redirect('/user/login');
        });

        /**
         * Register Routes*
         */
        Route::get('/register', function () {
            return redirect('/user/register/null');
        });
        Route::get('/register/{ref}', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                    ->name('password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                    ->name('password.reset');

        Route::post('reset-password', [NewPasswordController::class, 'store'])
                    ->name('password.store');

        /**
         * App Routes
         */
        Route::get('/appregister', function () {
            return redirect('/user/appregister/null');
        });
        Route::get('/appregister/{ref}', 'RegisterController@appshow')->name('register.appshow');
        Route::post('/appregister', 'RegisterController@appregister')->name('register.appperform');
        
       
        /**
         * Login Routes*
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

         /**
         * App Login Routes*
         */
        Route::get('/applogin', 'LoginController@appshow')->name('login.appshow');
        Route::post('/applogin', 'LoginController@applogin')->name('login.appperform');

    });

    Route::group(['middleware' => ['auth']], function() {
        
        Route::get('/dashboard', 'UserController@dashboard')->name('dashboard.view');
        Route::get('/chart', 'UserController@chart')->name('chart.view');

        Route::get('/faq', 'UserController@faq');

        Route::get('/changeassetpair', 'UserController@changeassetpair')->name('change_asset_pair');
        Route::get('/viewassettrade', 'UserController@viewassettrade')->name('view_asset_trade');

        //selection routes
        Route::match(['get','post'],'/selectaccount/{slug}', 'UserController@selectaccount')->name('user.selectaccount');


        //robot routes
        Route::match(['get','post'],'/robot', 'UserController@robot')->name('robot'); 
         //stoprobot routes
         Route::match(['get','post'],'/stoprobot', 'UserController@stoprobot')->name('stoprobot'); 
         //get current robots amount earned
         Route::post('/check-current-earned','UserController@getCurrentEarned');
         Route::get('/disabledisplayrobotonload','UserController@disableDisplayRobotOnLoad');

        //  timer routes
         Route::post('/update-timer-status','UserController@updateTimerStatus');

        //account routes
        Route::match(['get','post'],'/account', 'UserController@account')->name('account.view'); 

        //deposit routes*
        Route::match(['get','post'],'/deposit', 'DepositController@deposit')->name('deposit'); 
        Route::get('/deposits', 'DepositController@deposits')->name('deposits.view');
        Route::post('/getwallet', 'DepositController@getwallet')->name('deposit.getwallet');

        //withdraw routes
        // Route::match(['get','post'],'/withdraw', 'UserController@withdraw')->name('withdraw.view'); 

        //tradingbot routes
        Route::match(['get','post'],'/tradingbot', 'UserController@tradingbot')->name('tradingbot.view'); 
        Route::get('/tradingbot/{id}', 'UserController@showTradingBotDetails');

        //subscribe routes
        // Route::get('/subscribe', 'SubscribeController@subscribe')->name('subscribe.view');
        // Route::post('/subscribe', 'SubscribeController@subscribe')->name('subscribe.post');
        // Route::post('/getamount', 'SubscribeController@getamount')->name('subscribe.getamount');

        //withdraw routes
        Route::get('/withdraw', 'WithdrawController@withdraw')->name('withdraw.view');
        Route::post('/withdraw', 'WithdrawController@withdraw')->name('withdraw.post');
        Route::post('/sendwithdrawotp', 'WithdrawController@sendwithdrawotp')->name('withdraw.sendwithdrawotp');

        //Earnings routes
        // Route::get('/earning', 'EarningController@earning')->name('earning.view');

        //Referal routes
        // Route::get('/referal', 'ReferalController@referal')->name('referal.view');

        //Profile route
        Route::match(['get','post'],'/profile', 'ProfileController@profile')->name('profile.view');
        Route::post('/check-current-password','ProfileController@checkUserPassword');


        // Route::get('/activity/{slug}', 'ActivityController@view')->name('activity.share');
        // Route::match(['get','post'],'/activity/{slug}', 'ActivityController@view')->name('activity.share');
        // Route::get('/activity', 'ActivityController@activity')->name('activity.view');

        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
        Route::get('/applogout', 'LogoutController@appperform')->name('logout.appperform');
    });



});

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    Route::get('/', function () {
        return redirect('/login');
    });
    
    Route::match(['get','post'],'login', 'AdminController@login');
    
    Route::group(['middleware'=>['admin']], function(){
        Route::get('/','AdminController@login');

        //users route
        Route::match(['get','post'],'users', 'AdminController@users');

        //Email route
        Route::match(['get','post'],'email', 'AdminController@email');

        Route::match(['get','post'],'viewusers/{slug}', 'AdminController@viewusers');

        //Admin coin routes
        Route::resource('coins', CoinsController::class);

        //Admin investmentplans routes
        Route::resource('plans',PlansController::class);

        //Admin activitys route
        // Route::resource('activity', ActivitysController::class);

        Route::match(['get','post'],'dashboard', 'AdminController@dashboard');
        Route::get('logout','AdminController@logout');

        //deposit routes
        Route::match(['get','post'],'deposit', 'DepositController@deposit');

        //deposit routes
        Route::match(['get','post'],'withdraws', 'WithdrawController@withdraw');
    });
});
