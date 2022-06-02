<?php

namespace App\Command;

use App\Entity\Categoria;
use App\Entity\Espacio;
use App\Repository\CategoriaRepository;
use App\Repository\EspacioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CodespaceInitBlogCommand extends Command
{
    protected static $defaultName = 'codespace:init-blog';
    protected static $defaultDescription = 'Add a short description for your command';

private $em;
private $espacioRepository;
private $categoriaRepository;

    public function __construct(EntityManagerInterface $em, EspacioRepository $espacioRepository, CategoriaRepository $categoriaRepository)
    {
        parent::__construct();
        $this ->em = $em;
        $this ->espacioRepository = $espacioRepository;
        $this ->categoriaRepository = $categoriaRepository;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('ok');

        // $espacio = new Espacio();
        // $espacio->setNombre('Espacio 3');
        // $this->em->persist($espacio);

        // $espacio1 = $this->espacioRepository->find(1);
        // $espacio1->setNombre('Nombre cambiado');

        // $espacio2 = $this -> espacioRepository->find(2);
        // $this->em->remove($espacio2);

        // $espacio = $this -> espacioRepository -> findOneBy(['nombre' => 'Espacio 3']);

        // $categoria = new Categoria();
        // $categoria -> setNombre('Categoria 1');
        // $categoria-> setEspacio($espacio);
        // $this -> em -> persist($categoria);

        $categorias = $this -> categoriaRepository->findAll(['nombre' => 'ASC']);
        foreach ($categorias as $categoria) {
            $output->writeln($categoria->getNombre() . ' - ' . $categoria->getEspacio());
        }

        $espacio = $this -> espacioRepository -> findOneBy(['nombre' => 'Espacio 3']);
        $categoriasEspacio = $this -> categoriaRepository->findByl(['espacio' => $espacio], ['nombre' => 'ASC']);
        foreach ($categoriasEspacio as $categoria) {
            $output->writeln($categoria->getNombre() . ' - ' . $categoria->getEspacio());
        }
        // $this->em->flush();

        return 0;
    }
}
