<?php

namespace Cine\App\Repository;

use Cine\App\Entity\Film;
use PDO;

class FilmRepository extends Repository
{
    public function findAll() 
    {
        $sql = "SELECT * FROM film";
        $request = $this->pdo->prepare($sql);
        $request->execute();
        $films = $request->fetchAll(PDO::FETCH_CLASS, Film::class);
        
        return $films;
    }

    public function findByCategory($category)
    {
        if($category == "all") {
            $sql = "SELECT * FROM film";
            $request = $this->pdo->prepare($sql);
            $request->execute();
        }
        elseif($category == "nc") {
            $sql = "SELECT * FROM film WHERE genre_id IS NULL";
            $request = $this->pdo->prepare($sql);
            $request->execute();
        }
        elseif($category == "watched") {
            $sql = "SELECT * FROM film WHERE isWatched = 1";
            $request = $this->pdo->prepare($sql);
            $request->execute();
        }
        elseif($category == "towatch") {
            $sql = "SELECT * FROM film WHERE isWatched = 0";
            $request = $this->pdo->prepare($sql);
            $request->execute();
        }
        else {
            $sql = "SELECT * FROM film WHERE genre_id = :genre_id";
            $request = $this->pdo->prepare($sql);
            $request->bindValue(':genre_id', $category, PDO::PARAM_INT);
            $request->execute();
        }

        $films = $request->fetchAll(PDO::FETCH_CLASS, Film::class);

        return $films;
    }

    public function find($id)
    {
        $sql = "SELECT * FROM film WHERE id = :id";
        $request = $this->pdo->prepare($sql);
        $request->execute(['id' => $id]);
        $request->setFetchMode(PDO::FETCH_CLASS, Film::class);
        $film = $request->fetch();

        return $film;
    }

    public function findFilm($id)
    {
        $sql = "SELECT F.*, G.name AS genre_name
                FROM film F
                LEFT JOIN genre G ON F.genre_id = G.id
                WHERE F.id = :id";

        $request = $this->pdo->prepare($sql);
        $request->execute(['id' => $id]);
        $request->setFetchMode(PDO::FETCH_CLASS, Film::class);
        $film = $request->fetch();

        return $film;
    }

    public function deleteFilm($id)
    {
        $sql = 'DELETE FROM film WHERE id = :id';
        $request = $this->pdo->prepare($sql);
        $request->execute(array('id' => $id));
    }

    public function updateFilm($id, $genreId, $description, $isWatched)
    {
        if ($genreId === '') {
        $genreId = null;
    }

        $sql = "UPDATE film SET genre_id = :genre_id, description = :description, isWatched = :isWatched WHERE id = :id";
        $request = $this->pdo->prepare($sql);
        $request->execute([
            'genre_id' => $genreId,
            'description' => $description,
            'isWatched' => $isWatched,
            'id' => $id
        ]);
    }

     public function findByTmdbId($tmdbId)
    {
        $sql = "SELECT * FROM film WHERE tmdb_id = :tmdb_id";
        $request = $this->pdo->prepare($sql);
        $request->execute([
            'tmdb_id' => $tmdbId
        ]);
        $request->setFetchMode(PDO::FETCH_CLASS, Film::class);
        $film = $request->fetch();

        return $film;
    }

    public function addFilm($tmdbId, $title, $posterPath, $releaseDate, $runtime, $overview)
    {
        $sql = "INSERT INTO film (tmdb_id, title, poster_path, release_date, runtime, overview, genre_id, description, isWatched)
                VALUES (:tmdb_id, :title, :poster_path, :release_date, :runtime, :overview, :genre_id, :description, :isWatched)";

        $request = $this->pdo->prepare($sql);
        $request->execute([
            'tmdb_id' => $tmdbId,
            'title' => $title,
            'poster_path' => $posterPath,
            'release_date' => $releaseDate,
            'runtime' => $runtime,
            'overview' => $overview,
            'genre_id' => null,
            'description' => null,
            'isWatched' => 0
        ]);

        return $this->pdo->lastInsertId();
    }
}



