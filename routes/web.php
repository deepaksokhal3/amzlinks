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

Route::get('/', 'HomeController@index');
Route::get('/cron', 'DashboardController@cron');
Route::get('/contact-us', 'ContactController@index');
Route::get('/pricing', 'PricingController@index');
Route::get('/terms', 'PagesController@index');
Route::get('/policy', 'PagesController@policy');

Route::post('/send', 'ContactController@sendContactUsMail')->name('send.sendContactUsMail');
//google oauth callback
Route::get('/google/oauth', 'GoogleController@oauth')->name('google.oauth');
//connect google analytics account
Route::resource('/connect', 'ConnectController')->only(['index', 'destroy', 'update']);

Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');

Route::group(['prefix' => 'faq'], function () {
	Route::get('/', 'FAQController@index');
	Route::get('/{catId}', 'FAQController@view');
	Route::get('/{catname}/{pageId}', 'FAQController@viewInner');

});
Auth::routes();
Route::group(['middleware' => ['auth', 'subscriber']], function () {

	// DASHBOARD
	Route::get('/dashboard', 'DashboardController@index');

	// USER SECTION

	Route::group(['prefix' => 'profile'], function () {
		Route::get('/', 'ProfileController@index');
		Route::post('/update', 'ProfileController@update')->name('profile.update');
		Route::post('/upload', 'ProfileController@upload')->name('profile.upload');
	});
	// CHANGE PASSWORD
	Route::get('/change-password', 'Auth\ChangePasswordController@index');
	Route::post('/change-password', 'Auth\ChangePasswordController@changePassword')->name('changePassword');

	// CAMPAIGNS SECTION
	Route::get('campaigns', 'CampaignsController@index');
	Route::get('campaign/add', 'CampaignsController@add');
	Route::post('campaign/add', 'CampaignsController@add');
	Route::get('campaign/edit', 'CampaignsController@edit');
	Route::post('campaign/edit', 'CampaignsController@edit');
	Route::post('campaign/update', 'CampaignsController@update');
	Route::post('campaign/delete', 'CampaignsController@drop');

	Route::group(['prefix' => 'campaigns'], function () {

		Route::get('/{campId}', 'CampaignsController@detail');

	});

	// TRACKING CODE SECTION
	Route::get('trackings', 'TrackingController@index');
	Route::group(['prefix' => 'tracking'], function () {
		Route::get('/add', 'TrackingController@create');
		Route::post('/add', 'TrackingController@store')->name('tracking.store');
		Route::get('/edit', 'TrackingController@edit');
		Route::patch('/update/{track}', 'TrackingController@update')->name('tracking.update');
		Route::post('/edit', 'TrackingController@edit')->name('tracking.edit');
		Route::post('/delete', 'TrackingController@drop');
	});

	// TRACKING LINK SECTION
	Route::group(['prefix' => 'tracking-links'], function () {
		Route::resource('/', 'TrackingLinksController', ['as' => 'tracking-links'])->only(['index']);
		Route::resource('rotator', 'TrackingLinksController', ['as' => 'tracking-links'])->only(['store']);
		Route::post('/edit', 'TrackingLinksController@edit')->name('tracking-links.edit');
		Route::get('/edit', 'TrackingLinksController@edit');
		Route::post('/update', 'TrackingLinksController@update')->name('tracking-links.update');
		Route::get('/select', 'TrackingLinksController@selectUrlType');
		Route::get('/{type}', 'TrackingLinksController@add');
		Route::post('/delete', 'TrackingLinksController@drop')->name('tracking-links.drop');

		// Routes using for seeker
		Route::group(['prefix' => 'seeker'], function () {
			Route::post('/add', 'Urls\SeekerUrlController@store')->name('seeker.store');
			Route::patch('/update/{link}', 'Urls\SeekerUrlController@update')->name('seeker.update');
		});

		// Routes using for Brand Store
		Route::group(['prefix' => 'brand'], function () {
			Route::post('/add', 'Urls\BrandStorefrontController@store')->name('brand.store');
			Route::patch('/update/{link}', 'Urls\BrandStorefrontController@update')->name('brand.update');
		});
		// Routes using for Buy To Gether
		Route::group(['prefix' => 'buy-together'], function () {
			Route::post('/add', 'Urls\BuyTogetherController@store')->name('buy-together.store');
			Route::patch('/update/{link}', 'Urls\BuyTogetherController@update')->name('buy-together.update');
		});

		// Routes using for AddToCart
		Route::group(['prefix' => 'add-cart'], function () {
			Route::post('/add', 'Urls\AddToCartController@store')->name('add-cart.store');
			Route::patch('/update/{link}', 'Urls\AddToCartController@update')->name('add-cart.update');
		});
		// Routes using for Canonical
		Route::group(['prefix' => 'canonical'], function () {
			Route::post('/add', 'Urls\CanonicalController@store')->name('canonical.store');
			Route::patch('/update/{link}', 'Urls\CanonicalController@update')->name('canonical.update');
		});

	});

	// SUBSCRIPTION

	Route::group(['prefix' => 'subscription'], function () {

		Route::get('/', 'SubscriptionController@index')->name('subscription.index');
		Route::post('/create', 'SubscriptionController@create')->name('subscription.create');
		Route::get('/cancel/{plan}', 'SubscriptionController@cancel')->name('subscription.cancel');
		Route::get('/{plan}', 'SubscriptionController@show')->name('subscription.show');
	});

	// PAYMENT
	Route::group(['prefix' => 'stripe'], function () {

		Route::get('/', 'StripeController@create')->name('stripe');
		Route::post('', 'StripeController@create')->name('stripe.create');
		Route::post('store', 'StripeController@postPaymentWithStripe')->name('stripe.postPaymentWithStripe');

	});

	Route::group(['prefix' => 'billing'], function () {
		Route::get('/', 'BillingHistoryController@index');
	});

});

