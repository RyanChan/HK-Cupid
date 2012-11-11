<?php
namespace Champs\Entity\Repository;

use Champs\Entity\User;
use Champs\Entity\Role;
use Doctrine\ORM\EntityRepository;

/**
 * User repository
 * @author RyanChan
 */
class UserRepository extends EntityRepository{

    /**
     * Get a user object by email
     *
     * @param string $email
     * @return Champs\Entity\User
     */
    public function getUserByEmail($email){
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT u FROM Champs\Entity\User u, Champs\Entity\UserProfile up WHERE up.user = u and up.profile_key = 'email' and up.profile_value = ?1");

        $query->setParameter(1, $email);

        $result = $query->getSingleResult();

        return $result ? $result : null;
    }

    /**
     * Return true if the username doesn exist.
     *
     * @param string $username
     * @return boolean
     */
    public function hasSameUsername($username){
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT count(u.id) FROM Champs\Entity\User u WHERE u.username = ?1");

        $query->setParameter(1, $username);

        $count = $query->getSingleScalarResult();

        return $count > 0;
    }

    /**
     * Return true if the same email have found
     *
     * @param string $email
     * @return boolean
     */
    public function hasSameEmail($email){
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT count(u) FROM Champs\Entity\User u, Champs\Entity\UserProfile up WHERE up.user = u and up.profile_key = 'email' and up.profile_value = ?1");

        $query->setParameter(1, $email);

        $count = $query->getSingleScalarResult();

        return $count > 0;
    }

    /**
     * Return true if the same identity have found
     *
     * @param string $identity
     * @return boolean
     */
    public function hasSameIdentity($identity){
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT count(u) FROM Champs\Entity\User u, Champs\Entity\UserProfile up WHERE up.user = u and up.profile_key = 'identity' and up.profile_value = ?1");

        $query->setParameter(1, $identity);

        $count = $query->getSingleScalarResult();

        return $count > 0;
    }

    /**
     * Set role to user
     *
     * @param type $id
     * @param Role $role
     */
    public function setUserToRole($id, Role $role){
        $em = $this->getEntityManager();

        $user = $this->find($id);

        $user->role = $role;

        $em->flush();

        return $user;
    }
}