<?php
class Turiknox_Urlrewriteimporter_Block_Adminhtml_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Initialise form
     *
     * @return $this
     */
    public function initForm()
    {
        $form = new Varien_Data_Form();
        $csvOptions = $form->addFieldset('csv_options', array(
            'legend' => Mage::helper('core')->__('CSV Parser Options'),
        ));

        $csvOptions->addField('skip_headers', 'checkbox', array(
            'name' => 'skip_headers',
            'label' => 'Skip Headers?',
            'value' => '1',
            'after_element_html' => '<small>Skip the first line of CSV file (headers)</small>',
        ));

        $csvOptions->addField('file', 'file', array(
            'name' => 'file',
            'label' => 'File',
            'class' => 'required-entry',
            'required' => true,
            'after_element_html' => '<small>*.csv</small>',
        ));

        $this->setForm($form);
        return $this;
    }
}