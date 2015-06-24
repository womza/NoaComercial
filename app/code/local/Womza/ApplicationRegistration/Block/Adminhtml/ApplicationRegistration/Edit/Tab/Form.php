<?php

class Womza_ApplicationRegistration_Block_Adminhtml_ApplicationRegistration_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        if (Mage::getSingleton('adminhtml/session')->getApplicationRegistrationData())
        {
            $data = Mage::getSingleton('adminhtml/session')->getApplicationRegistrationData();
            Mage::getSingleton('adminhtml/session')->getApplicationRegistrationData(null);
        }
        elseif (Mage::registry('applicationregistration_data'))
        {
            $data = Mage::registry('applicationregistration_data')->getData();
        }
        else
        {
            $data = array();
        }

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('applicationregistration_form', array('legend'=>Mage::helper('applicationregistration')->__('User information')));

        $fieldset->addField('name', 'text', array(
            'label'     => Mage::helper('applicationregistration')->__('Name'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'name',
        ));
        $fieldset->addField('location', 'text', array(
            'label'     => Mage::helper('applicationregistration')->__('Location'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'location',
        ));
        $fieldset->addField('province', 'text', array(
            'label'     => Mage::helper('applicationregistration')->__('Province'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'province',
        ));
        $fieldset->addField('company', 'text', array(
            'label'     => Mage::helper('applicationregistration')->__('Company'),
            'required'  => false,
            'name'      => 'company',
        ));
        $fieldset->addField('email', 'text', array(
            'label'     => Mage::helper('applicationregistration')->__('Email'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'email',
        ));
        $fieldset->addField('phone', 'text', array(
            'label'     => Mage::helper('applicationregistration')->__('Phone'),
            'required'  => false,
            'name'      => 'phone',
        ));
        $fieldset->addField('comment', 'editor', array(
            'name'      => 'comment',
            'label'     => Mage::helper('applicationregistration')->__('Comment'),
            'title'     => Mage::helper('applicationregistration')->__('Comment'),
            'style'     => 'width:98%; height:150px;',
            'wysiwyg'   => false,
            'required'  => false,
        ));

        if ( Mage::getSingleton('adminhtml/session')->getApplicationRegistrationData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getApplicationRegistrationData());
            Mage::getSingleton('adminhtml/session')->setApplicationRegistrationData(null);
        } elseif ( Mage::registry('applicationregistration_data') ) {
            $form->setValues(Mage::registry('applicationregistration_data')->getData());
        }

        $form->setValues($data);
        return parent::_prepareForm();
    }
}