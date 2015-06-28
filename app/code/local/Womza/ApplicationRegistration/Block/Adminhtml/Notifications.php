<?php
class Womza_ApplicationRegistration_Block_Adminhtml_Notifications extends Mage_Adminhtml_Block_Template
{
    public function getMessage()
    {
        // by default is 0 request of users
        $message = 0;
        // check if have requests new
        $collection = Mage::getModel('applicationregistration/registration')->getCollection();
        $countRequest = $collection->addFieldToFilter('checked', array('eq' => '0'))->count();
        if ($countRequest > 0)
            $message = $countRequest;
        return $message;
    }
}