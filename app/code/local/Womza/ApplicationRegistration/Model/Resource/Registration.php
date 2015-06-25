<?php
class Womza_ApplicationRegistration_Model_Resource_Registration extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('applicationregistration/registration', 'applicationregistration_id');
    }
}