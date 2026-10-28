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
    use App\Controllers\CartController;
    use App\Controllers\OrderController;
    use App\Controllers\AccountController;
    use App\Controllers\AdminController;
    use App\Controllers\AdminAuthController;
    use App\Middleware\AuthMiddleware;

    Flight::route('/login', [new AuthenController(),'login']);


    Flight::route('POST /Authenticate', [new AuthenController(),'Authent']);
    Flight::route('/register', [new AuthenController(),'register']);
    Flight::route('POST /addUser', [new AuthenController(),'addUser']);
    Flight::route('/logout', [new AuthenController(),'logout']);
    Flight::route('/testthis',[new HomeController(),'testing']);
    Flight::route('/', [new HomeController(),'index']);


    Flight::route('/addproduct', [new AdminController(), 'newProduct']);
    Flight::route('POST /add', [new AdminController(), 'createProduct']);
    Flight::route('GET /product/@id', [new ProducController(), 'openProduct']);
    Flight::route('GET /products/@id', [new ProducController(), 'passdata']);
    Flight::route('POST /addToCart/@id', [new ProducController(), 'addToCart']);
    Flight::route('GET /cart', [new CartController(), 'index']);
    Flight::route('GET /checkout', [new CartController(), 'checkout']);
    Flight::route('POST /checkout', [new OrderController(), 'place']);
    Flight::route('GET /order-success/@number', [new OrderController(), 'success']);
    Flight::route('GET /account', [new AccountController(), 'index']);
    Flight::route('POST /account/orders/@id/cancel', [new AccountController(), 'cancelOrder']);
    Flight::route('GET /admin/login', [new AdminAuthController(), 'login']);
    Flight::route('POST /admin/login', [new AdminAuthController(), 'authenticate']);
    Flight::route('POST /admin/logout', [new AdminAuthController(), 'logout']);
    Flight::route('GET /admin', [new AdminController(), 'index']);
    Flight::route('POST /admin/products', [new AdminController(), 'createProduct']);
    Flight::route('POST /admin/products/@id/edit', [new AdminController(), 'editProduct']);
    Flight::route('POST /admin/products/@id/stock', [new AdminController(), 'updateStock']);
    Flight::route('POST /admin/products/@id/delete', [new AdminController(), 'deleteProduct']);
    Flight::route('POST /admin/orders/@id/status', [new AdminController(), 'updateOrderStatus']);
    Flight::route('GET /tracking/@id/status', [new OrderController(), 'trackingStatus']);
    Flight::route('GET /tracking/@id', [new OrderController(), 'tracking']);
    Flight::route('POST /cart/@key/quantity', [new CartController(), 'updateQuantity']);
    Flight::route('POST /cart/@key/remove', [new CartController(), 'remove']);



    // // to use middleware do this:

    // Flight::group('/home', function (){

    //     //routes
    //     Flight::route('/', [new HomeController(), 'index']);


    // }, [new AuthMiddleware(), 'before']);
Flight::set('flight.debug', true);  
    Flight::start();
?>
