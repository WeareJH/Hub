<?php

namespace JhUser\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use JhUser\Entity\Role;

/**
 * Class RoleRepository
 * @package JhUser\Repository
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class RoleRepository implements RoleRepositoryInterface, ObjectRepository
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $roleRepository;

    /**
     * @param ObjectRepository $roleRepository
     */
    public function __construct(ObjectRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
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
     * @param string $roleId
     * @return Role|null
     */
    public function findByRoleId($roleId)
    {
        return $this->roleRepository->findOneBy(array('roleId' => $roleId));
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @param bool $paginate
     * @see    ObjectRepository::findAll()
     * @return Role[]
     */
    public function findAll($paginate = false)
    {
        $qb = $this->roleRepository->createQueryBuilder('u');

        if ($paginate) {
            return $this->paginate($qb);
        }
        return $qb->getQuery()->getResult();
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int $id
     * @return Role|null
     */
    public function find($id)
    {
        return $this->roleRepository->find($id);
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array      $criteria
     * @param  array|null $orderBy
     * @param  int|null   $limit
     * @param  int|null   $offset
     * @return Role[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->roleRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array $criteria
     * @return Role|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->roleRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->roleRepository->getClassName();
    }
}
