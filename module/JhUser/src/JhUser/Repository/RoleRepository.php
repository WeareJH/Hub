<?php

namespace JhUser\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

/**
 * Class RoleRepository
 * @package JhUser\Repository
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class RoleRepository
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
     * @param $roleId
     * @return object
     */
    public function findByRoleId($roleId)
    {
        return $this->roleRepository->findOneBy(array('roleId' => $roleId));
    }
}
