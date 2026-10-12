<?php
namespace App\Controllers;
use App\Models\Product;
use Flight;
use InvalidArgumentException;


class HomeController{
    public function index(){
            try {
            $product = new Product();
            $products = $product->getProductAll();

            Flight::render('home.twig', ['products' => $products]);

            }catch (InvalidArgumentException $error) {
                Flight::halt(400, $error->getMessage());
                return;
            }
    
    }

    public function testing(){
        Flight::render('test.twig');
    }
}
?>