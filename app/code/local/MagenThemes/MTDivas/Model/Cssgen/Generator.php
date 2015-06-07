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
class MagenThemes_MTDivas_Model_Cssgen_Generator extends Mage_Core_Model_Abstract{
    public function __construct(){
        parent::__construct();
    }
    public function generateCss($design, $websiteCode, $storeCode){
        if ($websiteCode){
            if ($storeCode) {
                $this->_generateStoreCss($design, $storeCode);
            } else {
                $this->_generateWebsiteCss($design, $websiteCode);
            }
        }else{
            $website = Mage::app()->getWebsites(false, true);
            foreach ($website as $value => $name) {
                $this->_generateWebsiteCss($design, $value);
            }
        }
    }
    protected function _generateWebsiteCss($design, $websiteCode) {
        $website = Mage::app()->getWebsite($websiteCode);
        foreach ($website->getStoreCodes() as $site){
            $this->_generateStoreCss($design, $site);
        }
    }
    protected function _generateStoreCss($design, $storeCode){
        if (!Mage::app()->getStore($storeCode)->getIsActive()) return;
        $prefix = '_' . $storeCode;
        if($design == 'layout'){
            $filename = $design . $prefix . '.css';
        }else{
            $filename = $design . $prefix . '.less';
        }
        $filedefault = Mage::helper('mtdivas/cssgen')->getGeneratedCssDir() . $filename;
        $path = 'magenthemes/mtdivas/css/' . $design . '.phtml';
        Mage::register('cssgen_store', $storeCode);
        try{
            $block = Mage::app()->getLayout()->createBlock("core/template")->setData('area', 'frontend')->setTemplate($path)->toHtml();
            if (empty($block)) {
                throw new Exception( Mage::helper('mtdivas')->__("Template file is empty or doesn't exist: %s", $path) );
            }
            $file = new Varien_Io_File();
            $file->setAllowCreateFolders(true);
            $file->open(array( 'path' => Mage::helper('mtdivas/cssgen')->getGeneratedCssDir() ));
            $file->streamOpen($filedefault, 'w+');
            $file->streamLock(true);
            $file->streamWrite($block);
            $file->streamUnlock();
            $file->streamClose();
        }catch (Exception $gener){
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mtdivas')->__('Failed generating CSS file: %s in %s', $filename, Mage::helper('mtdivas/cssgen')->getGeneratedCssDir()). '<br/>Message: ' . $gener->getMessage());
            Mage::logException($gener);
        }
        Mage::unregister('cssgen_store');
    }
}