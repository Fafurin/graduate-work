<?php

use App\Http\Actions\CreateCustomer;
use App\Http\Actions\FindCustomerByEmail;
use App\Http\ErrorResponse;
use App\Http\Request;

$request = new Request(
    $_GET,
    $_SERVER,
    file_get_contents('php://input')
);

try {
    $path = $request->path();
} catch (\App\Exceptions\HttpException) {
     (new ErrorResponse)->send();
     return;
}

try {
    $method = $request->method();
} catch (\App\Exceptions\HttpException) {
    (new ErrorResponse)->send();
    return;
}

$routes = [
    'GET' => [
        '/customer/show' => new FindCustomerByEmail()
    ],
    'POST' => [
        '/customer/create' => new CreateCustomer()
    ]
];

if (!array_key_exists($method, $routes)) {
    (new ErrorResponse('Not found'))->send();
    return;
}

if (!array_key_exists($path, $routes[$method])) {
    (new ErrorResponse('Not found'))->send();
    return;
}

$action = $routes[$method][$path];

try {
    $response = $action->handle($request);
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
}

$response->send();