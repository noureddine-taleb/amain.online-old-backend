<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/', function () use ($router) {
    return $router->app->version();
});

// function resource($uri, $controller)
// {
// 	//$verbs = array('GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE');
// 	global $route;
// 	$route->get($uri, 'App\Http\Controllers\\'.$controller.'@index');
// 	$route->get($uri.'/create', 'App\Http\Controllers\\'.$controller.'@create');
// 	$route->post($uri, 'App\Http\Controllers\\'.$controller.'@store');
// 	$route->get($uri.'/{id}', 'App\Http\Controllers\\'.$controller.'@show');
// 	$route->get($uri.'/{id}/edit', 'App\Http\Controllers\\'.$controller.'@edit');
// 	$route->put($uri.'/{id}', 'App\Http\Controllers\\'.$controller.'@update');
// 	$route->patch($uri.'/{id}', 'App\Http\Controllers\\'.$controller.'@update');
// 	$route->delete($uri.'/{id}', 'App\Http\Controllers\\'.$controller.'@destroy');
// }


$router->group([ /*'prefix' => 'api/v1',*/ ],function() use ($router){
    
    //========================================== <--- AUTH end points---> ==================================================
    
    //auth routes
    $router->group([ 'namespace' => 'Auth' ],function() use ($router){
        
        // $router->post('register', 'AuthController@register');
        $router->post('login', 'AuthController@login');
    });
    
    //========================================== <--- RESOURCES end points---> ==================================================
    
    $router->group([ 'middleware' => ['jwt.auth', 'acl.auth'] ],function() use ($router){
        
        $router->get('refresh', 'Auth\AuthController@refresh');
        //-------------------------------------------project CRUD-------------------------------------------
        //fetch project
        $router->get( "projects",			                        "ProjectController@index");
        $router->get( "projects/{id}",		                        "ProjectController@show");
        //relations of resource with others
        $router->get( "projects/{id}/relationships/bills",          "ProjectController@bills");
        $router->get( "projects/{id}/relationships/alerts",         "ProjectController@alerts");
        //create new one        
        $router->post( "projects",			                        "ProjectController@create");
        //update a project      
        $router->put( "projects/{id}",		                        "ProjectController@update");
        $router->patch( "projects/{id}",	                        "ProjectController@edit");
        //delete project        
        $router->delete( "projects/{id}",	                        "ProjectController@destroy");

        //-------------------------------------------user CRUD-------------------------------------------
        //fetch user        
        $router->get( "users",				                        "UserController@index");
        $router->get( "users/{id}",			                        "UserController@show");
        //relations of resource with others
        $router->get( "users/{id}/relationships/bills",			    "UserController@bills");
        //create new one        
        $router->post( "users",				                        "UserController@create");
        //update a user                     
        $router->put( "users/{id}",			                        "UserController@update");
        $router->patch( "users/{id}",		                        "UserController@edit");
        //delete user                       
        $router->delete( "users/{id}",		                        "UserController@destroy");

        //-------------------------------------------bill CRUD-------------------------------------------
        //fetch bill        
        $router->get( "bills",				                        "BillController@index");
        $router->get( "bills/{id}",			                        "BillController@show");
        //relations of resource with others
        $router->get( "bills/{id}/relationships/payment",		    "BillController@payment");
        $router->get( "bills/{id}/relationships/user",		        "BillController@user");
        $router->get( "bills/{id}/relationships/project",		    "BillController@project");
        //create new one        
        $router->post( "bills",				                        "BillController@create");
        //update a bill                     
        $router->put( "bills/{id}",			                        "BillController@update");
        $router->patch( "bills/{id}",		                        "BillController@edit");
        //delete bill                       
        $router->delete( "bills/{id}",		                        "BillController@destroy");

        //-------------------------------------------payment CRUD-------------------------------------------
        //fetch payment     
        $router->get( "payments",			                        "PaymentController@index");
        $router->get( "payments/{id}",		                        "PaymentController@show");
        //relations of resource with others
        $router->get( "payments/{id}/relationships/bill",		    "PaymentController@bill");
        //create new one        
        $router->post( "payments",			                        "PaymentController@create");
        //update a payment                      
        $router->put( "payments/{id}",		                        "PaymentController@update");
        $router->patch( "payments/{id}",	                        "PaymentController@edit");
        //delete payment                        
        $router->delete( "payments/{id}",	                        "PaymentController@destroy");

        //-------------------------------------------alert CRUD-------------------------------------------
        //fetch alert       
        $router->get( "alerts",				                        "AlertController@index");
        $router->get( "alerts/{id}",		                        "AlertController@show");
        //relations of resource with others
        $router->get( "alerts/{id}/relationships/project",		    "AlertController@project");
        //create new one        
        $router->post( "alerts",			                        "AlertController@create");
        //update a alert                        
        $router->put( "alerts/{id}",		                        "AlertController@update");
        $router->patch( "alerts/{id}",		                        "AlertController@edit");
        //delete alert                      
        $router->delete( "alerts/{id}",		                        "AlertController@destroy");

    });
});