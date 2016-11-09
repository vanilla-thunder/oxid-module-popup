<?php
/**
 * simple Popup for OXID eShop CE
 * Copyright (C) 2016  bestlife AG
 * info:  oxid@bestlife.ag
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation;
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>
 *
 * @author      bestlife AG <oxid@bestlife.ag>
 * @author      Marat Bedoev
 * @link        http://www.bestlife.ag
 *
 * @license     GPLv3
 */

$sMetadataVersion = '1.1';
$aModule          = array(
    'id'          => 'bla-popup',
    'title'       => '<strong style="color:#95b900;font-size:125%;">best</strong><strong style="color:#c4ca77;font-size:125%;">life</strong> <strong>Pop-Up</strong>',
    'description' => 'Popup für den ersten Seitenbesuch. Session-basiert',
    'thumbnail'   => 'bestlife.png',
    'version'     => '1.4.0',
    'author'      => ' bestlife AG',
    'email'       => 'oxid@bestlife.ag',
    'url'         => 'https://github.com/vanilla-thunder/bla-popup',
    'extend'      => array(
        'oxviewconfig'         => 'bla/bla-popup/oxviewconfig_popup',
    ),
    'blocks' => array(
        array( 'template' => 'layout/base.tpl', 'block' => 'base_js', 'file' => '/views/blocks/base_js.tpl' ),
    ),
    'settings'    => array(
        /* account settings */
        array('group' => 'blaPopupContent', 'name' => 'blaPopup_active', 'type' => 'bool', 'value' => false, 'position' => 0),
        array('group' => 'blaPopupContent', 'name' => 'blaPopup_activefrom', 'type' => 'str', 'value' => '0000-00-00 00:00:00', 'position' => 1),
        array('group' => 'blaPopupContent', 'name' => 'blaPopup_activeto', 'type' => 'str', 'value' => '0000-00-00 00:00:00', 'position' => 2),
        array('group' => 'blaPopupContent', 'name' => 'blaPopup_cookie', 'type' => 'str', 'value' => '', 'position' => 3),
        array('group' => 'blaPopupContent', 'name' => 'blaPopup_contentType', 'type' => 'select', 'value' => '', 'position' => 4, 'constraints' => 'cms|static|url'),
        array('group' => 'blaPopupContent', 'name' => 'blaPopup_contentident', 'type' => 'str', 'value' => '', 'position' => 5),
        array('group' => 'blaPopupContent', 'name' => 'blaPopup_contenthtml', 'type' => 'arr', 'value' => '', 'position' => 6),
        array('group' => 'blaPopupContent', 'name' => 'blaPopup_width', 'type' => 'str', 'value' => '', 'position' => 7),
        array('group' => 'blaPopupContent', 'name' => 'blaPopup_debug', 'type' => 'bool', 'value' => false, 'position' => 8),



        //array('group' => 'blaPopupScript', 'name' => 'blaPopup_', 'type' => 'str', 'value' => '', 'position' => 4),
        //array('group' => 'blaPopupScript', 'name' => 'blaPopup_', 'type' => 'bool', 'value' => true, 'position' => 5),
        //array('group' => 'blaPopupScript', 'name' => 'blaPopup_', 'type' => 'bool', 'value' => false, 'position' => 6),



    )
);
