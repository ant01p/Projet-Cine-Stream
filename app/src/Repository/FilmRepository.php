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
}


