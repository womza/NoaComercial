<?php
class Womza_ApplicationRegistration_Block_Adminhtml_ApplicationRegistration_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('applicationregistrationGrid');
        $this->setDefaultSort('applicationregistration_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('applicationregistration/registration')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id',
            array(
                'header' => Mage::helper('applicationregistration')->__('ID'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'applicationregistration_id',
            ));
        $this->addColumn('name',
            array(
                'header' => Mage::helper('applicationregistration')->__('Name'),
                'align' =>'left',
                'index' => 'name',
            ));
        $this->addColumn('location',
            array(
                'header' => Mage::helper('applicationregistration')->__('Location'),
                'align' =>'left',
                'index' => 'location',
            ));
        $this->addColumn('province',
            array(
                'header' => Mage::helper('applicationregistration')->__('Province'),
                'align' =>'left',
                'index' => 'province',
            ));
        $this->addColumn('email',
            array(
                'header' => Mage::helper('applicationregistration')->__('Email'),
                'align' =>'left',
                'index' => 'email',
            ));
        $this->addColumn('checked',
            array(
                'header' => Mage::helper('applicationregistration')->__('Checked'),
                'align' =>'left',
                'index' => 'checked',
                'type' => 'options',
                'options' => array(
                    0 => Mage::helper('applicationregistration')->__('No'),
                    1 => Mage::helper('applicationregistration')->__('Yes'),
                )
            ));
        $this->addColumn('created_time',
            array(
                'header' => Mage::helper('applicationregistration')->__('Creation Time'),
                'align' =>'left',
                'width' => '120px',
                'type' => 'date',
                'default' => '--',
                'index' => 'created_time',
            ));
        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=> true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getApplicationregistrationId()));
    }
}