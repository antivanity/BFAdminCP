<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
 */

ClassLoader::addDirectories([

    app_path() . '/commands',
    app_path() . '/database/seeds'

]);

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
 */

Log::useDailyFiles(storage_path() . '/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
 */

App::error(function (Exception $exception, $code) {
    switch ($code) {
        case 403:
            if (Auth::check()) {
                return Redirect::route('home')->withErrors([
                    'Access Forbidden!'
                ]);
            }

            return Redirect::guest(route('user.login'));
            break;

        case 405:
            return Redirect::intended(route('home'))->withErrors([
                'No Method Available'
            ]);
            break;
    }

    Log::error($exception);

    if (!Config::get('app.debug')) {
        View::share('page_title', false);
        return Response::view('system.error', compact('exception', 'code'), 500);
    }
});

App::missing(function ($exception) {
    View::share('page_title', false);
    return Response::view('system.notfound', [], 404);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
 */

App::down(function () {
    return Response::make('Be right back!', 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
 */

require app_path() . '/filters.php';

require $app['path.base'] . '/app/bfacp/macros.php';
require $app['path.base'] . '/app/bfacp/events.php';
