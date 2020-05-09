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


$router->group([ 'prefix' => 'api/v1' ],function() use ($router){
    
    //========================================== <--- AUTH end points---> ==================================================
    
    //auth routes
    $router->post("users",	"UserController@create");
    $router->post("login", "UserController@login");
    $router->post("upload", "UserController@upload");
    
    //========================================== <--- RESOURCES end points---> ==================================================
    
    $router->group(["middleware" => ["jwt.auth", "acl.auth"] ],function() use ($router){
        
        $router->get("refresh", "Auth\AuthController@refresh");
        //-------------------------------------------project CRUD-------------------------------------------
        //fetch project
        $router->get( "projects",			                        "ProjectController@index");
        $router->get( "projects/{id}",		                        "ProjectController@show");
        //relations of resource with others
        $router->get( "projects/{id}/bills",                        "ProjectController@bills");
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
        $router->get( "users/{id}/bills",           			    "UserController@bills");
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
        $router->get( "bills/{id}/payment",         		        "BillController@payment");
        $router->get( "bills/{id}/user",            		        "BillController@user");
        $router->get( "bills/{id}/project",         		        "BillController@project");
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
        $router->get( "payments/{id}/bill",         		        "PaymentController@bill");
        //create new one        
        $router->post( "payments",			                        "PaymentController@create");
        //update a payment                      
        $router->put( "payments/{id}",		                        "PaymentController@update");
        $router->patch( "payments/{id}",	                        "PaymentController@edit");
        //delete payment                        
        $router->delete( "payments/{id}",	                        "PaymentController@destroy");
    });
});