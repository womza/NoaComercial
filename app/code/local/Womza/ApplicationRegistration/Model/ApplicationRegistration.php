<?php
class Womza_ApplicationRegistration_Model_ApplicationRegistration extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('applicationregistration/applicationregistration');
    }

}