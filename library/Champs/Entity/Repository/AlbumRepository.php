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

    public function storeAlbumEntity(Album $album, $user_id) {
        try {
            // get the entity manager
            $em = $this->getEntityManager();

            // get the current user's entity
            $user = $em->find('Champs\Entity\User', $user_id);

            // assign user entity to album
            $album->user = $user;

            // persist & store album entity
            $em->persist($album);
            $em->flush();

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}