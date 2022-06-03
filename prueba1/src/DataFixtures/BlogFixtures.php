<?php

namespace App\DataFixtures;

use App\Entity\Categoria;
use App\Entity\Entrada;
use App\Entity\Espacio;
use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $usuario = new Usuario();
        $usuario->setEmail('ej@ej.com');
        $usuario->setPassword('12345');
        $usuario->setNombre('usuario1');
        $usuario->setPerfil('administrador');
        $manager->persist($usuario);
        for ($i = 0; $i < 50; $i++){
            $espacio= new Espacio();
            $espacio->setNombre('Espacio' . $i);
            $manager->persist($espacio);

            for ($j=0; $j<10;$j++) {
                $categoria = new Categoria();
                $categoria -> setEspacio($espacio);
                $categoria->setNombre('Categoria ' . $i . ' - ' . $j);
                $manager->persist($categoria);

                for($k=0; $k<5; $k++){
                    $entrada = new Entrada();
                    $entrada->setSlug('entrada-' . uniqid());
                    $entrada->setTitulo('Entrada ' . $k);
                    $entrada->setFecha(new \DateTime());
                    $entrada->setEstado(1);
                    $entrada->setResumen('Resumen');
                    $entrada->setCategoria($categoria);
                    $entrada->setUsuario($usuario);
                    $manager->persist($entrada);//esta función hace que los elementos 'persistan'
                }
            }
        }

        $manager->flush();//este es el método que guarda toda la pila de modificaciones
    }
}
