<?php

declare(strict_types=1);

require __DIR__ . "/inc/bootstrap.php";

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");

$uri = explode( '/', $_SERVER["REQUEST_URI"]);

if ($uri[1] != "products" or count($uri) > 3) {
		http_response_code(404);
		exit;
}

if (count($uri) === 3) {
		$id = $uri[2];
} else {
		$id = '';
}

$database = new Database(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

$gateway = new ProductModel($database);

$productController = new ProductController($gateway);

$productController->processRequest($_SERVER["REQUEST_METHOD"], $id);