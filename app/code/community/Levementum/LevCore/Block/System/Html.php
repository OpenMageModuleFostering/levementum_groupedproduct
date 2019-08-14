<?php
/**
 * WDCA
 * NOTICE OF LICENSE
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 * @category   WDCA
 * @package    TBT_Enhancedgrid
 * @copyright  Copyright (c) 2008-2010 WDCA (http://www.wdca.ca)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Levementum_LevCore_Block_System_Html extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html           = '';
        $levCoreVersion = Mage::getConfig()->getNode('modules/Levementum_LevCore/version');

        $modules = Mage::getConfig()->getNode('modules');

        $levModules = array();
        foreach ($modules->asArray() as $key => $valueArray) {
            if (strpos($key, 'Levementum') !== false && $key != 'Levementum_LevCore') {
                if (isset($valueArray['version'])) {
                    $levModules[] = array(
                        'name'   => $key,
                        'version'=> $valueArray['version']
                    );
                }
            }
        }

        $html .= "
            <div style=\" margin-bottom: 12px; width: 100%;\">
            <p>You are currently using the following Levementum Modules:</p>
            <ul>
                <li>Core - v{$levCoreVersion}</li>";
        foreach ($levModules as $module) {
            $html .= "<li>{$module['name']} - v{$module['version']}</li>";
        }

        $html .= "
            </ul>
            <br/>
            <p>Check out  <a href='http://www.levementum.com/' target='_blank'>Levementum, LLC</a>
            
            <p>Also take a look at <a href='http://blog.levementum.com/' target='_blank'>Levementum Blog</a>.</p>";

        $html .= "
            </div>
		";

        return $html;
    }
}
