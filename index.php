<?php 

require_once "vendor/autoload.php";

use mvcobjet\controllers\FrontController; 
use mvcobjet\controllers\BackController; 

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/src/views');
$twig = new Environment($loader, ['cache' => false,'debug' => true]);

// voir les espaces de noms
// https://openclassrooms.com/fr/courses/1217456-les-espaces-de-noms-en-php
// use permet de créer un alias 
// ici c'est comme si on disait :
// use MvcObjet\Controllers\FrontController as FrontController

$fc = new FrontController($twig);
$bc = new BackController();

// pour klein redirection .htaccess
/*-------------------------------------
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule . index.php [L] 
--------------------------------------*/
$base  = dirname($_SERVER['PHP_SELF']);
// PHP_SELF -> nom du chemin + php de la racine (ex: /afpa/mvcobjet/index.php)
// dirname = /afpa/mvcobjet 
// REQUEST_URI = /afpa/mvcobjet/jami
//  apres trim REQUEST_URI => afpa/mvcobjet (utilisé par dispatch de klein)

if(ltrim($base, '/')){ 
    $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($base));
}

$route = new \Klein\Klein();

$route->respond('GET','/genres', function() use($fc) {
    // use est une manière d'effectuer une closure en PHP 
   $fc->genres(); //appel de la fonction genres du controleur
});

$route->respond('GET','/acteurs', function() use($fc) {
   $fc->acteurs(); 
});

$route->respond('GET','/realisateurs', function() use($fc) {
   $fc->realisateurs(); 
});

$route->respond('GET','/movie/[:id]', function($request) use($fc) {
   $fc->movie($request->id); 
});

$route->respond('POST','/addmovie', function($request,$post) use($bc) {
   $bc->addMovie($request->paramsPost());
});


$route->dispatch(); 

?>