<?php 
namespace Cine\App\Controller;

use Cine\App\Repository\FilmRepository;
use Cine\App\Repository\GenreRepository;
use Cine\App\Service\Tmdb\Tmdb;

class FilmController
{
    private $genreRepo;
    private $filmRepo;

    public function __construct()
    {
        $this->genreRepo = new GenreRepository;
        $this->filmRepo = new FilmRepository;
    }
    
    public function index()
    {
        $genres = $this->genreRepo->findAll();
        
        if(isset($_GET['category'])) {
            $category = $_GET['category'];
        } else {
            $category = "all";
        }

        $films = $this->filmRepo->findByCategory($category);

        require_once __DIR__ . '/../view/index.phtml';
    }

     public function show()
    {
        $id = $_GET['id'];

        $film = $this->filmRepo->findFilm($id);

        require_once __DIR__ . '/../view/show.phtml';
    }

     public function delete()
    {
        if (empty($_GET['id'])) {
            header('Location: index.php?route=index');
        exit();
        }
        
        $film = $this->filmRepo->findFilm((int) $_GET['id']);

        $this->filmRepo->deleteFilm($film->getId());
        
        header('Location: index.php?message=supprimé');
        exit();
    }

     public function update()
    {
        if (empty($_GET['id'])) {
            header('Location: index.php?route=index');
        exit();
        }

        $id = (int) $_GET['id'];

        $film = $this->filmRepo->findFilm($id);
        $genres = $this->genreRepo->findAll();

        if (!empty($_POST)) {
            if (isset($_POST['genre_id']) && $_POST['genre_id'] !== '') {
                $genreId = $_POST['genre_id'];
            } else {
                $genreId = null;
            }

            $description = trim($_POST['description']);

            if (isset($_POST['isWatched'])) {
                $isWatched = $_POST['isWatched'];
            } else {
                $isWatched = 0;
            }

            $this->filmRepo->updateFilm($id, $genreId, $description, $isWatched);

            header('Location: index.php?route=show&id=' . $id . '&message=updated');
            exit();
        }
        require_once __DIR__ . '/../view/update.phtml';
    }

    public function search()
    {
        $results = null;
        $search = '';
        if(isset($_GET['search'])) {
            $search = trim($_GET['search']);
        }
        

        if ($search !== '') {
            $tmdb = new Tmdb;
            $reponse = $tmdb->getFilmByTmdbSearch($search);

            if(isset($reponse['results'])) {
                $results = $reponse['results'];
            } else {
                $results = [];
            }
        }
        require_once __DIR__ . '/../view/search.phtml';
    }

    public function showTmdb()
    {
        if (empty($_GET['id'])) {
            header('Location: index.php?route=search');
            exit();
        }

        $tmdb = new Tmdb;
        $film = $tmdb->getFilmByTmdbId((int) $_GET['id']);

        if (!$film || isset($film['success'])) {
            header('Location: index.php?route=search&message=film_introuvable');
            exit();
        }
        require_once __DIR__ . '/../view/showTmdb.phtml';
    }
}