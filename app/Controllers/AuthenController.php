<?php
namespace App\Controllers;
use App\Models\User;

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
class AuthenController{
    public function login (){

    if(isset($_SESSION['user'])){
        \Flight::render('home.twig');
    }
       \Flight::render('login.twig', []);
    }

    public function register (){

        \Flight::render('register.twig', []);

    }
    public function logout (){
        session_unset(); 
        session_destroy();
        \Flight::render('login.twig', []);
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
        if(isset($_POST['email']) && isset($_POST['password'])){
            $user = new User();
            foreach ($user -> getUsers() as $val) {
                if($val['email'] === $_POST['email']){
                    $_SESSION['user'] = $val['id'];

                    \Flight::render('home.twig');
                }
            }
        }else{
        \Flight::render('login.twig', [
                
            ]);
        }
    }

    
}

?>