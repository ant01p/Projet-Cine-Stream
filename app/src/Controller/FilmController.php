<?php 
namespace Cine\App\Controller;

class FilmController
{
    public function index()
    {
        require_once __DIR__ . '/../view/index.phtml';
    }
}