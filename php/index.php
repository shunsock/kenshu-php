<?php
use App\App;

require_once __DIR__ . '/vendor/autoload.php';
//var_dump(Fuga::run());
//var_dump(["array??????????"]);
//$hoge = new App\hoge();
//var_dump($hoge->run());
$app = new App();
$app->run();
