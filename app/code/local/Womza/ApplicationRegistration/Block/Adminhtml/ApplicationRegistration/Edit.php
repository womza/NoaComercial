<?php
class Womza_ApplicationRegistration_Block_Adminhtml_ApplicationRegistration_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        //vwe assign the same blockGroup as the Grid Container
        $this->_blockGroup = 'applicationregistration';
        //and the same controller
        $this->_controller = 'adminhtml_applicationregistration';
        //define the label for the save and delete button
        $this->_updateButton('save', 'label', Mage::helper('applicationregistration')->__('Save User'));
    }

    public function getHeaderText()
    {
        if( Mage::registry('applicationregistration_data') && Mage::registry('applicationregistration_data')->getId())
        {
            return Mage::helper('applicationregistration')->__("Edit User '%s'",
                $this->htmlEscape(Mage::registry('applicationregistration_data')->getTitle()));
        }
        else
        {
            return Mage::helper('applicationregistration')->__('Add User');
        }
    }
}