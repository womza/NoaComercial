<?php
class Womza_ApplicationRegistration_Model_Resource_Registration_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('applicationregistration/registration');
    }
}