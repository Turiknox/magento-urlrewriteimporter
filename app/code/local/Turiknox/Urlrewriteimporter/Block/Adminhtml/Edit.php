<?php
class Turiknox_Urlrewriteimporter_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Turiknox_Urlrewriteimporter_Block_Adminhtml_Edit constructor.
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml';
        $this->_blockGroup = 'turiknox_urlrewriteimporter';

        parent::__construct();

        $this->_updateButton('back', 'onclick', "setLocation('{$this->getUrl('*/urlrewrite/index')}')");
        $this->_updateButton('save', 'label', 'Import');
        $this->_removeButton('reset');
    }

    /**
     * @return string
     */
    public function getHeaderText()
    {
        return $this->__('Import URL Rewrites');
    }
}