<?php

namespace App\Controller;
use App\Form\UsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

 /**
     * @Route("/form")
     */
class FormController extends AbstractController
{
    /**
     * @Route("/prueba1")
     */
    public function prueba1(Request $request, RequestStack $requestStack): Response
    {
        $formUsuario = $this -> createForm(UsuarioType::class);//creada variable con formulario
        //no olvidar poner arriba las clases , que luego se olvidan
        $formUsuario-> handleRequest($request);//siempre así para coger los datos enviados con el POST
        if ($formUsuario -> isSubmitted() && $formUsuario -> isValid()) {
            
            $session = $requestStack -> getSession();
            $resultado = $formUsuario -> getData();
            $session -> set('formulario', $resultado);

        }else{
            $resultado = '';
        }
        return $this->render('form/index.html.twig', [//como siempre esta es la función para pintar
            'form' => $formUsuario -> createView(),
            'titulo' => 'Prueba de formulario',
            'resultado' => $resultado
        ]);
    }
}
