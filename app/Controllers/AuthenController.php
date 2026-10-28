<?php
namespace App\Controllers;
use App\Models\User;
use App\Models\Cart;

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
class AuthenController{
    public function login (){

    if(isset($_SESSION['user'])){
        \Flight::redirect('/');
        return;
    }
       \Flight::render('login.twig', []);
    }

    public function register (){

        \Flight::render('register.twig', []);

    }
    public function logout (){
        session_unset(); 
        session_destroy();
        \Flight::redirect('/login');
    }
    public function addUser(){
        if(isset($_POST['email']) && isset($_POST['name']) && isset( $_POST['phonenum']) && isset($_POST['password']) && isset($_POST['confpassword'])){
            if($_POST['password'] !== $_POST['confpassword']){
            \Flight::render('register.twig',[
                'err'=> 'Password Doesnt Match'
            ]); 
            return;
            }
                $email= $_POST['email'];
                $name= $_POST['name'];
                $phonenum= $_POST['phonenum'];
                $password= $_POST['password'];

            try{
                $user = new User();
                $user->register($name, $email, $phonenum, $password) ;
                
                // echo 'HELLOO???';
                // die();
                \Flight::render('login.twig', ['succ' => 'Registration Complete']);
            }catch(\Exception $e){
            echo '<pre>';
            echo $e->getMessage();
            echo '</pre>';

            die();
            }
        }else{
        \Flight::render('register.twig',[
            'err'=> 'Error sir'
        ]);    
    }
    }

    public function Authent(){
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        if (!is_string($email) || !is_string($password) || !filter_var(trim($email), FILTER_VALIDATE_EMAIL) || $password === '') {
            \Flight::render('login.twig', ['err' => 'Enter a valid email address and password.']);
            return;
        }

        try {
            $user = (new User())->getByEmail(trim($email));
            if ($user === null || !password_verify($password, $user['password'])) {
                \Flight::render('login.twig', ['err' => 'Invalid email address or password.']);
                return;
            }

            session_regenerate_id(true);
            (new Cart())->mergeGuestCart((int) $user['id']);
            $_SESSION['user'] = (int) $user['id'];
            unset($_SESSION['cart_csrf']);
            \Flight::redirect('/', 303);
        } catch (\Throwable $error) {
            error_log('Login failed (' . get_class($error) . ', code ' . $error->getCode() . ').');
            \Flight::render('login.twig', ['err' => 'Could not sign in. Please try again.']);
        }
    }

    
}

?>
