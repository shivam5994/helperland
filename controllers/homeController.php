<?php
class homeController {
    function index(){
        
        include 'general.php';
        include 'views/index.php';
    }
    function about(){
        $title='About';
        include 'general.php';
        include 'views/header.php';
        include 'views/about.php';
    }
    function faq(){
        $title='Faq';
        include 'general.php';
        include 'views/header.php';
        include 'views/faq.php';
    }
    function contact(){
        $title='Contact';
        include 'general.php';
        include 'views/header.php';
        include 'views/contact.php';
    }
    function prices(){
        $title='Prices';
        include 'general.php';
        include 'views/header.php';
        include 'views/prices.php';
    }
    
}