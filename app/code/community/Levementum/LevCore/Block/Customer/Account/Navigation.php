<?php
/**
 * User: icoast@levementum.com
 * Date: 1/31/13 1:48 PM
 * File: ${FILE_NAME}
 */ 
class Levementum_LevCore_Block_Customer_Account_Navigation extends Mage_Customer_Block_Account_Navigation {

    public function removeLink($name, $path)
    {
        if (isset($this->_links[$name])) {
            unset($this->_links[$name]);
        }
        
        return $this;
    }
}