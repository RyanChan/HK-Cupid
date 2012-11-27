<?php

namespace Champs\Entity\Repository;

use Champs\Entity\User;
use Champs\Entity\Role;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;

/**
 * User repository
 * @author RyanChan
 */
class UserRepository extends EntityRepository {
    /**
     * Not found
     */

    const NOT_FOUND = 1;

    /**
     * Wrong password
     */
    const WRONG_PW = 2;

    /**
     * Performs authentication of a user
     *
     * @param type $username
     * @param type $password
     */
    public function authenticate($username, $password) {
        $user = $this->getUserByUsername($username);

        if ($user) {
            $password = md5($password . $user->password_salt);
            if ($user->password === $password) {
                return $user;
            }

            throw new \Exception(self::WRONG_PW);
        }

        throw new \Exception(self::NOT_FOUND);
    }

    /**
     * Get a user object by email
     *
     * @param string $email
     * @return Champs\Entity\User
     */
    public function getUserByEmail($email) {
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT u FROM Champs\Entity\User u, Champs\Entity\UserProfile up WHERE up.user = u and up.profile_key = 'email' and up.profile_value = ?1");

        $query->setParameter(1, $email);

        $result = $query->getSingleResult();

        return $result ? $result : null;
    }

    public function getUserByUsername($username) {
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT u FROM Champs\Entity\User u WHERE u.username = ?1");

        $query->setParameter(1, $username);

        $result = null;

        try {
            $result = $query->getSingleResult();
        } catch (NonUniqueResultException $e) {

        } catch (NoResultException $e) {

        }

        return $result;
    }

    /**
     * Return true if the username doesn exist.
     *
     * @param string $username
     * @return boolean
     */
    public function hasSameUsername($username) {
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
    public function hasSameEmail($email) {
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
    public function hasSameIdentity($identity) {
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT count(u) FROM Champs\Entity\User u, Champs\Entity\UserProfile up WHERE up.user = u and up.profile_key = 'identity' and up.profile_value = ?1");

        $query->setParameter(1, $identity);

        $count = $query->getSingleScalarResult();

        return $count > 0;
    }

    /**
     * Assign role to user
     *
     * @param type $id
     * @param Role $role
     */
    public function setUserToRole($id, Role $role) {
        $em = $this->getEntityManager();

        $user = $this->find($id);

        $user->role = $role;

        $em->flush();
    }

    /**
     * Gets all administrator group users
     *
     * @return array
     */
    public function getAllAdminUsers() {
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT u FROM Champs\Entity\User u, Champs\Entity\Role r WHERE r.rolename = 'administrator' and u.role = r");

        return $query->getResult();
    }

    /**
     * Gets all member group users
     *
     * @return array
     */
    public function getAllMemberUsers() {
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT u FROM Champs\Entity\User u, Champs\Entity\Role r WHERE r.rolename = 'member' and u.role = r");

        return $query->getResult();
    }

    /**
     * Store the user entity
     *
     * @param Champs\Entity\User $user
     * @return Champs\Entity\User
     * @throws \Exception
     */
    public function storeUserEntity(\Champs\Entity\User $user) {
        try {
            $em = $this->getEntityManager();

            $em->persist($user);
            $em->flush();

            return $user;

        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}