<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 26/9/20
 * Time: 19:56
 */

namespace Alsurmedia\Faq\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class Uninstall implements UninstallInterface
{

    public function uninstall(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        $connection = $setup->getConnection();
        $connection->dropTable($connection->getTableName('alsurmedia_faq'));
        $connection->dropTable($connection->getTableName('alsurmedia_faq_store'));
        $connection->dropTable($connection->getTableName('alsurmedia_faq_category'));
        $connection->dropTable($connection->getTableName('alsurmedia_faq_category_id'));
        $connection->dropTable($connection->getTableName('alsurmedia_faq_category_store'));
        $setup->endSetup();
    }
}