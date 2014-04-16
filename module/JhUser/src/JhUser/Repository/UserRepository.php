<?php

namespace JhUser\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use ZfcUser\Mapper\UserInterface;

/**
 * Class UserRepository
 * @package JhUser\Repository
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class UserRepository implements UserRepositoryInterface, ObjectRepository
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $userRepository;

    /**
     * @param ObjectRepository $userRepository
     */
    public function __construct(ObjectRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Return a paginator object using the query builder object
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @return \Zend\Paginator\Paginator
     */
    public function paginate(QueryBuilder $queryBuilder)
    {
        return new Paginator(
            new DoctrinePaginator(new ORMPaginator($queryBuilder))
        );
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @param bool $paginate
     * @see    ObjectRepository::findAll()
     * @return UserInterface[]
     */
    public function findAll($paginate = false)
    {
        $qb = $this->userRepository->createQueryBuilder('u');

        if ($paginate) {
            return $this->paginate($qb);
        }
        return $qb->getQuery()->getResult();
    }

    /**
     * @param string $email
     * @return UserInterface|null
     */
    public function findOneByEmail($email)
    {
        return $this->userRepository->findOneBy(array('email' => $email));
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int $id
     * @return UserInterface|null
     */
    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array      $criteria
     * @param  array|null $orderBy
     * @param  int|null   $limit
     * @param  int|null   $offset
     * @return UserInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->userRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array $criteria
     * @return UserInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->userRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->userRepository->getClassName();
    }
}
