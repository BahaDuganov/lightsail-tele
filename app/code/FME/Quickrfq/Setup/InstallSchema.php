<?php

namespace FME\Quickrfq\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
        
        
        
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
                
                
        $installer = $setup;
        $installer->startSetup();
                
                
        /**
                        * Create table 'quickrfq'
                */
                
        $table = $installer->getConnection()->newTable($installer->getTable('fme_quickrfq'))
                                ->addColumn(
                                    'quickrfq_id',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                                    null,
                                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                                    'Quickrfq ID'
                                )
                                ->addColumn(
                                    'first_name',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    ['nullable' => true, 'default' => null],
                                    'First Name'
                                )
                                ->addColumn(
                                    'last_name',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'Last Name'
                                )
                                ->addColumn(
                                    'email',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'Email'
                                )
                                ->addColumn(
                                    'what_model',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'What Model'
                                )
                                ->addColumn(
                                    'like_dislike',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    64000,
                                    [],
                                    'What did you like or dislike about it?'
                                )
                                ->addColumn(
                                    'tall',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'How Tall Are You?'
                                )
                                ->addColumn(
                                    'weight',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'What is your weight?'
                                )
                                ->addColumn(
                                    'massage',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'What type of massage do you prefer?'
                                )
                                ->addColumn(
                                    'specific_features',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'Do you require any specific features?'
                                )
                                ->addColumn(
                                    'price_limitations',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'Do you have any price limitations?'
                                )
                                ->addColumn(
                                    'anything_know',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    64000,
                                    [],
                                    'Is there anything else we should know?'
                                )
                                ->addColumn(
                                    'status',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    ['nullable' => false, 'default' => 'New'],
                                    'Status'
                                )
                                ->addColumn(
                                    'create_date',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                                    null,
                                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                                    'Creation Date'
                                )
                                ->addColumn(
                                    'update_date',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                                    null,
                                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                                    'Update Date'
                                );
                
                
        $installer->getConnection()->createTable($table);
                
        $installer->endSetup();
    }
}
