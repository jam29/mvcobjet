<?php

namespace mvcobjet\Controllers;
// l'espace de nom est le nom de mon projet + le nom du répertoire ou se trouve mpon controleur
// puis commande composer dumpautolaod 
// creation d'un répertoire vendor.composer/autoload.php
// qu'on peut injecter dans le fichier d'index pour chargement automatiquement les librairies

/*
sur le version précédente j'utilisais DAO directement , ici on passe par les services
*/
/*
use mvcobjet\Models\Daos\GenreDao;
use mvcobjet\Models\Entities\Genre;
*/

use mvcobjet\Models\Services\GenreService; 
use mvcobjet\Models\Services\ActorService; 
use mvcobjet\Models\Services\DirectorService; 
use mvcobjet\Models\Services\MovieService; 

use Twig\Environment;

class FrontController
{
    private $genreService ;
    private $actorService ;
    private $directorService ;
    private $movieService ;

    private $twig;
    
    public function __construct($twig){
        // instanciation du service Genre
        $this->genreService = new GenreService();
        $this->actorService = new ActorService();
        $this->directorService = new directorService();
        $this->movieService = new movieService();
        $this->twig = $twig;
    }

    public function genres() {
        /* 
         sur la version précédente j'utilisais DAO directement , ici on passe par les services
             avant :$genreDao = new GenreDao();
        */
        // $genres = $genreDao->findAll();
       
       $genres = $this->genreService->getAllGenres();    
        /*
            on affichait les genres directement dans le controleur
            ici on lance le template php de base
            Perso: php était déja un moteur de template mais les framework s'évertuenet à utiliser d'autres templates
        */
        // include_once __DIR__.'/../views/genre.php';
        /* Dans ce views/genre.php :
        foreach ($genres as $genre) { ?>
            <li><?= $genre->getName() ?></li>
        <?php } ?>
        */
       echo $this->twig->render('genres.html.twig', [ "genres" => $genres ] );
    }

    public function acteurs()
    {
       $acteurs = $this->actorService->getAllActors();
       echo $this->twig->render('actor.html.twig', ["acteurs" => $acteurs]);   
    }

    public function realisateurs()
    {
       $reals = $this->directorService->getAlldirecteurs();
       echo $this->twig->render('directors.html.twig', ["reals" => $reals]);   
    }

    // idem avec directeurs...

    // récupérer 1 genre par son id
    public function genre($id) {
        $genre = $this->genreService->getById($id);
        echo $this->twig->render('genreseul.html.twig', ["genre" => $genre]);   
    }

    public function movie($id) {
       $movie = $this->movieService->getById($id);
       echo "<pre>";
       print_r($movie->getActors());
       echo "</pre>";
       die();
       /*
        ['movie' => $movie, 'actors' => $actors] = $this->movieService->getFullMovie($id);
        echo $this->twig->render('movie.html.twig', ["movie" => $movie,"actors" => $actors ]); 
        */
       
        echo $this->twig->render('movie.html.twig', ["movie" => $movie ]); 
    }
}