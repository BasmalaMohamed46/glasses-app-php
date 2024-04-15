<?php
require_once "vendor/autoload.php";
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

try {
    $capsule->addConnection([
        "driver"=>"mysql",
        "host"=>__Host__,
        "database"=>__DB__,
        "username"=>__USER__,
        "password"=>__PASS__
    ]);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
} catch (\Exception $ex) {
    die("Error: ".$ex->getMessage());
}
