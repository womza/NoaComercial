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

class MagenThemes_MTTheme_Helper_Grid extends Mage_Core_Helper_Abstract
{
    /**
     * Values: number of columns / grid item width
     *
     * @var array
     */
    protected $_itemWidth = array(
        "1" => 98,
        "2" => 48,
        "3" => 33.3333,
        "4" => 25,
        "5" => 20,
        "6" => 16.6666,
        "7" => 14.2857,
        "8" => 12.5,
    );

    /**
     * Get CSS for grid item based on number of columns
     *
     * @param int $columnCount
     * @return string
     */
    public function getCssGridItem($columnCount)
    {
        $out = "\n";
        $out .= '.itemgrid.itemgrid-adaptive .item { width:' . $this->_itemWidth[$columnCount] . '%; clear:none !important; }' . "\n";

        if ($columnCount > 1)
        {
            $out .= '.itemgrid.itemgrid-adaptive .item:nth-child(' . $columnCount . 'n+1) { clear:left !important; }' . "\n";
        }

        return $out;
    }
}