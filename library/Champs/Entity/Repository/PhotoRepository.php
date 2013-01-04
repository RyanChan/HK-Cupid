<?php

namespace Champs\Entity\Repository;

use Champs\Entity\Photo;
use Champs\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * Photo repository
 * @author RyanChan
 */
class PhotoRepository extends EntityRepository {

    /**
     * Store photo entity to database
     *
     * @param \Champs\Entity\Photo $photo
     */
    public function storePhotoEntity(Photo $photo) {
        try {
            // get the entity manager
            $em = $this->getEntityManager();
            // persist the entity
            $em->persist($photo);
            // flush it
            $em->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Find all photos by album id
     *
     * @param type $album_id
     */
    public function findAllByAlbumEntity($album) {
        try {
            // get the entity manager
            $em = $this->getEntityManager();
            // create query
            $query = $em->createQuery('SELECT p FROM Champs\Entity\Photo p, Champs\Entity\Album a WHERE p.album = ?1');
            $query->setParameter(1, $album);
            // return result
            return $query->getResult();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}