<?php
/**
 *
 * ------------------------------------------------------------------------------
 * @category     MT
 * @package      MT_Themes
 * ------------------------------------------------------------------------------
 * @copyright    Copyright (C) 2008-2013 MagentoThemes.net. All Rights Reserved.
 * @license      GNU General Public License version 2 or later;
 * @author       MagentoThemes.net
 * @email        support@magentothemes.net
 * ------------------------------------------------------------------------------
 *
 */
?>
<?php
class MagenThemes_MTDivas_Model_Resource_Widget extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Define main table
     *
     */
    protected function _construct()
    {
        $this->_init('widget/widget_instance', 'instance_id');
    }

    public function importInstancePage($instanceId, $pageObject, $order, $xml)
    {
        $pageTable         = $this->getTable('widget/widget_instance_page');
        $pageLayoutTable   = $this->getTable('widget/widget_instance_page_layout');
        $writeAdapter      = $this->_getWriteAdapter();


        $data = array(
            'page_group'      => $pageObject->group,
            'layout_handle'   => $pageObject->layout_handle,
            'block_reference' => $pageObject->block_reference,
            'page_for'        => $pageObject->for,
            'entities'        => $pageObject->entities,
            'page_template'   => $pageObject->template,
        );
        //Insert Layout Update
        $pageLayoutUpdateIds = $this->importLayoutUpdates($pageObject, $order, $xml);
        //Insert Page
        $writeAdapter->insert($pageTable, array_merge(array('instance_id' => $instanceId), $data));
        $pageId = $writeAdapter->lastInsertId($pageTable);
        //Insert Page Layout
        foreach($pageLayoutUpdateIds as $layoutUpdateId){
            $writeAdapter->insert($pageLayoutTable, array(
                'page_id' => $pageId,
                'layout_update_id' => $layoutUpdateId
            ));
        }
    }

    /**
     * Prepare and save layout updates data
     *
     * @param Mage_Widget_Model_Widget_Instance $widgetInstance
     * @param array $pageGroupData
     * @return array of inserted layout updates ids
     */
    protected function importLayoutUpdates($pageGroupData, $order, $xml)
    {
        $writeAdapter          = $this->_getWriteAdapter();
        $pageLayoutUpdateIds   = array();
        $layoutUpdateTable     = $this->getTable('core/layout_update');
        $layoutUpdateLinkTable = $this->getTable('core/layout_link');
        $insert = array(
            'handle'     => $pageGroupData->layout_handle,
            'xml'        => $xml
        );
        if (strlen($order)) {
            $insert['sort_order'] = $order;
        };

        $writeAdapter->insert($layoutUpdateTable, $insert);
        $layoutUpdateId = $writeAdapter->lastInsertId($layoutUpdateTable);
        $pageLayoutUpdateIds[] = $layoutUpdateId;
        $data = array(
            'store_id'         => '0',
            'area'             => $pageGroupData->area,
            'package'          => $pageGroupData->package,
            'theme'            => $pageGroupData->theme,
            'layout_update_id' => $layoutUpdateId);
        $writeAdapter->insertMultiple($layoutUpdateLinkTable, $data);
        return $pageLayoutUpdateIds;
    }
}
