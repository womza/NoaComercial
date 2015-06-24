<?php
include_once('Mage/Customer/controllers/AccountController.php');
class Womza_ApplicationRegistration_Customer_AccountController extends Mage_Customer_AccountController
{
    /**
     * Customer register form page
     */
    public function createAction()
    {
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*');
            return;
        }
        $this->_redirect('applicationregistration/');
    }
}