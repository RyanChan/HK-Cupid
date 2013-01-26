<?php
namespace Champs\Entity\Repository;

use Champs\Entity\Category;
use Doctrine\ORM\EntityRepository;

/**
 * Category repository
 * @author RyanChan
 */
class CategoryRepository extends EntityRepository{
    /**
     *
     * @param Champs\Entity\Category $category
     * @return boolean
     */
    public function addChildCategory(Category $childCategory, $parentCategory_id){
        // get product entity 
        $parentCategory = $this->find($parentCategory_id);
        
        if (!$parentCategory)
            return false;

        // add category to category
        $parentCategory->categories->add($childCategory);

        try {
            // get the entity manager
            $em = $this->getEntityManager();
            // update the category entity
            $em->flush();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     *
     * @param Champs\Entity\Category $category_id
     * @return boolean
     */
    public function removeCategory($category_id){
        try {
            // current user id, for validate that is the owner
            $current_user_id = \Zend_Auth::getInstance()->getIdentity()->user_id;

            // get the entity manager
            $em = $this->getEntityManager();

            // create query
            $query = $em->createQuery("SELECT c
                                       FROM Champs\Entity\User u, Champs\Entity\Category c
                                       WHERE c.user = u and u.id = ?1 and c.id = ?2");

            $query->setParameter(1, $current_user_id)->setParameter(2, $category_id);

            // get result
            $category = $query->getSingleResult();

            if (!$category)
                return false;

            $em->remove($category);
            $em->flush();

            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}