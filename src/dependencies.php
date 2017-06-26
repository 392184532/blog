<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['view'] = function ($container) {
    $settings = $container->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($container) {
    $settings = $container->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

//mysql
// $container['db'] = function ($container) {
//     $capsule = new \Illuminate\Database\Capsule\Manager;
//     $capsule->addConnection($container['settings']['db']);

//     $capsule->setAsGlobal();
//     $capsule->bootEloquent();

//     return $capsule;
// };
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

// 注入jwt
$container["jwt"] = function ($container) {
    return new Lcobucci\JWT\Builder();
};
//$app->add(new \Slim\Middleware\JwtAuthentication([
//    "path"        => "/",
//    "passthrough" => ["/register", "/login"],
//    "attribute"   => "jwt",
//    "cookie"      => "token",
//    "secure"      => false,
//    "algorithm"   => ["HS256", "HS384"],
//    "secret"      => "35a7102186059ae8a1557f1e9c90ca47075d7c4e",
//    "callback"    => function ($request, $response, $args) use ($container) {
//        $container["jwt"] = $args["decoded"];
//    },
//]));

// 注入日志
// $container['logger'] = function ($container) {
//     $logger       = new \Monolog\Logger('WM_logger');
//     $file_handler = new \Monolog\Handler\StreamHandler(__DIR__ . '/../logs/system-' . date('Ymd') . '.log');
//     $logger->pushHandler($file_handler);
//     return $logger;
// };

//注入实例到基类
$container[\Ran\controller\controller::class] = function ($container) {
    return new \Ran\controller\controller($container);
};

//var_dump($container[\Ran\controller\controller::class]);exit;