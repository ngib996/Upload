<?php

namespace JCV\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function getUsers($limit = null) {
//        $qb = $this->createQueryBuilder('u')
//                ->select('u')
//                ->addOrderBy('u.created', 'DESC');

//        $qb = $this->createQueryBuilder('u')
//                ->select('u', 'ui','cd')
//                ->join('u.userInfo', 'ui')
//                ->join('u.contactData', 'cd')
//                ->addOrderBy('u.created', 'DESC');
               $qb = $this->createQueryBuilder('u')
                ->select('u')
                ->addOrderBy('u.created', 'DESC');

        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
    public function getUserHavingLivePartner($user) {
        $qb = $this->createQueryBuilder('u')
                ->select('u')
                ->where('u.lifePartner = ?1')
                ->setParameter(1, $user->getId());
        return $qb->getQuery()->getResult();
    }



}
