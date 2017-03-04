<?php
/*
 * Turiknox_Urlrewriteimporter

 * @category   Turiknox
 * @package    Turiknox_Urlrewriteimporter
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/Turiknox/magento-urlrewriteimporter/blob/master/LICENSE.md
 * @version    1.0.1
 */
class Turiknox_Urlrewriteimporter_Block_Adminhtml_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare form
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
     {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => Mage::helper("adminhtml")->getUrl('*/urlrewrite/processImport'),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}