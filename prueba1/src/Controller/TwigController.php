<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/twig")
 */
class TwigController extends AbstractController
{
    /**
     * @Route("/index")
     */
    public function index(): Response
    {
        return $this->render('twig/index.html.twig', [
            'nombre' => 'Diego',
            'direccion' => [
                'calle' => 'avenida Libertad',
                'numero' => '2',
                'planta' => 1,
                'codigoPostal' => '29602'
                            ]
        ]);
    }

    /**
     * @Route("/blog")
     */
    public function blog(): Response
    {
        return $this -> render('twig/blog.html.twig', [
            'menu2' => 'twig/menu2.html.twig']);
    }

    /**
     * @Route("/backoffice")
     */
    public function backoffice(): Response
    {
        return $this -> render('twig/backoffice.html.twig', [
            'menu' => 'twig/menu.html.twig']);
    }
    
}
