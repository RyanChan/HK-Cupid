<?php

namespace Champs\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Champs\Entity\Role;

/**
 * Description of RoleRepository
 *
 * @author RyanChan
 */
class RoleRepository extends EntityRepository {

    const MEMBER_ROLE = 'Member';
    const VIP_ROLE = 'VIP';
    const SUPER_VIP_ROLE = 'SuperVIP';
    const ADMINISTRATOR_ROLE = 'Administrator';

    private function _getRoleQuery($role) {
        // create query
        $query = $this->getEntityManager()->createQuery("SELECT r FROM Champs\Entity\Role r WHERE r.rolename = ?1");
        $query->setParameter(1, $role);

        // return query
        return $query;
    }

    public function getMemberRole() {
        $query = $this->_getRoleQuery(self::MEMBER_ROLE);

        // return result
        return $query->getSingleResult();
    }

    public function getVIPRole() {
        $query = $this->_getRoleQuery(self::VIP_ROLE);

        // return result
        return $query->getSingleResult();
    }

    public function getSuperVIPRole() {
        $query = $this->_getRoleQuery(self::SUPER_VIP_ROLE);

        // return result
        return $query->getSingleResult();
    }

    public function getAdministratorRole() {
        $query = $this->_getRoleQuery(self::ADMINISTRATOR_ROLE);

        // return result
        return $query->getSingleResult();
    }

}