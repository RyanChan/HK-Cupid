<?php

namespace Champs\Entity\Repository;

use Champs\Entity\Product;
use Doctrine\ORM\EntityRepository;

/**
 * Product repository
 * @author RyanChan
 */
class ProductRepository extends EntityRepository {
    /**
     * On Sale
     */

    const ON_SALE = 0;

    /**
     * Out of stock
     */
    const OUT_OF_STOCK = 1;

    /**
     * Removed from sale
     */
    const REMOVED_FROM_SALE = 2;

    /**
     * Rejected by administrator
     */
    const REJECTED = 3;

    /**
     * get all the products
     *
     * @return array|null
     */
    public function getProducts() {
        try {
            // create query
            $query = $this->getEntityManager()->createQuery(
                    "SELECT p
                     FROM Champs\Entity\Product p, Champs\Entity\ProductProfile pp
                     WHERE pp.product = p and pp.profile_key = 'status' and pp.profile_value != ?1 and pp.profile_value != ?2"
            );

            $query->setParameter(1, self::REMOVED_FROM_SALE)
                    ->setParameter(2, self::REJECTED);

            // get the result set
            $result = $query->getResult();

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * get products by status code
     *
     * Status Code : ON_SALE, OUT_OF_STOCK, REMOVED_FROM_SALE, REJECTED
     *
     * @param integer $status
     * @return array|null
     */
    public function getProductsByStatus($status) {
        try {
            // create query
            $query = $this->getEntityManager()->createQuery(
                    "SELECT p
                     FROM Champs\Entity\Product p, Champs\Entity\ProductProfile pp
                     WHERE pp.product = p and pp.profile_key = 'status' and pp.profile_value != ?1"
            );

            $query->setParameter(1, $status);

            // get the result
            $result = $query->getResult();

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * get products by category
     *
     * @param Champs\Entity\Category $category
     * @return array|null
     */
    public function getProductsByCategory($category) {
        try {
            // create query
            $query = $this->getEntityManager()->createQuery(
                    "SELECT p
                     FROM Champs\Entity\Product p, Champs\Entity\ProductProfile pp, Champs\Entity\Category c
                     WHERE p.categories in (?1) and pp.product = p and pp.profile_key = 'status' and pp.profile_value != ?2 and pp.profile_value != ?3"
            );

            $query->setParameter(1, $category)
                    ->setParameter(2, self::REMOVED_FROM_SALE)
                    ->setParameter(3, self::REJECTED);

            // get result
            $result = $query->getResult();

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * get products by user id
     *
     * query an user entity that specified.
     * call @see Champs\Entity\Repository\ProductRepository::getProductsByUser()
     * to get products
     *
     * @param integer $user_id
     * @return array|null
     */
    public function getProductsByUserID($user_id) {
        try {
            // find user
            $user = $this->getEntityManager()->find('Champs\Entity\User', $user_id);

            // get result
            $result = $this->getProductsByUser($user);

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * get products by user entity
     *
     * @param Champs\Entity\User $user
     * @return array|null
     */
    public function getProductsByUser($user) {
        try {
            // create query
            $query = $this->getEntityManager()->createQuery(
                    "SELECT p FROM Champs\Entity\Product p, Champs\Entity\User u WHERE p.user = u and u = ?1"
            );

            $query->setParameter(1, $user);

            // get result
            $result = $query->getResult();

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * get products by user with status code
     *
     * @param integer $user_id
     * @param integer $status
     * @return array|null
     * @throws \Exception
     */
    public function getProductsByUserWithStatus($user_id, $status) {
        try {
            // get the user entity
            $user = $this->getEntityManager()->find('Champs\Entity\User', $user_id);

            // return null if user entity is null
            if (null === $user)
                return null;

            // create query
            $query = $this->getEntityManager()->createQuery(
                    "SELECT p
                     FROM Champs\Entity\Product p, Champs\Entity\ProductProfile pp, Champs\Entity\User u
                     WHERE pp.product = p and p.user = u and u = ?1 and pp.profile_key = 'status' and pp.profile_value = ?2"
            );

            $query->setParameter(1, $user)->setParameter(2, $status);

            // get result
            $result = $query->getResult();

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * get newest products
     *
     * @return array|null
     */
    public function getNewestProduct($offset = 0, $limit = 30) {
        try {
            // create query
            $query = $this->getEntityManager()->createQuery(
                    "SELECT p
                     FROM Champs\Entity\Product p, Champs\Entity\ProductProfile pp
                     WHERE pp.product = p and pp.profile_key = 'status' and pp.profile_value = ?1
                     ORDER BY p.ts_created DESC"
            );

            $query->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->setParameter(1, self::ON_SALE);

            // get result
            $result = $query->getResult();

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * get hottest products
     *
     * @return array|null
     */
    public function getHottestProduct($offset = 0, $limit = 30) {
        try {
            // create query
            $query = $this->getEntityManager()->createQuery(
                    "SELECT p
                     FROM Champs\Entity\Product p, Champs\Entity\ProductProfile pp
                     WHERE pp.product = p and pp.profile_key = 'status' and pp.profile_value = ?1
                     ORDER BY p.ts_last_updated DESC"
            );

            $query->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->setParameter(1, self::ON_SALE);

            // get result
            $result = $query->getResult();

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getProductsForCurrentUser() {
        try {
            // get user id
            $user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;

            // get user entity
            $user = $this->getEntityManager()->find('Champs\Entity\User', $user_id);

            // create query
            $query = $this->getEntityManager()->createQuery(
                    "SELECT p
                     FROM Champs\Entity\Product p
                     WHERE p.user = ?1"
            );

            $query->setParameter(1, $user);

            // get result
            $result = $query->getResult();

            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * store a product entity
     *
     * @param Champs\Entity\Product $product
     */
    public function storeProductEntity(Product $product) {
        try {
            // get user id
            $user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;
            // get user entity
            $user = $this->getEntityManager()->find('Champs\Entity\User', $user_id);
            // assign user to product
            $product->user = $user;
            // persist
            $this->getEntityManager()->persist($product);
            $this->getEntityManager()->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * add product to user's favorite collection
     *
     * @param integer $product_id
     * @param integer $user_id
     *
     * @return boolean
     */
    public function addProductToUserFavorite($product_id, $user_id) {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * remove product from user's favorite collection
     *
     * @param integer $product_id
     * @param integer $user_id
     *
     * @return boolean
     */
    public function removeProductFromUserFavorite($product_id, $user_id) {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * remove a product
     *
     * @param integer $product_id
     *
     * @return boolean
     */
    public function removeProduct($product_id) {
        try {
            // get product entity
            $product = $this->find($product_id);
            // delete entity
            $this->getEntityManager()->remove($product);
            $this->getEntityManager()->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     *
     * @param Champs\Entity\Product $photo
     * @return boolean
     */
    public function addPhoto(Product $photo, $product_id){
        // get product entity 
        $product = $this->find($product_id);
        
        if (!$product)
            return false;

        // add photo to product
        $product->photo->add($photo);

        try {
            // get the entity manager
            $em = $this->getEntityManager();
            // update the product entity
            $em->flush();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     *
     * @param Champs\Entity\Product $photo
     * @return boolean
     */
    public function removePhoto($product_id, $photo_id){
        try {
            // current user id, for validate that is the owner
            $current_user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;

            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery("SELECT p
                                       FROM Champs\Entity\User u, Champs\Entity\Product pp, Champs\Entity\ProductPhoto p
                                       WHERE pp.user = u and p.product = pp and u.id = ?1 and pp.id = ?2 and p.id = ?3");

            $query->setParameter(1, $current_user_id)->setParameter(2, $product_id)->setParameter(3, $photo_id);

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
    
    /**
     *
     * @param Champs\Entity\Product $comment
     * @return boolean
     */
    public function addComment(Product $comment, $product_id){
        // get product entity 
        $product = $this->find($product_id);
        
        if (!$product)
            return false;

        // add photo to product
        $product->comment->add($comment);

        try {
            // get the entity manager
            $em = $this->getEntityManager();
            // update the product entity
            $em->flush();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     *
     * @param Champs\Entity\Product $comment
     * @return boolean
     */
    public function removeComment($comment_id, $product_id){
        try {
            // current user id, for validate that is the owner
            $current_user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;

            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery("SELECT p
                                       FROM Champs\Entity\User u, Champs\Entity\Product p, Champs\Entity\ProductComment c
                                       WHERE p.user = u and c.product = p and u.id = ?1 and p.id = ?2 and c.id = ?3");

            $query->setParameter(1, $current_user_id)->setParameter(2, $product_id)->setParameter(3, $comment_id);

            // get result
            $comment = $query->getSingleResult();

            if (!$comment)
                return false;

            $em->remove($comment);
            $em->flush();

            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}