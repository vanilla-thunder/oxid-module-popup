<?php
/**
 * vanilla-thunder/oxid-module-popup
 * simple popup module for OXID eShop v6.2+
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation;
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>
 **/

$sMetadataVersion = '1.1';
$aModule = [
    'id' => 'vt-popup',
    'title' => '[vt] Popup',
    'description' => 'Popup für den ersten Seitenbesuch. Session-basiert',
    'thumbnail' => 'thumbnail.jpg',
    'version' => '2.0.0',
    'author' => 'Marat Bedoev',
    'email' => openssl_decrypt("Az6pE7kPbtnTzjHlPhPCa4ktJLphZ/w9gKgo5vA//p4=", str_rot13("nrf-128-pop"), str_rot13("gvalzpr")),
    'url' => 'https://github.com/vanilla-thunder/oxid-module-popup',
    'extend' => [
        \OxidEsales\Eshop\Core\ViewConfig::class => VanillaThunder\Popup\Application\Extend\ViewConfig::class
    ],
    'blocks' => [
        [
            'template' => 'layout/base.tpl',
            'block' => 'base_js',
            'file' => '/Application/views/blocks/base_js.tpl'
        ]
    ],
    'settings' => [
        /* account settings */
        ['group' => 'vt_popup_settings', 'name' => 'blPopupActive', 'type' => 'bool', 'value' => false, 'position' => 0],
        ['group' => 'vt_popup_settings', 'name' => 'sPopupActiveFrom', 'type' => 'str', 'value' => '0000-00-00 00:00:00', 'position' => 1],
        ['group' => 'vt_popup_settings', 'name' => 'sPopupActiveTo', 'type' => 'str', 'value' => '0000-00-00 00:00:00', 'position' => 2],
        ['group' => 'vt_popup_settings', 'name' => 'sPopupCookie', 'type' => 'str', 'value' => '', 'position' => 3],
        ['group' => 'vt_popup_settings', 'name' => 'sPopupBootstrapVersion', 'type' => 'select', 'value' => '4', 'position' => 4, 'constraints' => '3|4|5'],
        ['group' => 'vt_popup_settings', 'name' => 'sPopupHeader', 'type' => 'str', 'value' => '', 'position' => 5],
        ['group' => 'vt_popup_settings', 'name' => 'sPopupContentType', 'type' => 'select', 'value' => '', 'position' => 6, 'constraints' => 'cms|static|url'],
        ['group' => 'vt_popup_settings', 'name' => 'sPopupContentIdent', 'type' => 'str', 'value' => '', 'position' => 7],
        ['group' => 'vt_popup_settings', 'name' => 'aPopupContentHTML', 'type' => 'arr', 'value' => '', 'position' => 8],
        ['group' => 'vt_popup_settings', 'name' => 'sPopupSize', 'type' => 'select', 'value' => 'default', 'constraints' => 'sm|default|lg|xl', 'position' => 9],
        ['group' => 'vt_popup_settings', 'name' => 'blPopupDebug', 'type' => 'bool', 'value' => false, 'position' => 10],
    ]
];
