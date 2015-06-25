<?php
class Womza_ApplicationRegistration_IndexController extends Mage_Core_Controller_Front_Action
{
    public function IndexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('core/session');
        $this->renderLayout();
    }

    public function SaveAction()
    {
        // get form data
        $params = $this->getRequest()->getParams();
        try
        {
            $applicationregistration = Mage::getModel('applicationregistration/registration');
            $applicationregistration->setData('name', $params['name']);
            $applicationregistration->setData('location', $params['location']);
            $applicationregistration->setData('province', $params['province']);
            $applicationregistration->setData('company', $params['company']);
            $applicationregistration->setData('email', $params['email']);
            $applicationregistration->setData('phone', $params['phone']);
            $applicationregistration->setData('comment', $params['comment']);
            $applicationregistration->setData('created_time', Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_LONG));
            $applicationregistration->save();

            Mage::getSingleton('core/session')->addSuccess(Mage::helper('applicationregistration')->__('Thank you, your application will be processed'));
        }
        catch(Exception $e)
        {
            Mage::getSingleton('core/session')->addError(Mage::helper('applicationregistration')->__('Your data could not be saved, try again!'));
        }

        // Redirect back to index action of applicationregistration controller
        $this->_redirect('applicationregistration/');
    }
}