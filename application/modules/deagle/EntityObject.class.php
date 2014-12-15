<?php
/**
 * base entity
 * @author jiangchanghua<jiangchanghua@baidu.com>
 * @since 2011-03-21
 * @package holmes.web.module.base
 *
 */
abstract class EntityObject {

    /**
     * for lazy load, to mark the fields that already be loaded.
     * @var array
     */
    protected $_loadeds;
    /**
     * to mark the fields that have been modified.
     * @var array
     */
    protected $_modifieds;

    /**
     * __construct
     */
    public function __construct(){
        $this->_loadeds = array();
        $this->_modifieds = array();
    }

    /**
     * mark all as unmodified
     * @return EntityObject
     */
    public function markAllAsUnModified(){
        unset($this->_modifieds);
        $this->_modifieds = array();
        return $this;
    }

    /**
     * mark as modified
     * @param string $fieldName
     * @return EntityObject
     */
    public function markAsModified($fieldName){
        $this->_modifieds[$fieldName] = true;
        return $this;
    }

    /**
     * mark as unmodified
     * @param string $fieldName
     * @return EntityObject
     */
    public function markAsUnModified($fieldName){
        if (isset($this->_modifieds[$fieldName])){
            unset($this->_modifieds[$fieldName]);
        }
        return $this;
    }

}
