<?php

namespace App\Controller;

use App\Entity\Entrada;
use App\Repository\CategoriaRepository;
use App\Repository\EntradaRepository;
use App\Repository\EspacioRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/doctrine")
 */
class DoctrineController extends AbstractController
{
    /**
     * @Route("/espacios")
     */
    public function espacios(EspacioRepository $espacioRepository): Response
    {
        $espacios = $espacioRepository->findAll(['nombre' => 'ASC']);

        return $this->render('doctrine/espacios.html.twig', [
            'espacios' => $espacios,
            'titulo' => 'Espacios',
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
        $categorias = $categoriaRepository->findByEspacioQueryBuilder($espacio); //aquí declaro la función 
        //findByEspacio que está en el archivo CategoriaRepository que es donde deben
        //estar las consultas

        return $this->render('doctrine/index.html.twig', [
            'categorias' => $categorias,
            'titulo' => 'Categorias del espacio' . $espacio->getNombre(),
        ]);
    }
    /**
     * @Route("/entradas/{id}")
     */
    public function entradas(CategoriaRepository $categoriaRepository, EntradaRepository $entradaRepository,  $id)
    {
        $categoria = $categoriaRepository->find($id);
        $entradas = $entradaRepository->findBy(['categoria' => $categoria], ['titulo' => 'ASC']);

        return $this->render('doctrine/entradas.html.twig', [
            'entradas' => $entradas,
            'titulo' => 'Entradas para la categoria' . $categoria->getNombre()
        ]);
    }

    /**
     * @Route("/entradas2/{id}")
     */
    public function entradas2(EspacioRepository $espacioRepository, CategoriaRepository $categoriaRepository, EntradaRepository $entradaRepository,  $id)
    {
        $espacio = $espacioRepository->find($id);
        if ($espacio == null) {
            throw $this->createNotFoundException('Este parámetro no existe');
        }
        $entradas = $entradaRepository->findByEspacio($espacio);

        return $this->render('doctrine/entradas.html.twig', [
            'entradas' => $entradas,
            'titulo' => 'Entradas para la categoria ' . $espacio->getNombre()
        ]);
    }

    /**
     * @Route("/entrada-api/", methods={"GET"})
     */
    public function entradaApi(Request $request, EntradaRepository $entradaRepository)
    {
        $params = $request->query->all();
        $entradas = $entradaRepository->findByFilter($params);

        $datos = [];
        foreach ($entradas as $entrada) {
            $datos[] = [ //solución creando array manualmente
                'slug' => $entrada->getSlug(),
                'fecha' => $entrada->getFecha()->format('Y-m-d H:i:s'),
                'titulo' => $entrada->getTitulo(),
                'resumen' => $entrada->getResumen()
            ];
        }

        return new JsonResponse([
            'resultado' => 'ok',
            'datos' => $datos //en vez de $datos porque es la opción comentada.
        ]);
    }

    /**
     * @Route("/entrada-api", methods={"POST"})
     */
    public function entradaApiPost(
        Request $request,
        UsuarioRepository $usuarioRepository,
        CategoriaRepository $categoriaRepository,
        EntityManagerInterface $em
    ) {
        $data = $request->toArray();
        $usuario = $usuarioRepository->find(1);
        $categoria = $categoriaRepository->find($data['categoria']);
        $entrada = new Entrada();
        $entrada->setSlug('slug' . uniqid());
        $entrada->setTitulo($data['titulo']);
        $entrada->setResumen($data['resumen']);
        $entrada->setEstado(1);
        $entrada->setFecha(new \DateTime());
        $entrada->setUsuario($usuario);
        $entrada->setCategoria($categoria);
        $entrada->setTexto($data['texto']);
        $em->persist($entrada);
        $em->flush();
        return new JsonResponse([
            'resultado' => 'ok',
            'id' => $entrada->getId()
        ]);
    }
    /**
     * @Route("/entrada-api/{id}", methods={"PUT"})
     */
    public function entradaApiPut(
        Request $request,
        UsuarioRepository $usuarioRepository,
        EntradaRepository $entradaRepository,
        CategoriaRepository $categoriaRepository,
        EntityManagerInterface $em,
        $id
    ) {
        $data = $request->toArray();
        $entrada = $entradaRepository->find($id);
        if (isset($data['titulo'])) {
            $entrada->setTitulo($data['titulo']);
        }
        if (isset($data['texto'])) {
            $entrada->setTexto($data['texto']);
        }
        if (isset($data['resumen'])) {
            $entrada->setResumen($data['resumen']);
        }
        $em->flush();

        return new JsonResponse([
            'resultado' => 'ok',
        ]);
    }
     /**
     * @Route("/entrada-api/{id}", methods={"DELETE"})
     */
    public function entradaApiDelete(
        EntradaRepository $entradaRepository,
        EntityManagerInterface $em,
        $id
    )
    {
        $entrada = $entradaRepository->find($id);
        $em-> remove($entrada);
        $em->flush();
        return new JsonResponse([
            'resultado' => 'ok'
        ]);
    }
}
