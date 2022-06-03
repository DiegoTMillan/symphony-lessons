<?php

namespace App\Repository;

use App\Entity\Entrada;
use App\Entity\Espacio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Entrada>
 *
 * @method Entrada|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrada|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrada[]    findAll()
 * @method Entrada[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntradaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entrada::class);
    }

    public function add(Entrada $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Entrada $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByEspacio(Espacio $espacio)
    {
        $dql = 'SELECT e FROM App\Entity\Entrada e JOIN e.categoria c WHERE c.espacio = :espacio';
        $query = $this -> getEntityManager()->createQuery($dql);
        $query->setParameter('espacio', $espacio);
        return $query -> getResult();//ya tenemos el query a partir de la consulta dql
    }

    public function findByFilter($params)
    {
        $qb = $this -> createQueryBuilder('e');

        if (isset($params['categoria'])) {
            $qb->andWhere('e.categoria = categoria');
            $qb->setParameter('categoria', $params['categoria']);
        }
        if (isset($params['usuario'])) {
            $qb->andWhere('e.usuario = usuario');
            $qb->setParameter('usuario', $params['usuario']);
        }
        if (isset($params['espacio'])) {
            $qb->join('e.categoria', 'c');
            $qb->andWhere('c.espacio = :espacio');
            $qb->setParameter('espacio', $params['espacio']);
        }
        
        
        
        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Entrada[] Returns an array of Entrada objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Entrada
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
