<?php

namespace Champs\Entity\Repository;

use Champs\Entity\Message;
use Doctrine\ORM\EntityRepository;

/**
 * Message repository
 * @author RyanChan
 */
class MessageRepository extends EntityRepository {

    public function storeMessageEntity($message) {
        try {
            $this->getEntityManager()->persist($message);
            $this->getEntityManager()->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAllMessagesForUser($offset = 0, $limit = 30) {
        try {
            $user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;
            $user = $this->getEntityManager()->find('Champs\Entity\User', $user_id);

            $query = $this->getEntityManager()->createQuery("SELECT m FROM Champs\Entity\Message m WHERE m.receiver = ?1 ORDER BY m.ts_created DESC");
            $query->setFirstResult($offset)->setMaxResults($limit)->setParameter(1, $user);

            return $query->getResult();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getUnreadMessagesForUser($offset = 0, $limit = 30) {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}