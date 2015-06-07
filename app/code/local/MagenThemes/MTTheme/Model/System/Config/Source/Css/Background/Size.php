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

class MagenThemes_MTTheme_Model_System_Config_Source_Css_Background_Size
{
    public function toOptionArray()
    {
		return array(
			array('value' => 'cover',	'label' => Mage::helper('adminhtml')->__('cover')),
			array('value' => 'auto',	'label' => Mage::helper('adminhtml')->__('auto')),
            array('value' => 'contain',	'label' => Mage::helper('adminhtml')->__('contain'))
        );
    }
}