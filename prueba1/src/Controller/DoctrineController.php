<?php

namespace App\Controller;

use App\Repository\CategoriaRepository;
use App\Repository\EspacioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/doctrine")
 */
class DoctrineController extends AbstractController
{
    /**
     * @Route("/prueba1")
     */
    public function prueba1(CategoriaRepository $categoriaRepository): Response
    {
        $categorias = $categoriaRepository->findAll(['nombre' => 'ASC']);

        return $this->render('doctrine/index.html.twig', [
            'categorias' => $categorias,
            'titulo' => 'Categorias',
        ]);
    }
    /**
     * @Route("/prueba2/{id}")
     */
    public function prueba2(
        EspacioRepository $espacioRepository,
        CategoriaRepository $categoriaRepository,
        $id
    ): Response {
        $espacio = $espacioRepository->find($id);
        $categorias = $categoriaRepository->findBy(['espacio' => $espacio]);

        return $this->render('doctrine/index.html.twig', [
            'categorias' => $categorias,
            'titulo' => 'Categorias del espacio' . $espacio->getNombre(),
        ]);
    }
}
