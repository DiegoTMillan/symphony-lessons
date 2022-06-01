<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
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
     * @Route("/blog", name="blog")
     */
    public function blog(RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $formulario = $session->get('formulario');
        return $this->render('twig/blog.html.twig', [
            'menu' => 'twig/menu2.html.twig',
            'titulo' => 'Blog',
            'fechaActual' => new \DateTime(),//para obtener fecha, luego hay que pasarle un filtro
            //que está en el archivo blog para convertirlo a string
            'usuario' => [
                'nombre' => 'Diego',
                'fechaNacimiento' => new \DateTime('1986-08-03 02:36:58'),
                'direccion' => [
                    'calle' => 'Avenida Ricardo Soriano',
                    'numero' => '68',
                    'codigoPostal' => '29602',
                    'ciudad' => 'Marbella'
                ]
                ],
                'formulario' => $formulario
        ]);
    }

    /**
     * @Route("/backoffice", name="backoffice")
     */
    public function backoffice(): Response
    {
        return $this->render('twig/backoffice.html.twig', [
            'menu' => 'twig/menu.html.twig',
            'titulo' => 'Backoffice'
        ]);
    }
}
