<?php
/**
 *
 * ------------------------------------------------------------------------------
 * @category     MT
 * @package      MT_Newsletter
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
class MT_Newsletter_Block_Adminhtml_System_Config_Form_Field_Js extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){ 
       	$html = parent::_getElementHtml($element);
        $js = $this->getJsUrl('magenthemes/jquery/jquery-1.8.2.min.js');
        $colorpicker = $this->getJsUrl('magenthemes/jquery/plugins/mcolorpicker/');
        $html .= '
                <script type="text/javascript" src="'. $js .'"></script>
                <script type="text/javascript">jQuery.noConflict();</script>
                ';
        $html .= '<script type="text/javascript" src="'. $colorpicker .'mcolorpicker.js"></script>';
        $html .= '
                <style>
                    #row_'. $element->getHtmlId() .' { display: none;}
                </style>
                <script type="text/javascript">
                    jQuery.fn.mColorPicker.init.replace = false;
                    jQuery.fn.mColorPicker.defaults.imageFolder = "'. $colorpicker .'images/";
                    jQuery.fn.mColorPicker.init.allowTransparency = true;
                    jQuery.fn.mColorPicker.init.showLogo = false;
                </script>';
        return $html;
    }
}
?>