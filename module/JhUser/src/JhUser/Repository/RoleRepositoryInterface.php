<?php

namespace JhUser\Repository;

/**
 * Interface RoleRepositoryInterface
 * @package JhUser\Repository
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
interface RoleRepositoryInterface
{
    /**
     * @param string $roleId
     * @return \JhUser\Entity\Role|null
     */
    public function findByRoleId($roleId);

    /**
     * @param array $criteria
     * @return Role
     */
    public function findOneBy(array $criteria);
}
