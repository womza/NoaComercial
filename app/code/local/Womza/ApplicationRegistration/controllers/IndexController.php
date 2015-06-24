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
            $applicationregistration = Mage::getModel('applicationregistration/applicationregistration');
            $applicationregistration->setName($params['name']);
            $applicationregistration->setLocation($params['location']);
            $applicationregistration->setProvince($params['province']);
            $applicationregistration->setCompany($params['company']);
            $applicationregistration->setEmail($params['email']);
            $applicationregistration->setPhone($params['phone']);
            $applicationregistration->setComment($params['comment']);
            $applicationregistration->setData('created_time', Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_LONG));
            $applicationregistration->save();

            Mage::getSingleton('core/session')->addSuccess('Thank you, your application will be processed');
        }
        catch(Exception $e)
        {
            Mage::getSingleton('core/session')->addError('Your data could not be saved, try again! ' . $e->getMessage());
        }

        // Redirect back to index action of applicationregistration controller
        $this->_redirect('applicationregistration/');
    }
}