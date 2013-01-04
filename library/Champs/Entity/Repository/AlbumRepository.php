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

    public function getNewestAlbums() {
        try {
            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery('SELECT a FROM Champs\Entity\Album a ORDER BY a.ts_created DESC');

            // return result
            return $query->getResult();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getHottestAlbums() {
        try {
            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery('SELECT a FROM Champs\Entity\Album a ORDER BY a.ts_last_updated DESC');

            // return result
            return $query->getResult();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAlbumsByGender($gender) {
        try {
            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery("SELECT a FROM Champs\Entity\Album a, Champs\Entity\User u, Champs\Entity\UserProfile up WHERE up.user = u and a.user = u and up.profile_key = 'gender' and up.profile_value = ?1 ORDER BY a.ts_created DESC");
            $query->setParameter(1, $gender);
            
            // return result
            return $query->getResult();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}