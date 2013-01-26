<?php

namespace Champs\Entity\Repository;

use Champs\Entity\Album;
//use Champs\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * Album repository
 * @author RyanChan
 */
class AlbumRepository extends EntityRepository {
    /**
     * Public album
     */

    const PRIVACY_PUBLIC = 0;

    /**
     * Private album
     */
    const PRIVACY_PRIVATE = 1;

    /**
     * store the album entity
     *
     * @param \Champs\Entity\Album $album
     * @param integer $user_id
     * @throws \Exception
     */
    public function storeAlbumEntity(Album $album, $user_id) {
        try {
            // get the entity manager
            $em = $this->getEntityManager();

            // get the current user's entity
            $user = $em->find('Champs\Entity\User', $user_id);

            if (!$user)
                throw new \Exception('Can\'t find user by user id ' . $user_id);

            // assign user entity to album
            $album->user = $user;

            // persist & store album entity
            $em->persist($album);
            $em->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Get all albbums for current user
     *
     * @return array
     * @throws \Exception
     */
    public function getAlbumsForCurrentUser() {
        try {
            // get the entity manager
            $em = $this->getEntityManager();

            // get the user id
            $user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;

            // create query & set params
            $query = $em->createQuery('SELECT a FROM Champs\Entity\Album a, Champs\Entity\User u WHERE a.user = u and u.id = ?1');
            $query->setParameter(1, $user_id);

            // get the result set
            $albums = $query->getResult();

            // return albums
            return $albums;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Get newest albums
     *
     * @return array
     * @throws \Exception
     */
    public function getNewestAlbums($offset = 0, $limit = 30) {
        try {
            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery("SELECT a
                                       FROM Champs\Entity\Album a, Champs\Entity\AlbumProfile ap
                                       WHERE ap.album = a and ap.profile_key = 'privacy' and ap.profile_value = ?1 and a.isProfileAlbum = ?2
                                       ORDER BY a.ts_created DESC");

            $query->setFirstResult($offset)->setMaxResults($limit)->setParameter(1, self::PRIVACY_PUBLIC)->setParameter(2, false);

            // return result
            return $query->getResult();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Get hottest albums
     *
     * @return array
     * @throws \Exception
     */
    public function getHottestAlbums() {
        try {
            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery("SELECT a
                                       FROM Champs\Entity\Album a, Champs\Entity\AlbumProfile ap
                                       WHERE ap.album = a and ap.profile_key = 'privacy' and ap.profile_value = ?1 and a.isProfileAlbum = ?2
                                       ORDER BY a.ts_last_updated DESC");
            $query->setParameter(1, self::PRIVACY_PUBLIC)->setParameter(2, false);

            // return result
            return $query->getResult();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Get albums by gender
     *
     * @param integer $gender
     * @return array
     * @throws \Exception
     */
    public function getAlbumsByGender($gender) {
        try {
            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery("SELECT a
                                       FROM Champs\Entity\Album a, Champs\Entity\AlbumProfile ap, Champs\Entity\User u, Champs\Entity\UserProfile up
                                       WHERE up.user = u and a.user = u and ap.album = a and ap.profile_key = 'privacy' and ap.profile_value = ?1 and up.profile_key = 'gender' and up.profile_value = ?2 and a.isProfileAlbum = ?3
                                       ORDER BY a.ts_created DESC");
            $query->setParameter(1, self::PRIVACY_PUBLIC)
                    ->setParameter(2, $gender)
                    ->setParameter(3, false);

            // return result
            return $query->getResult();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAlbums() {
        try {
            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery("SELECT a
                                       FROM Champs\Entity\Album a, Champs\Entity\AlbumProfile ap
                                       WHERE ap.album = a and ap.profile_key = 'privacy' and ap.profile_value = ?1 and a.isProfileAlbum = ?2
                                       ORDER BY a.ts_created DESC");
            $query->setParameter(1, self::PRIVACY_PUBLIC)->setParameter(2, false);

            // return result
            return $query->getResult();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     *
     * @param Champs\Entity\Album $album
     * @param integer $photo_id
     * @throws \Exception
     * @return boolean
     */
    public function removePhoto($album_id, $photo_id) {
        try {
            // current user id, for validate that is the owner
            $current_user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;

            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery("SELECT p
                                       FROM Champs\Entity\User u, Champs\Entity\Album a, Champs\Entity\Photo p
                                       WHERE a.user = u and u.id = ?1 and a.id = ?2 and p.album = a and p.user = u and p.id = ?3");

            $query->setParameter(1, $current_user_id)->setParameter(2, $album_id)->setParameter(3, $photo_id);

            // get result
            $photo = $query->getSingleResult();

            if (!$photo)
                return false;

            $em->remove($photo);
            $em->flush();

            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}