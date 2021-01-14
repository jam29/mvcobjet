<?php

namespace mvcobjet\Models\Services;

use mvcobjet\Models\Daos\ActorDao;
use mvcobjet\Models\Daos\DirectorDao;
use mvcobjet\Models\Daos\GenreDao;
use mvcobjet\Models\Daos\MovieDao;

use mvcobjet\Models\Entities\Actor;
use mvcobjet\Models\Entities\Director;
use mvcobjet\Models\Entities\Genre;
use mvcobjet\Models\Entities\Movie;

class MovieService
{
    private $movieDao;
    private $actorDao;
    private $genreDao;
    private $directorDao;

    public function __construct()
    {
        $this->movieDao = new MovieDao();
        $this->actorDao = new ActorDao();
        $this->directorDao = new DirectorDao();
        $this->genreDao = new GenreDao();
    }

    public function getbyId($id)
    {
        
        $movie = $this->movieDao->findById($id);
       
        $actors = $this->actorDao->findByMovie($id);
        echo "<pre>" ;
        print_r($actors);
        echo "</pre>" ;


       // $actors2 = $this->actorDao->findByMovie($id);

        foreach ($actors as $actor) {
            $movie->addActor($actor);
        }

        $genre = $this->genreDao->findByMovie($id);

       // var_dump($movie);
        
        $movie->setGenre($genre);
        /*
          var_dump($movie);
          die();
        */

        $director = $this->directorDao->findByMovie($id);
        $movie->setDirector($director);

       /* $comments = $this->commentDao->findByMovie($id);*/

        return $movie; 
        /*
        return [
            'movie' => $movie,
            'actors' => $actors2
        ];
        */
    }

    //
    // on a tout ce qu'il faut pour créer l'objet.
    //
    public function create($movieData)
    {
        $movie = $this->movieDao->createObjectFromFields($movieData);

        $genre = $this->genreDao->findById($movieData['genre']);

        $movie->setGenre($genre);

        $director = $this->directorDao->findById($movieData['director']);
        $movie->setDirector($director);

        $this->movieDao->create($movie);
    }

}