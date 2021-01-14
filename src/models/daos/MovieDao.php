<?php

namespace mvcobjet\Models\Daos;

use mvcobjet\Models\Entities\Movie;

use DateTime;

class MovieDao extends BaseDao
{
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM movie WHERE id = :id");
        $res = $stmt->execute([':id' => $id]);

        if ($res) {
            return $this->createObjectFromFields($stmt->fetch(\PDO::FETCH_ASSOC));
        } else {
            throw new \PDOException($stmt->errorInfo()[2]);
        }
    }

    public function createObjectFromFields($fields): Movie
    {
        $movie = new Movie();
        $movie->setId($fields['id'])
            ->setTitle($fields['title'])
            ->setDescription($fields['description'])
            ->setDate(\DateTime::createFromFormat('Y-m-d', $fields['date']))
            ->setCoverImage($fields['cover_image'])
            ->setDuration($fields['duration']);

        return $movie;
    }

    public function create(Movie $movie)
    {
        $stmt = $this->db->prepare("
          INSERT INTO movie(title, description, duration, date, cover_image, genre_id, director_id) 
          VALUES(:title, :description, :duration, :date, :cover_image, :genre_id, :director_id)
        ");

        $res = $stmt->execute([
            ':title' => $movie->getTitle(),
            ':description' => $movie->getDescription(),
            ':duration' => $movie->getDuration(),
            ':date' => $movie->getDate()->format('Y-m-d'),
            ':cover_image' => $movie->getCoverImage(),
            ':genre_id' => $movie->getGenre()->getId(),
            ':director_id' => $movie->getDirector()->getId()
        ]);

        if (!$res) {
            throw new \PDOException($stmt->errorInfo()[2]);
        }
    }

    public function update($id, Movie $movie)
    {
        $stmt = $this->db->prepare("
          UPDATE movie
          SET 
            title=:title,
            description=:description, 
            duration=:duration, 
            date=:date,
            cover_image=:cover_image, 
            genre_id=:genre_id,
            director_id=:director_id
          WHERE id=:id
        ");

        var_dump($movie->getDate());

        $res = $stmt->execute([
            ':id' => $id,
            ':title' => $movie->getTitle(),
            ':description' => $movie->getDescription(),
            ':duration' => $movie->getDuration(),
            ':date' => $movie->getDate()->format('Y-m-d'),
            ':cover_image' => $movie->getCoverImage(),
            ':genre_id' => $movie->getGenre()->getId(),
            ':director_id' => $movie->getDirector()->getId()
        ]);

        if (!$res) {
            throw new \PDOException($stmt->errorInfo()[2]);
        }
    }

}
