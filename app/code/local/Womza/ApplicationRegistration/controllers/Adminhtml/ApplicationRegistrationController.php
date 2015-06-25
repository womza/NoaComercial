<?php
class Womza_ApplicationRegistration_Adminhtml_ApplicationRegistrationController
    extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->_title($this->__('Application of Register'));
        $this->loadLayout()
            ->_setActiveMenu('applicationregistration/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        $this->_setActiveMenu('customer/customer');
        return $this;
    }

    // Shows the grid
    public function indexAction()
    {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('applicationregistration/adminhtml_applicationregistration'));
        $this->renderLayout();
    }

    // Forwards on to the edit action
    public function newAction()
    {
        $this->_forward('edit');
    }

    // Shows the edit/new form
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('applicationregistration/registration')->load($id);

        if ($model->getId()) {
            Mage::register('applicationregistration_data', $model);

            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if ($data) {
                $model->setData($data)->setId($id);
            }

            $this->loadLayout();
            $this->_setActiveMenu('applicationregistration/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('applicationregistration/adminhtml_applicationregistration_edit'))
                ->_addLeft($this->getLayout()->createBlock('applicationregistration/adminhtml_applicationregistration_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('applicationregistration')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    // Saves the form data
    public function saveAction()
    {
        if ( $this->getRequest()->getPost() ) {
            try {
                $postData = $this->getRequest()->getPost();
                $model = Mage::getModel('applicationregistration/registration');

                $model->setId($this->getRequest()->getParam('id'))
                    ->setName($postData['name'])
                    ->setLocation($postData['location'])
                    ->setProvince($postData['province'])
                    ->setCompany($postData['company'])
                    ->setEmail($postData['email'])
                    ->setPhone($postData['phone'])
                    ->setComment($postData['comment'])
                    ->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setApplicationRegistrationData(false);

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setApplicationRegistrationData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    // Deletes the model
    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('applicationregistration/registration');

                $model->setId($this->getRequest()->getParam('id'))->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('applicationregistration/adminhtml_applicationregistration_grid')->toHtml()
        );
    }
}