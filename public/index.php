<?php
    use \app\core\Application;
    use \app\controllers\SiteController;
    use \app\controllers\AuthController;
    use Dotenv\Dotenv;

    require_once __DIR__.'/../vendor/autoload.php';

   $dotenv = Dotenv::createImmutable(dirname(__DIR__));
   $dotenv->load();

//    echo "<pre>";
//    echo dirname(__DIR__);
//    echo "</pre>";
//    return;

    $config = [
        'db' => [
            'domain' => $_ENV['DB_DSN'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
        ]
    ];

    $app = new Application(dirname(__DIR__), $config);
    $app->router->get("/", [SiteController::class, "home"]);

    $app->router->get("/login", [AuthController::class, "login"]);
    $app->router->post("/login", [AuthController::class, "login"]);
    $app->router->get("/register", [AuthController::class, "register"]);
    $app->router->post("/register", [AuthController::class, "register"]);


    $app->router->get("/contact", [SiteController::class, "contact"]);
    $app->router->post("/contact", [SiteController::class, "handleContact"]);
    $app->run();
?>