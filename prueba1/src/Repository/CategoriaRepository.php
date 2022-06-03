<?php

namespace App\Repository;

use App\Entity\Categoria;
use App\Entity\Espacio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categoria>
 *
 * @method Categoria|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categoria|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categoria[]    findAll()
 * @method Categoria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoria::class);
    }

    public function add(Categoria $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Categoria $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByEspacio(Espacio $espacio)//utilizar los repositorios para la consulta
    {
        $dql = 'SELECT c FROM App\Entity\Categoria c JOIN c.espacio e WHERE c.espacio = :espacioParam';//los dos puntos es un parámetro
        $query = $this -> getEntityManager()->createQuery($dql);
        $query->setParameter('espacioParam', $espacio);
        return $query -> getResult();//ya tenemos el query a partir de la consulta dql
    }

    public function findByEspacioQueryBuilder(Espacio $espacio)//es lo mismo que con dql pero con el createquerybuilder
    {
        $qb = $this -> createQueryBuilder('c')
            ->join('c.espacio', 'e')
            -> where('c.espacio = : espacioParam')
            ->setParameter('espacioParam', $espacio)
    ;
        return $qb -> getQuery()->getResult();//solo con esto escrito y la variable arriba es como un findAll
    }

//    /**
//     * @return Categoria[] Returns an array of Categoria objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Categoria
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
