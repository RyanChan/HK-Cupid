<?php

namespace Champs\Entity\Repository;

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
     * Male
     */
    const MALE = 1;

    /**
     * Female
     */
    const FEMALE = 2;

    /**
     * Performs authentication of a user
     *
     * @param type $username
     * @param type $password
     * @return Champs\Entity\User
     */
    public function authenticate($username, $password) {
        $user = $this->getUserByUsername($username);

        if ($user) {
            $password = md5($password . $user->password_salt);
            if ($user->password === $password) {
                $user->doUpdateLastLogin();
                $this->getEntityManager()->flush();

                $identity = new \stdClass;
                $identity->user_id = $user->id;
                $identity->username = $user->username;
                $identity->rolename = $user->role->rolename;

                // assign all the profile key/value pairs to identity object
                foreach ($user->getProfile() as $profile) {
                    $profile_key = $profile->profile_key;
                    $identity->$profile_key = $profile->profile_value;
                }

                return $identity;
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

        try {
            $result = $query->getSingleResult();
        } catch (NonUniqueResultException $e) {
            throw new \Exception($e->getMessage());
        } catch (NoResultException $e) {
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $result;
    }

    public function getUserByNickname($nickname) {
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT u FROM Champs\Entity\User u, Champs\Entity\UserProfile up WHERE up.user = u and up.profile_key = 'nickname' and up.profile_value = ?1");
        $query->setParameter(1, $nickname);

        try {
            $result = $query->getSingleResult();
        } catch (NonUniqueResultException $e) {
            throw new \Exception($e->getMessage());
        } catch (NoResultException $e) {
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
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

        $query = $em->createQuery("SELECT u FROM Champs\Entity\User u, Champs\Entity\Role r WHERE r.user = u and r.rolename = 'administrator'");

        return $query->getResult();
    }

    /**
     * Gets all member group users
     *
     * @return array
     */
    public function getAllMemberUsers() {
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT u FROM Champs\Entity\User u, Champs\Entity\Role r WHERE r.user = u and r.rolename = 'member'");

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
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Activate user account
     *
     * @return boolean return true if activated
     */
    public function activateAccount($id, $key) {

        $user = $this->find($id);

        if (!$user->getProfile('activate_account_key') || !$user->getProfile('activate_account_ts') || $user->getProfile('activated') == 1)
            return false;


        if (time() - $user->getProfile('activate_account_ts') > 86400)
            return false;

        if ($user->getProfile('activate_account_key') != $key)
            return false;

        $user->unsetProfile('activate_account_key');
        $user->unsetProfile('activate_account_ts');
        $user->setProfileWithKeyAndValue('activated', 1);
//        $user->getProfileAlbum()->isProfileAlbum = 1;

        $this->getEntityManager()->flush();

        return true;
    }

    public function getHottestUsers($offset = 0, $limit = 30) {
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT u
                                   FROM Champs\Entity\User u, Champs\Entity\UserProfile up
                                   WHERE up.user = u and up.profile_key = 'vote' ORDER BY up.profile_value ASC");

        try {
            $query->setFirstResult($offset)->setMaxResults($limit);
            $result = $query->getResult();
        } catch (NonUniqueResultException $e) {
            throw new \Exception($e->getMessage());
        } catch (NoResultException $e) {
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $result;
    }

    public function getActiveUsers($offset = 0, $limit = 30) {
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT u FROM Champs\Entity\User u, Champs\Entity\UserProfile up WHERE up.user = u and up.profile_key = 'activated' and up.profile_value = '1' ORDER BY u.ts_last_login DESC");

        try {
            $query->setFirstResult($offset)->setMaxResults($limit);
            $result = $this->_filterActivateUsers($query->getResult());
        } catch (NonUniqueResultException $e) {
            throw new \Exception($e->getMessage());
        } catch (NoResultException $e) {
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $result;
    }

    /**
     *
     * @param integer $limit
     * @param integer $offset
     * @return array
     * @throws \Exception
     */
    public function getNewestUsers($offset = 0, $limit = 30) {
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT u
                                   FROM Champs\Entity\User u, Champs\Entity\UserProfile up, Champs\Entity\Album a
                                   WHERE up.user = u and up.profile_key = 'activated' and up.profile_value = '1' and a.user = u and SIZE(a.photos) > 0 and a.isProfileAlbum = true
                                   ORDER BY u.ts_created DESC");

        try {
            $query->setFirstResult($offset)
                    ->setMaxResults($limit);

//            $result = $this->_filterActivateUsers($query->getResult());
            $result = $query->getResult();
        } catch (NonUniqueResultException $e) {
            throw new \Exception($e->getMessage());
        } catch (NoResultException $e) {
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $result;
    }

    public function getFeaturedUsers($offset = 0, $limit = 40) {
        try {
            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery("SELECT u
                                       FROM Champs\Entity\User u, Champs\Entity\UserProfile up
                                       WHERE up.user = u and up.profile_key = 'activated' and up.profile_value = '1' and SIZE(u.followers) > 0
                                       ORDER BY u.id DESC");

            $query->setFirstResult($offset)->setMaxResults($limit);

            // get result
            $result = $query->getResult();

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Check whether the user is activated.
     *
     * @param type $id
     * @return boolean return true if the user is activated
     */
    public function isActivatedUser($id) {
        $id = (int) $id;
        $user = $this->find($id);

        $isActivated = $user->activated;

        return (int) $isActivated == 1;
    }

    public function updateUserEntity() {
        $em = $this->getEntityManager();
        $em->flush();
    }

    /**
     *
     * @param integer $male
     */
    public function getUsersByGender($male, $offset = 0, $limit = 30) {
        $em = $this->getEntityManager();

        $query = $em->createQuery("SELECT u
                                   FROM Champs\Entity\User u, Champs\Entity\UserProfile up
                                   WHERE up.user = u and up.profile_key = 'gender' and up.profile_value = ?1
                                   ORDER BY u.ts_last_updated DESC");

        try {
            $query->setParameter(1, $male)
                    ->setFirstResult($offset)
                    ->setMaxResults($limit);

            $result = $query->getResult();
        } catch (NonUniqueResultException $e) {
            throw new \Exception($e->getMessage());
        } catch (NoResultException $e) {
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $result;
    }

    /**
     *
     * @param Champs\Entity\User $follower
     * @return boolean
     */
    public function addFollower($follower) {
        // get current user id
        $user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;
        // get current user entity
        $user = $this->find($user_id);

        if (!$user)
            return false;

        // add follower to user
        $user->followers->add($follower);

        try {
            // get the entity manager
            $em = $this->getEntityManager();
            // update the user entity
            $em->flush();

            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *
     * @param Champs\Entity\User $follower
     * @return boolean
     */
    public function removeFollower(User $follower) {
        // get current user id
        $user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;
        // get current user entity
        $user = $this->find($user_id);

        if (!$user)
            return false;

        // remove follower from user
        $user->follower->remove($follower);

        try {
            // get the entity manager
            $em = $this->getEntityManager();
            // update the user entity
            $em->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *
     * @param Champs\Entity\User $role
     * @return boolean
     */
    public function addRole(User $role) {
        // get current user id
        $user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;
        // get current user entity
        $user = $this->find($user_id);

        if (!$user)
            return false;

        // add role to user
        $user->role->add($role);

        try {
            // get the entity manager
            $em = $this->getEntityManager();
            // update the user entity
            $em->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *
     * @param Champs\Entity\User $role
     * @return boolean
     */
    public function removeRole(User $role) {
        // get current user id
        $user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;
        // get current user entity
        $user = $this->find($user_id);

        if (!$user)
            return false;

        // remove role from user
        $user->role->remove($role);

        try {
            // get the entity manager
            $em = $this->getEntityManager();
            // update the user entity
            $em->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *
     * @param Champs\Entity\User $product
     * @return boolean
     */
    public function addProduct(User $product) {
        // get current user id
        $user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;
        // get current user entity
        $user = $this->find($user_id);

        if (!$user)
            return false;

        // add product to user
        $user->product->add($product);

        try {
            // get the entity manager
            $em = $this->getEntityManager();
            // update the user entity
            $em->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *
     * @param Champs\Entity\User $product_id
     * @return boolean
     */
    public function removeProduct($product_id) {
        try {
            // current user id, for validate that is the owner
            $current_user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;

            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery("SELECT p
                                       FROM Champs\Entity\User u, Champs\Entity\Product p
                                       WHERE p.user = u and u.id = ?1 and p.id = ?2");

            $query->setParameter(1, $current_user_id)->setParameter(2, $product_id);

            // get result
            $product = $query->getSingleResult();

            if (!$product)
                return false;

            $em->remove($product);
            $em->flush();

            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *
     * @param Champs\Entity\User $notification
     * @return boolean
     */
    public function addNotification(User $notification) {
        // get current user id
        $user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;
        // get current user entity
        $user = $this->find($user_id);

        if (!$user)
            return false;

        // add notification to user
        $user->notification->add($notification);

        try {
            // get the entity manager
            $em = $this->getEntityManager();
            // update the user entity
            $em->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *
     * @param Champs\Entity\User $notification_id
     * @return boolean
     */
    public function removeNotification($notification_id) {
        try {
            // current user id, for validate that is the owner
            $current_user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;

            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery("SELECT n
                                       FROM Champs\Entity\User u, Champs\Entity\Notification n
                                       WHERE n.user = u and u.id = ?1 and n.id = ?2");

            $query->setParameter(1, $current_user_id)->setParameter(2, $notification_id);

            // get result
            $notification = $query->getSingleResult();

            if (!$notification)
                return false;

            $em->remove($notification);
            $em->flush();

            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *
     * @param Champs\Entity\User $newsfeed
     * @return boolean
     */
    public function addNewsfeed(User $newsfeed) {
        // get current user id
        $user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;
        // get current user entity
        $user = $this->find($user_id);

        if (!$user)
            return false;

        // add newsfeed to user
        $user->newsfeed->add($newsfeed);

        try {
            // get the entity manager
            $em = $this->getEntityManager();
            // update the user entity
            $em->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *
     * @param Champs\Entity\User $newsfeed
     * @return boolean
     */
    public function removeNewsfeed($newsfeed_id) {
        try {
            // current user id, for validate that is the owner
            $current_user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;

            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery("SELECT n
                                       FROM Champs\Entity\User u, Champs\Entity\Newsfeed n
                                       WHERE n.user = u and u.id = ?1 and n.id = ?2");

            $query->setParameter(1, $current_user_id)->setParameter(2, $newsfeed_id);

            // get result
            $newsfeed = $query->getSingleResult();

            if (!$newsfeed)
                return false;

            $em->remove($newsfeed);
            $em->flush();

            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}