/**======================================================
 * ADMIN ROUTES
========================================================**/

Route::group(['middleware' => ['auth', 'admin']], function () {

// ADMIN PREFIX
	Route::group(['prefix' => 'admin'], function () {

		// DASHBOARD
		Route::get('/', 'Admin\DashboardController@index');

		// MANAGE USERS
		Route::group(['prefix' => 'users'], function () {
			Route::get('/', 'Admin\UsersController@index');
			Route::get('/{id}', 'Admin\UserProfileController@index');

			Route::post('/update', 'Admin\UsersController@update')->name('users.update');

			Route::post('/', 'Admin\UserProfileController@update')->name('users.update');
			Route::post('/upload', 'Admin\UserProfileController@upload')->name('users.upload');

		});

		// MANAGE CAMPAIGNS
		Route::group(['prefix' => 'campaigns'], function () {
			Route::get('/detail/{id}', 'Admin\CampaignsController@detail')->name('campaigns.detail');
			Route::get('/single/{id}', 'Admin\CampaignsController@single')->name('campaigns.single');
			Route::get('/', 'Admin\CampaignsController@index');
		});
		// MANAGE FAQ
		Route::group(['prefix' => 'faq'], function () {

			//CATAGORY
			Route::get('/', 'Admin\ManageFaqController@index')->name('faq.index');
			Route::post('/store', 'Admin\ManageFaqController@store')->name('faq.store');
			Route::get('/edit/{faqCatagory}', 'Admin\ManageFaqController@edit')->name('faq.edit');
			Route::patch('/update/{faqCatagory}', 'Admin\ManageFaqController@update')->name('faq.update');
			Route::get('/delete/{faqCatagory}', 'Admin\ManageFaqController@destroy')->name('faq.destroy');
			// PAGES
			Route::group(['prefix' => 'page'], function () {
				Route::get('/', 'Admin\FAQPagesController@index')->name('page.index');
				Route::post('/store', 'Admin\FAQPagesController@store')->name('page.store');
				Route::get('/edit/{page}', 'Admin\FAQPagesController@edit')->name('page.edit');
				Route::patch('/update/{page}', 'Admin\FAQPagesController@update')->name('page.update');
				Route::get('/delete/{page}', 'Admin\FAQPagesController@destroy')->name('page.destroy');
			});

		});

	});

});
// Route::get('/{unique}', 'TrackingLinksController@viewCreatedUrl');
Route::get('/{unique}', 'IntermediateViewController@index');
Route::get('/ajax/{unique}', 'IntermediateViewController@getIntermediateData');
