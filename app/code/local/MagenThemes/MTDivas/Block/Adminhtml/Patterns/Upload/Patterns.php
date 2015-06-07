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
class MagenThemes_MTDivas_Block_Adminhtml_Patterns_Upload_Patterns extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){ 
       	$html = parent::_getElementHtml($element);
		$directry = Mage::getBaseDir('media').DS.'wysiwyg'.DS.'magenthemes'.DS.'mtdivas'.DS.'patterns';
		$urlparth = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
		$images = array();
		if (is_dir($directry)) {
			if ($dh = opendir($directry)) { 
				while (($file = readdir($dh)) !== false) {
					if(is_file($directry.DS.$file)){
						$filetype = substr($file, -3, 3);
						switch ($filetype)
						{ 
							case 'jpg':
							case 'png':
							case 'gif':  
								$images[] = $file; 
								break; 
						}
					} 
				} 
			}
		}
        $html .='<link href="'.$urlparth.'skin/adminhtml/mtdivas/css/style.css'.'" type="text/css" rel="stylesheet">';
		$html .='<div class="listpattern '.$element->getHtmlId().'_pattern">';
			$html .='<span class="item">
						<span class="ptnone">None</span>
						<input type="radio" name="'.$element->getHtmlId().'_pattern" value="none" style="margin: 8px; 0 4px 0" class="valpt"/>
					 </span>';
			if($images){
				foreach ($images as $img){
			$html .='<span class="item">
						<img src="'.$urlparth.'media/wysiwyg/magenthemes/mtdivas/patterns/'.$img.'" />
						<input type="radio" name="'.$element->getHtmlId().'_pattern" value="'.$img.'" class="valpt"/>
					 </span>';
				}
			}
		$html .='</div>';
		$html .= ' 
				<script type="text/javascript">
					jQuery(window).load(function(){
						jQuery(".'.$element->getHtmlId().'_pattern input[type=radio]").click(function(){
							jQuery("#'.$element->getHtmlId().'").val(jQuery(this).val())
						}); 
						pattern'.$element->getHtmlId().'Active();
					});
					function pattern'.$element->getHtmlId().'Active(){
						var ptnbody =jQuery("#'.$element->getHtmlId().'").val();
						jQuery(".'.$element->getHtmlId().'_pattern input[type=radio]").each(function(i,rad){
							if(rad.value==ptnbody){  
								jQuery(rad).attr("checked", true);
							}   
						});
					}
				</script> 
			';
        return $html;
    }
}
?>