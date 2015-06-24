<?php
class Womza_ApplicationRegistration_Block_Adminhtml_ApplicationRegistration
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_controller = 'adminhtml_applicationregistration';
        $this->_blockGroup = 'applicationregistration';
        $this->_headerText = Mage::helper('applicationregistration')->__('Registered Users');
        $this->_removeButton('add');
    }

    protected function _prepareLayout()
    {
        $this->setChild( 'grid',
            $this->getLayout()->createBlock( $this->_blockGroup.'/' . $this->_controller . '_grid',
                $this->_controller . '.grid')->setSaveParametersInSession(true) );
        return parent::_prepareLayout();
    }
}