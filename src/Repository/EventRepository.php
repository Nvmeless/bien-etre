<?php

namespace App\Repository;

use DateTime;
use App\Entity\Event;
use DateTimeImmutable;
use Doctrine\DBAL\Query;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Query\Parameter;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\VarDumper\Cloner\Data;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder as OrmQueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function add(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Renvoie les events par date
     *
     * @param DateTimeImmutable $endDateTime
     * @param DateTimeImmutable|null $startDateTime
     * @param integer|null $page
     * @param integer|null $limit
     * @return void
     */
    public function findEventBetween( 
        DateTimeImmutable $endDateTime,
        ?DateTimeImmutable $startDateTime,
        ?int $page = 1,
        ?int $limit = 100
         ) {
        
        $startDateTime = $startDateTime ?? new DateTimeImmutable();

        $qb =  $this->createQueryBuilder('e');

            $qb->add(
                'where',
                    $qb->expr()->orX(
                        $qb->expr()->andX(
                            $qb->expr()->gte('e.eventStartDate', ':startdate'),
                            $qb->expr()->lte('e.eventStartDate', ':enddate')
                        ),
                        $qb->expr()->andX(
                            $qb->expr()->gte('e.eventEndDate', ':startdate'),
                            $qb->expr()->lte('e.eventEndDate', ':enddate'),
                        )
                    ),
            )
            ->setParameters(new ArrayCollection([
                new Parameter('startdate', $startDateTime,  Types::DATETIME_IMMUTABLE),
                new Parameter('enddate', $endDateTime, Types::DATETIME_MUTABLE)
            ]));

            return $this->andStatusOn($qb, $page, $limit);
        }

        /**
         * Parametre l'envoi de notre donnée et trie les status on
         *
         * @param OrmQueryBuilder|null $qb
         * @param integer|null $page
         * @param integer|null $limit
         * @return void
         */
    public function andStatusOn( 
        ?OrmQueryBuilder $qb,
        ?int $page,
        ?int $limit
     ){
        $limit = $limit ?? 100;
        $page = $page ?? 1;

        $qb = $qb ?? $this->createQueryBuilder('b');
        $qb->andWhere("e.status = 1")
        ->setFirstResult(($page - 1) * $limit)
        ->setMaxResults($limit);

        return $qb->getQuery()->getResult();    
    }

}
