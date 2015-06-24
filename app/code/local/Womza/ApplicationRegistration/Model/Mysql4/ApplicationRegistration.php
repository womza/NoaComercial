<?php
class Womza_ApplicationRegistration_Model_Mysql4_ApplicationRegistration extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('applicationregistration/applicationregistration', 'applicationregistration_id');
    }
}