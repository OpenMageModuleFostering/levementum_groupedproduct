<?php
/**
 * User: ian.c
 * Date: 4/24/12 11:27 AM
 * File: mysql4-install-0.1.1.php
 */

/** @var $installer Levementum_Groupedproduct_Model_Entity_Setup_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();


$installer->addAttribute(
    Mage_Catalog_Model_Product::ENTITY,
    'lev_displayed_attributes',
    array(
         'group'                   => 'Grouped Product Display',
         'backend'                 => 'groupedproduct/backend_option',
         'type'                    => 'varchar',
         'input'                   => 'multiselect',
         'label'                   => 'Displayed Attributes on Grouped Product Table',
         'source'                  => 'groupedproduct/source_option',
         'required'                => false,
         'default'                 => null,
         'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
         'visible'                 => true,
         'apply_to'                => 'grouped',
         'frontend_input_renderer' => 'groupedproduct/catalog_form_renderer_fieldset_element',
    )
);

$installer->addAttribute(
    Mage_Catalog_Model_Product::ENTITY,
    'lev_primary_attribute',
    array(
         'group'                   => 'Grouped Product Display',
         'label'                   => 'Primary Attribute',
         'type'                    => 'varchar',
         'note'                    => 'The selected column will expand to fill the space, all others will be "minimized"',
         'input'                   => 'text',
         'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
         'required'                => false,
         'user_defined'            => false,
         'default'                 => null,
         'comparable'              => false,
         'used_in_product_listing' => true,
         'apply_to'                => 'grouped',
         'frontend_input_renderer' => 'groupedproduct/catalog_form_renderer_fieldset_primary',
    )
);

$installer->addAttribute(
    Mage_Catalog_Model_Product::ENTITY,
    'lev_display_availability',
    array(
         'group'                      => 'Grouped Product Display',
         'label'                      => 'Display Availability',
         'type'                       => 'int',
         'input'                      => 'select',
         'source'                     => 'eav/entity_attribute_source_boolean',
         'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
         'required'                   => false,
         'user_defined'               => false,
         'default'                    => 0,
         'comparable'                 => false,
         'used_in_product_listing'    => true,
         'apply_to'                   => 'grouped',
    )
);

$installer->addAttribute(
    Mage_Catalog_Model_Product::ENTITY,
    'lev_display_qty',
    array(
         'group'                      => 'Grouped Product Display',
         'label'                      => 'Display Quantity',
         'type'                       => 'int',
         'input'                      => 'select',
         'source'                     => 'eav/entity_attribute_source_boolean',
         'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
         'required'                   => false,
         'user_defined'               => false,
         'default'                    => 0,
         'used_in_product_listing'    => true,
         'unique'                     => false,
         'apply_to'                   => 'grouped',
    )
);

$table = $installer->getConnection()
    ->newTable($installer->getTable('groupedproduct/sets'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                                                                    'identity' => true,
                                                                    'unsigned' => true,
                                                                    'nullable' => false,
                                                                    'primary'  => true,
                                                               ), 'Id')
    ->addColumn('set_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                                                                        'unsigned' => true,
                                                                        'nullable' => false,
                                                                   ), 'Set Id')
    ->addColumn('attribute_codes', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                                                                              'nullable' => true
                                                                         ), 'Attribute Codes')
    ->addColumn('primary_attribute', Varien_Db_Ddl_Table::TYPE_TEXT, 200, array(
                                                                               'nullable' => true
                                                                          ), 'Primary Attribute')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_INTEGER, 1, array(
                                                                        'nullable' => false,
                                                                        'default'  => 0,
                                                                        'comment'  => 'Is Active'
                                                                   ))
    ->addIndex($installer->getIdxName('groupedproduct/sets', array('set_id')), array('set_id'))
    ->addForeignKey($installer->getFkName('groupedproduct/sets', 'set_id', 'eav/attribute_set', 'attribute_set_id'),
                    'set_id',
                    $installer->getTable('eav/attribute_set'),
                    'attribute_set_id',
                    Varien_Db_Ddl_Table::ACTION_CASCADE,
                    Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Levementum Groupedproduct Sets');

$installer->getConnection()->createTable($table);

$installer->endSetup();

