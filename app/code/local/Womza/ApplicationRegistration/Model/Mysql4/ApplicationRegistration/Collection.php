<?php
class Womza_ApplicationRegistration_Model_Mysql4_ApplicationRegistration_Collection
    extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _constuct()
    {
        //parent::_construct();
        $this->_init('applicationregistration/applicationregistration');
    }
}