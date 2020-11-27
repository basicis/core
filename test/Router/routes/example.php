<?php
/**
 * Home route example
 */
$this->get("/", function ($app) {
    return $app->write("Home teste OK!");
});

$this->get("/h", function ($app) {
    return $app->write("Home teste OK!");
});

$this->get("/home", function ($app) {
    return $app->write("Home teste OK!");
});