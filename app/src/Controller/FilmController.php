<?php 
namespace Cine\App\Controller;

use Cine\App\Repository\FilmRepository;
use Cine\App\Repository\GenreRepository;

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

}