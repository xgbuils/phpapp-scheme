<?php
    require_once('Router/RouterHandler.php');
    require_once('Router/StaticRouter.php');
    require_once('Router/ApiRouter.php');

    $staticRouter  = new StaticRouter();
    $apiRouter     = new ApiRouter();

    $staticRouter->get('/', 'Views/main.html');
    $apiRouter->route('api/users'  , 'UsersController'  );
    $apiRouter->route('api/objects', 'ObjectsController');
    $apiRouter->route('api/actions', 'ActionsController');

    $routerHandler = new RouterHandler();
    $routerHandler->add($staticRouter);
    $routerHandler->add($apiRouter);

    $routerHandler->exec();
?>