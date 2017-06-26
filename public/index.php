<?php
//use \Psr\Http\Message\ServerRequestInterface as Request;
//use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

//开启session
//session_start();

// Instantiate the app
//$settings = require __DIR__ . '/../src/settings.php';

//载入配置文件
$config=require __DIR__ .'/../config/config.php';
$app = new \Slim\App($config);

//设置依赖关系
require __DIR__ . '/../src/dependencies.php';

//注册中间件
require __DIR__ . '/../src/middleware.php';

//注册路由
require __DIR__ . '/../src/routes.php';

//var_dump($app);exit;

// Run app
$app->run();