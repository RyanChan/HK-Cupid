<?php
namespace Champs\Entity\Repository;

use Champs\Entity\Payment;
use Doctrine\ORM\EntityRepository;

/**
 * Payment repository
 * @author RyanChan
 */
class PaymentRepository extends EntityRepository{
    
    /**
     * in progress
     */
    const IN_PROGRESS = 1;
    /**
     * processing
     */
    const PROCESSING = 2;
    /**
     * ready
     */
    const READY = 3;
    /**
     * completed
     */
    const COMPLETED = 4;
    /**
     * ended
     */
    const ENDED = 5;
    /**
     * cancel
     */
    const CANCEL = 6;
    /**
     * on held
     */
    const ON_HELD = 7;
    
    /**
     * Store payment entity
     */
    public function storePaymentEntity(Payment $payment) {
        try {
            // get user id
            $user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
            // get user entity
            $user = $this->getEntityManager()->find('Champs\Entity\User', $user_id);
            // assign user to product
            $payment->user = $user;
            // persist
            $this->getEntityManager()->persist($payment);
            $this->getEntityManager()->flush();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     * Get all payments for current user
     */
    public function getPayments($offset = 0, $liiit = 30) {
        try {
            // get user id
            $user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
            // get user entity
            $user = $this->getEntityManager()->find('Champs\Entity\User', $user_id);
            // create query
            $query = $this->getEntityManager()->createQuery(
                    "SELECT p
                     FROM Champs\Entity\Payment p
                     WHERE p.user = ?1"
            );

            $query->setFirstResult($offset)->setMaxResults($limit)->setParameter(1, $user);

            // get the result set
            $result = $query->getResult();

            return $result;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    public function getPaymentsByStatus($status, $offset = 0, $limit = 30) {
        try {
            // create query
            $query = $this->getEntityManager()->createQuery(
                    "SELECT p
                     FROM Champs\Entity\Payment p
                     WHERE p.progress = ?1"
            );

            $query->setParameter(1, $status);

            // get the result
            $result = $query->getResult();

            return $result;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    public function getRecentPayments($offset = 0, $limit = 30) {
        try {
            // create query
            $query = $this->getEntityManager()->createQuery(
                    "SELECT p
                     FROM Champs\Entity\Payment p
                     ORDER BY p.ts_created DESC"
            );

            $query->setFirstResult($offset)
                    ->setMaxResults($limit);

            // get result
            $result = $query->getResult();

            return $result;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
}