<?php

class Womza_ApplicationRegistration_Block_Adminhtml_ApplicationRegistration_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('applicationregistration_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('applicationregistration')->__('Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('applicationregistration')->__('User Information'),
            'title'     => Mage::helper('applicationregistration')->__('User Information'),
            'content'   => $this->getLayout()->createBlock('applicationregistration/adminhtml_applicationregistration_edit_tab_form')->toHtml(),
        ));
        return parent::_beforeToHtml();
    }
}