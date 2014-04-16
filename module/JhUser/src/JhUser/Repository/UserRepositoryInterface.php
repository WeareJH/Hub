<?php

namespace JhUser\Repository;

use JhUser\Entity\User;

/**
 * Interface UserRepositoryInterface
 * @package JhUser\Repository
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
interface UserRepositoryInterface
{
    /**
     * @param bool $paginate
     * @return User[]
     */
    public function findAll($paginate = false);

    /**
     * @param string $email
     * @return User
     */
    public function findOneByEmail($email);


    /**
     * @param int $id
     * @return User
     */
    public function find($id);


    /**
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return User[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);


    /**
     * @param array $criteria
     * @return User
     */
    public function findOneBy(array $criteria);

}
