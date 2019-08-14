<?php
/**
 * User: ian.c
 * Date: 7/2/12 8:43 AM
 * File: Groupedproduct.php
 * To change this template use File | Settings | File Templates.
 */

/**
 * @method array getAttributeCodes()
 */
class Levementum_Groupedproduct_Model_Sets extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('groupedproduct/sets');
    }

    public function _afterLoad()
    {
        if ($this->getAttributeCodes()) {
            $this->setAttributeCodes(explode(',', $this->getAttributeCodes()));
        }
    }

    public function _beforeSave()
    {
        if ($this->getAttributeCodes()) {
            $this->setAttributeCodes(implode(',', $this->getAttributeCodes()));
        }
    }

    public function isActive()
    {
        return (bool) $this->getData('is_active');
    }

    /**
     * Reset all model data
     * @return Levementum_Groupedproduct_Model_Sets
     */
    public function reset()
    {
        $this->setData(array());

        return $this;
    }
}