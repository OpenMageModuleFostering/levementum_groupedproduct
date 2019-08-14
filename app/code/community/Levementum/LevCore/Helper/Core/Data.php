<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Core
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Core data helper
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Levementum_LevCore_Helper_Core_Data extends Mage_Core_Helper_Data
{
    /**
     * Format date using current locale options and time zone.
     *
     * @param   date|Zend_Date|null $date
     * @param   string              $format   See Mage_Core_Model_Locale::FORMAT_TYPE_* constants
     * @param   bool                $showTime Whether to include time
     * @return  string
     */
    public function formatDate($date = null, $format = Mage_Core_Model_Locale::FORMAT_TYPE_SHORT, $showTime = false)
    {
        if (!in_array($format, $this->_allowedFormats, true)) {
            return $date;
        }
        if (!($date instanceof Zend_Date) && $date && !strtotime($date)) {
            return '';
        }
        if (is_null($date)) {
            $date = Mage::app()->getLocale()->date(Mage::getSingleton('core/date')->gmtTimestamp(), null, null);
        } else if (!$date instanceof Zend_Date) {
            if (is_numeric($date)) {
                /* Change icoast@levementum.com on 10/26/12 at 1:56 PM - Description: If it is already a timestamp don't do it. */
                $date = Mage::app()->getLocale()->date($date, null, null);
            } else {
                $date = Mage::app()->getLocale()->date(strtotime($date), null, null);
            }
        }

        if ($showTime) {
            $format = Mage::app()->getLocale()->getDateTimeFormat($format);
        } else {
            $format = Mage::app()->getLocale()->getDateFormat($format);
        }

        return $date->toString($format);
    }
}
