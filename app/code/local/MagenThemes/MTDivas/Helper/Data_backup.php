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
class MagenThemes_MTDivas_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Get theme's main settings (single option)
     *
     * @return string
     */
    public function getCfg($optionString)
    {
        return Mage::getStoreConfig('mtdivas/' . $optionString);
    }

    /**
     * Get theme's main settings design (single option)
     *
     * @return array
     */
    public function getCfgSectionDesign($storeId)
    {
        if ($storeId)
            return Mage::getStoreConfig('mtdivas_design', $storeId);
        else
            return Mage::getStoreConfig('mtdivas_design');
    }

    /**
     * Get theme's design settings (single option)
     *
     * @return string
     */
    public function getThemeDesignCfg($optionString, $storeCode = NULL)
    {
        return Mage::getStoreConfig('mtdivas_design/' . $optionString, $storeCode);
    }

    /**
     * Get theme's layout settings (single option)
     *
     * @return string
     */
    public function getThemeLayoutCfg($optionString, $storeCode = NULL)
    {
        return Mage::getStoreConfig('mtdivas_layout/' . $optionString, $storeCode);
    }

    /**
     * Get view product show label
     *
     * @return product detail
     */
    protected function _loadProduct(Mage_Catalog_Model_Product $product)
    {
        $product->load($product->getId());
    }

    /**
     * Get config show label for product
     *
     * @return html label
     */
    public function getLabel(Mage_Catalog_Model_Product $product)
    {
        if ( 'Mage_Catalog_Model_Product' != get_class($product) )
            return;
        $html = '';
        if (!$this->getCfg("product_labels/new") &&
            !$this->getCfg("product_labels/sale")) {
            return $html;
        }
        $this->_loadProduct($product);
        if ( $this->getCfg("product_labels/new") && $this->_checkNew($product) ) {
            $html .= '<div class="product-new-label">'.$this->__('New').'</div>';
        }
        if ( $this->getCfg("product_labels/sale") && $this->_checkSale($product) ) {
            $html .= '<div class="product-sale-label">'.$this->__('Sale').'</div>';
        }

        return $html;
    }

    /**
     * Check date time locale
     *
     * @return true or false
     */
    protected function _checkDate($from, $to)
    {
        $today = strtotime(
            Mage::app()->getLocale()->date()
                ->setTime('00:00:00')
                ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT)
        );
        if ($from && $today < $from) {
            return false;
        }
        if ($to && $today > $to) {
            return false;
        }
        if (!$to && !$from) {
            return false;
        }
        return true;
    }

    /**
     * Get date from new product
     *
     * @return from date and to date
     */
    protected function _checkNew($product)
    {
        $from = strtotime($product->getData('news_from_date'));
        $to = strtotime($product->getData('news_to_date'));

        return $this->_checkDate($from, $to);
    }

    /**
     * Get date from sale product
     *
     * @return from date and to date
     */
    protected function _checkSale($product)
    {
        $from = strtotime($product->getData('special_from_date'));
        $to = strtotime($product->getData('special_to_date'));

        return $this->_checkDate($from, $to);
    }

    /**
     * Get alternative image HTML of the given product
     *
     * @param Mage_Catalog_Model_Product	$product		Product
     * @param int							$w				Image width
     * @param int							$h				Image height
     * @param string						$imgVersion		Image version: image, small_image, thumbnail
     * @return string
     */
    public function getAltImgHtml($product, $w, $h, $imgVersion='small_image')
    {
        $column = $this->getCfg('category/alt_image_column');
        $value = $this->getCfg('category/alt_image_column_value');
        $product->load('media_gallery');
        if ($gal = $product->getMediaGalleryImages())
        {
            if ($altImg = $gal->getItemByColumnValue($column, $value))
            {
                return
                    '<img class="img-responsive alt-img lazy" data-src="' . Mage::helper('mttheme/image')->getImg($product, $w, $h, $imgVersion, $altImg->getFile()) . '" alt="' . $product->getName() . '" />';
            }
        }

        return '';
    }

    public function getFormattedBlocks($block, $staticBlockId)
    {
        $colCount = 0;
        $colHtml = array();
        $html = '';
        for ($i = 1; $i < 7; $i++)
        {
            if ($tmp = $block->getChildHtml($staticBlockId . $i))
            {
                $colHtml[] = $tmp;
                $colCount++;
            }
        }

        if ($colHtml)
        {
            if($colCount==5){
                for ($i = 0; $i < $colCount; $i++)
                {
                    if($i==4){
                        $html .= '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">';
                        $html .= $colHtml[$i];
                        $html .= '</div>';
                    }else{
                        $html .= '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
                        $html .= $colHtml[$i];
                        $html .= '</div>';
                    }
                }
            }else{
                $n = (int) (12 / $colCount);
                for ($i = 0; $i < $colCount; $i++)
                {
                    $html .= '<div class="col-xs-'.$n.' col-sm-'.$n.' col-md-'.$n.' col-lg-'.$n.'">';
                    $html .= $colHtml[$i];
                    $html .= '</div>';
                }
            }

        }
        return $html;
    }
    
    public function getPreviousProduct()
    {
        $currentProduct = Mage::registry('current_product');

        if (!$currentProduct) {
            return false;
        }

        $prodId = $currentProduct->getId();

        $positions = Mage::getSingleton('core/session')
            ->getPrevNextProductCollection();

        if (!$positions) {

            $currentCategory = Mage::registry('current_category');

            if (!$currentCategory) {
                $categoryIds = Mage::registry('current_product')->getCategoryIds();
                $categoryId = current($categoryIds);

                $currentCategory = Mage::getModel('catalog/category')
                    ->load($categoryId);

                Mage::register('current_category', $currentCategory);
            }

            $positions = array_reverse(array_keys(Mage::registry('current_category')->getProductsPosition()));
        }

        $cpk = @array_search($prodId, $positions);

        $slice = array_reverse(array_slice($positions, 0, $cpk));

        foreach ($slice as $productId) {
            $product = Mage::getModel('catalog/product')
                ->load($productId);

            if ($product && $product->getId() && $product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility()) {
                return $product;
            }
        }

        return false;
    }
    
    public function getNextProduct()
    {
        $currentProduct = Mage::registry('current_product');

        if (!$currentProduct) {
            return false;
        }

        $prodId = $currentProduct->getId();

        $positions = Mage::getSingleton('core/session')
            ->getPrevNextProductCollection();

        if (!$positions) {

            $currentCategory = Mage::registry('current_category');

            if (!$currentCategory) {
                $categoryIds = Mage::registry('current_product')->getCategoryIds();
                $categoryId = current($categoryIds);

                $currentCategory = Mage::getModel('catalog/category')
                    ->load($categoryId);

                Mage::register('current_category', $currentCategory);
            }

            $positions = array_reverse(array_keys(Mage::registry('current_category')->getProductsPosition()));
        }

        $cpk = @array_search($prodId, $positions);

        $slice = array_slice($positions, $cpk + 1, count($positions));

        foreach ($slice as $productId) {
            $product = Mage::getModel('catalog/product')
                ->load($productId);

            if ($product && $product->getId() && $product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility()) {
                return $product;
            }
        }

        return false;
    }

}