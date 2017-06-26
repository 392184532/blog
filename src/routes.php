<?php
/*路由*/
//视图路由
//登录界面
$app->get('/login', function ($request, $response) {
    
    // Render login view
    return $this->view->render($response, 'login.html');
});

//主页
$app->get('/', function ($request, $response) {

    // Render index view
    return $this->view->render($response, 'index.html');
})->add( new ExampleMiddleware());

//个人档案
$app->get('/configuration', function ($request, $response) {

    // Render index view
    return $this->view->render($response, 'profile.html');
})->add( new ExampleMiddleware());

//上传文件
$app->get('/file', function ($request, $response) {

    // Render index view
    return $this->view->render($response, 'file.html');
})->add( new ExampleMiddleware());

/*控制器路由*/
//注册
$app->map(['GET', 'POST'], '/register', '\Ran\controller\LoginController:register');
//登录
$app->post('/login', '\Ran\controller\LoginController:login');
//退出登录
$app->map(['GET', 'POST'], '/logout', '\Ran\controller\LoginController:logout');

//个人档案
$app->post('/configuration', '\Ran\controller\UserController:configuration');

//获取redis信息
$app->get('/getCurrentUser','\Ran\controller\UserController:getUser');
//获取新纪录
$app->get('/admin/notOperatOrders','\Ran\controller\NewDataController:getNew');