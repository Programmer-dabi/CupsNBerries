<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    if (php_sapi_name() === 'cli-server') {

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $file = __DIR__ . $path;

        if (is_file($file)) {
            return false;
        }
    }
    session_start();

    require './vendor/autoload.php';
    require './app/Database/database.php';
    require './conf.php';

    use App\Controllers\AuthenController;
    use App\Controllers\HomeController;
    use App\Controllers\ProducController;
    use App\Middleware\AuthMiddleware;

    Flight::route('/login', [new AuthenController(),'login']);


    Flight::route('POST /Authenticate', [new AuthenController(),'Authent']);
    Flight::route('/register', [new AuthenController(),'register']);
    Flight::route('POST /addUser', [new AuthenController(),'addUser']);
    Flight::route('/logout', [new AuthenController(),'logout']);
    Flight::route('/testthis',[new HomeController(),'testing']);
    Flight::route('/', [new HomeController(),'index']);


    Flight::route('/addproduct', [new ProducController(), 'index']);
    Flight::route('POST /add', [new ProducController(), 'add']);
    Flight::route('GET /product/@id', [new ProducController(), 'openProduct']);
    Flight::route('GET /products/@id', [new ProducController(), 'passdata']);



    // // to use middleware do this:

    // Flight::group('/home', function (){

    //     //routes
    //     Flight::route('/', [new HomeController(), 'index']);


    // }, [new AuthMiddleware(), 'before']);
Flight::set('flight.debug', true);  
    Flight::start();
?>