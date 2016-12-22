<?php
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