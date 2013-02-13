<?php

/**
 * Description of Breadcrumb
 *
 * @author RyanChan
 */
class Champs_Breadcrumb {

    private $_trail = array();

    public function addStep($title, $link = '') {
        $this->_trail[] = array('title' => $title, 'link' => $link);
        
        return $this;
    }

    public function getTrail() {
        return $this->_trail;
    }

    public function getTitle() {
        if (count($this->_trail) == 0)
            return null;

        return $this->_trail[count($this->_trail) - 1]['title'];
    }

}