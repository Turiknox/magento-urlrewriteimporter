<?php
/*
 * Turiknox_Urlrewriteimporter

 * @category   Turiknox
 * @package    Turiknox_Urlrewriteimporter
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/Turiknox/magento-urlrewriteimporter/blob/master/LICENSE.md
 * @version    1.0.1
 */
class Turiknox_Urlrewriteimporter_Model_Observer
{
    /**
     * Inject Import URL Rewrites button
     *
     * @param $observer
     */
    public function injectImportUrlRewritesButton($observer)
    {
        $block = $observer->getBlock();

        if ($block instanceof Mage_Adminhtml_Block_Urlrewrite) {
            $block->addButton('import_rewrites', array(
                'label' => Mage::helper('core')->__('Import URL Rewrites'),
                'onclick' => "setLocation('{$block->getUrl('*/urlrewrite/import')}')",
                'class' => 'import'
            ), 0, 1);
        }
    }
}