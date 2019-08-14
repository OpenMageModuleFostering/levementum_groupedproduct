<?php

/**
 * Levementum, LLC

 */

class Levementum_LevCore_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_tables = array();

    public function getAttributeOptions($code, $asDropdown = true)
    {
        $_options = array();

        /** @var $attribute Mage_Catalog_Model_Resource_Eav_Attribute */
        $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $code);

        if ($attribute->usesSource()) {
            if ($asDropdown) {
                foreach ($attribute->getSource()->getAllOptions(false) as $option) {
                    $_options[$option['value']] = $option['label'];
                }
            } else {
                $_options = $attribute->getSource()->getAllOptions(false);
            }
        }

        return $_options;
    }

    public function inCurrentHandles($needle)
    {
        $currentHandles = Mage::app()->getLayout()->getUpdate()->getHandles();

        return in_array($needle, $currentHandles);
    }

    public function getTable($tableName)
    {
        if (!isset($this->_tables[$tableName])) {
            $this->_tables[$tableName] = Mage::getSingleton('core/resource')->getTableName($tableName);
        }

        return $this->_tables[$tableName];
    }

    /**
     * Checks to see if the current user is a developer.
     * Developer is assigned by IP listed in dev/restrict/allow_ips
     * @return bool
     */
    public function isDeveloper()
    {
        return (strstr(Mage::getStoreConfig('dev/restrict/allow_ips'), Mage::helper('core/http')->getRemoteAddr())) ? true : false;
    }

    public function isCategoryPage()
    {
        return (bool) Mage::registry('current_category');
    }

    public function isProductPage()
    {
        return (Mage::registry('current_product') || Mage::registry('product'));
    }

    public function isAdmin()
    {
        if (Mage::app()->getStore()->isAdmin()) {
            return true;
        }

        if (Mage::getDesign()->getArea() == 'adminhtml') {
            return true;
        }

        return false;
    }

    /**
     * @param $collection Mage_Core_Model_Resource_Db_Collection_Abstract
     *
     * @return array
     */
    public function outputCsvFromCollection($collection)
    {

        $io = new Varien_Io_File();

        $path = Mage::getBaseDir('var') . DS . 'export' . DS;
        $name = md5(microtime());
        $file = $path . DS . $name . '.csv';

        $io->setAllowCreateFolders(true);
        $io->open(array('path' => $path));
        $io->streamOpen($file, 'w+');
        $io->streamLock(true);

        //Capture headers
        $_headers = array_keys($collection->getFirstItem()->getData());
        $io->streamWriteCsv($_headers);

        //write all items
        foreach ($collection->getItems() as $item) {
            $io->streamWriteCsv($item->getData());
        }

        $io->streamUnlock();
        $io->streamClose();

        return array(
            'type'  => 'filename',
            'value' => $file,
            'rm'    => true // can delete file after use
        );
    }
}