<?php
class Turiknox_Urlrewriteimporter_Block_Adminhtml_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Turiknox_Urlrewriteimporter_Block_Edit_Tabs constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('urlrewrite_import_general');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('core')->__('Url Rewrite Importer'));
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml() {
        $this->addTab('account', array(
            'label' => Mage::helper('core')->__('General'),
            'content' => $this->getLayout()->createBlock('turiknox_urlrewriteimporter/adminhtml_edit_tab_general')
                ->initForm()
                ->toHtml(),
            'active' => true
        ));
        return parent::_beforeToHtml();
    }
}