<?php
/**
 * User: ian.c
 * Date: 8/30/12 3:17 PM
 */

class Levementum_Groupedproduct_Block_Adminhtml_Sets_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('groupedproduct_grid');
        $this->setDefaultSort('set');
        $this->setDefaultDir('asc');
        $this->setDefaultLimit(30);
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        //Sync any new attribute sets into the grouped table.
        Mage::helper('groupedproduct/sets')->syncAttributeSets();

        /** @var $groupedproductCollection Levementum_Groupedproduct_Model_Resource_Sets_Collection */
        $groupedproductCollection = Mage::getModel('groupedproduct/sets')->getCollection();
        $groupedproductCollection->join(array('set' => 'eav/attribute_set'),'main_table.set_id = set.attribute_set_id');

        $this->setCollection($groupedproductCollection);
        return parent::_prepareCollection();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('set_id_selection');
        $this->getMassactionBlock()->setFormFieldName('id');
        $this->getMassactionBlock()->addItem('status', array(
                                                            'label'=> Mage::helper('catalog')->__('Change status'),
                                                            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                                                            'additional' => array(
                                                                'visibility' => array(
                                                                    'name' => 'status',
                                                                    'type' => 'select',
                                                                    'class' => 'required-entry',
                                                                    'label' => Mage::helper('catalog')->__('Status'),
                                                                    'values' => array(
                                                                        0 => '',
                                                                        1 => 'Enabled',
                                                                        2 => 'Disabled'
                                                                    )
                                                                )
                                                            )
                                                       ));

        Mage::dispatchEvent('adminhtml_levementum_groupedproduct_grid_prepare_massaction', array('block' => $this));
    }

    protected function _prepareColumns()
    {
        $this->addColumn('attribute_set_name', array(
                                      'header'    => Mage::helper('groupedproduct')->__('Attribute Set'),
                                      'align'     => 'left',
                                      'index'     => 'attribute_set_name',
                                 ));

        $this->addColumn('is_active', array(
                                           'header'  => Mage::helper('groupedproduct')->__('Is Active'),
                                           'align'   => 'left',
                                           'index'   => 'is_active',
                                           'type'    => 'options',
                                           'width'     => '50px',
                                           'options' => array(
                                               1 => 'Yes',
                                               0 => 'No'
                                           )
                                      ));

        $this->addColumn('action',
                         array(
                              'header'     => Mage::helper('catalog')->__('Action'),
                              'width'      => '50px',
                              'type'       => 'action',
                              'getter'     => 'getId',
                              'actions'    => array(
                                  array(
                                      'caption' => Mage::helper('groupedproduct')->__('Edit'),
                                      'url'     => array(
                                          'base'=> '*/*/edit'
                                      ),
                                      'field'   => 'id'
                                  )
                              ),
                              'filter'     => false,
                              'sortable'   => false,
                         ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getData('id')));
    }
}