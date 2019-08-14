<?php

/**
 * Cms manage blocks controller
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Levementum_Groupedproduct_Adminhtml_SetsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return Mage_Adminhtml_Cms_BlockController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()->_setActiveMenu('groupedproduct/sets');
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('groupedproduct'))->_title($this->__('Sets'));
        $this->_initAction();
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->_title($this->__('groupedproduct'))->_title($this->__('Sets'));
        $this->_initAction();
        $this->renderLayout();
    }

    public function editAction()
    {
        $id    = $this->getRequest()->getParam('id');
        $model = Mage::getModel('groupedproduct/sets')->load($id);

        if ($model->getId() || $id == 0) {

            $set = Mage::getModel('eav/entity_attribute_set')->load($model->getSetId());
            $model->setData('attribute_set_name',$set->getAttributeSetName());

            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('sets_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('groupedproduct/sets');

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('groupedproduct/adminhtml_sets_edit'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('groupedproduct')->__('Set does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $setsModel = Mage::getModel('groupedproduct/sets');  /** @var $setsModel Levementum_Groupedproduct_Model_Groupedproduct */
            $setId     = $this->getRequest()->getParam('id');

            $setsModel->setData($data);
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            try {
                if ($setId) {
                    $setsModel->setId($setId);
                }
                $setsModel->save();

                if (!$setsModel->getId()) {
                    Mage::throwException(Mage::helper('groupedproduct')->__('Error saving set'));
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('groupedproduct')->__('Set was successfully saved.'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // The following line decides if it is a "save" or "save and continue"
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $setId));
                } else {
                    $this->_redirect('*/*/');
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                if ($setsModel && $setsModel->getId()) {
                    $this->_redirect('*/*/edit', array('id' => $setId));
                } else {
                    $this->_redirect('*/*/');
                }
            }

            return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('awesome')->__('No data found to save'));
        $this->_redirect('*/*/');
    }

    /**
     * Update product(s) status action
     *
     */
    public function massStatusAction()
    {
        $setIds = (array)$this->getRequest()->getParam('id');
        $status     = (int)$this->getRequest()->getParam('status'); //1 = enabled, 2 = disabled

        if ($status == 0) {
            $this->_getSession()->addError($this->__('Please select status.'));
        } elseif (!is_array($setIds)) {
            $this->_getSession()->addError($this->__('Please select attribute set(s).'));
        } else {
            if (!empty($setIds)) {
                //convert from 1 to 2 to 1 and 0 respectively.
                $status = $status % 2;
                try {
                    foreach ($setIds as $setId) {
                        $set = Mage::getSingleton('groupedproduct/sets')
                            ->reset()
                            ->load($setId)
                            ->setIsActive($status)
                            ->save();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d sets(s) have been updated.', count($setIds))
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }

        $this->_redirect('*/*/index');
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('levementum/levementum_grouped_sets');
    }
}
