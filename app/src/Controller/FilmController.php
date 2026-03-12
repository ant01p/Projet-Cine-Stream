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
        $films = $this->filmRepo->findAll();
        
        require_once __DIR__ . '/../view/index.phtml';
    }
}