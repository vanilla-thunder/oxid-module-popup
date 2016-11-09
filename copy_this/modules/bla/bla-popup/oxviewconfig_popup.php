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

class oxviewconfig_popup extends oxviewconfig_popup_parent
{

   public function blaPopup()
   {
      if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1" || $_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR']) return;

      /** @var oxConfig $cfg */
      $cfg = oxRegistry::getConfig();
      $active = $cfg->getConfigParam('blaPopup_active');
      $from = ($cfg->getConfigParam('blaPopup_activefrom') == "0000-00-00 00:00:00") ? false : $cfg->getConfigParam('blaPopup_activefrom');
      $to = ($cfg->getConfigParam('blaPopup_activeto') == "0000-00-00 00:00:00") ? false : $cfg->getConfigParam('blaPopup_activeto');
      $now = date("Y-m-d H:i:s");

      $blPopup = false;
      if ($now >= $from && $to > $now) $blPopup = true; // bis > jetzt > von  = popup an
      if ($active) $blPopup = $active; // override: active?

      $blDebug = $cfg->getConfigParam("blaPopup_debug");
      $sType = $cfg->getConfigParam('blaPopup_contentType');
      $sIdentUrl = $cfg->getConfigParam('blaPopup_contentident');
      $aStatic = $cfg->getConfigParam('blaPopup_contenthtml');
      $sCookieValue = $cfg->getConfigParam('blaPopup_cookie');
      $sWidth = ($cfg->getConfigParam('blaPopup_width')) ? " style='width: " . $cfg->getConfigParam('blaPopup_width') . ";' " : "";

      $html = "";

      // check of popup has already beed displayed
      if ($blDebug || ($blPopup && ($sIdentUrl || $aStatic) && $_COOKIE['blapopup'] !== $sCookieValue)) {
         $smarty = oxRegistry::get("oxUtilsView")->getSmarty();
         $sSufix = ($smarty->_tpl_vars["__oxid_include_dynamic"]) ? '_dynamic' : '';
         $aScript = (array)$cfg->getGlobalParameter('scripts' . $sSufix);

         $script = "";

         /* bootstrap modal ============================================== bootstrap modal

         <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title" id="myModalLabel">Modal title</h4></div>
            <div class="modal-body">
               ...
            </div>
         </div>
         </div>
         </div>

         foudnation reveal ============================================== foudnation reveal

             <div id='blapopup' class='reveal-modal' data-reveal> content <a class='close-reveal-modal' aria-label='Close'>x</a></div>

         */
         switch ($sType) {
            case "cms":
               /** @var oxContent $cms */
               $cms = oxNew("oxcontent");
               $cms->loadByIdent($sIdentUrl);
               $content = oxRegistry::get("oxUtilsView")->parseThroughSmarty($cms->oxcontents__oxcontent->value);

               $html = "<div class='modal fade' id='blapopup' tabindex='-1' role='dialog'><div class='modal-dialog' role='document'><div class='modal-content'><div class='modal-body'>".$content."</div></div></div></div>"; //bootstrap
               $script = '$("#blapopup").modal("show")'; //bootstrap

               //$html = "<div id='blapopup' class='reveal-modal' data-reveal $sWidth>".$content."<a class='close-reveal-modal' aria-label='Close'>x</a></div>"; // foundation
               //$script = '$("#blapopup").foundation("reveal","open")'; // foundation
               break;
            case "url":
               $html = "<div class='modal fade' id='blapopup' tabindex='-1' role='dialog'><div class='modal-dialog' role='document'><div class='modal-content'><div class='modal-body'></div></div></div></div>"; //bootstrap
               $script = '$("#blapopup").on("show.bs.modal", function (e) { $("#blapopup .modal-content").load("'.$sIdentUrl.'"); });'; // bootstrap
               $script .= '$("#blapopup").modal("show");'; //bootstrap

               //$html = "<div id='blapopup' class='reveal-modal' data-reveal $sWidth><a class='close-reveal-modal' aria-label='Close'>x</a></div>"; // foundation
               //$script = '$("#blapopup").foundation("reveal","open","'.$sIdentUrl.'")'; // foundation
               break;
            case "static":
               $content = oxRegistry::get("oxUtilsView")->parseThroughSmarty(implode("", $aStatic));

               $html = "<div class='modal fade' id='blapopup' tabindex='-1' role='dialog'><div class='modal-dialog' role='document'><div class='modal-content'><div class='modal-body'>".$content."</div></div></div></div>"; //bootstrap
               $script = '$("#blapopup").modal("show")'; //bootstrap

               //$html = "<div id='blapopup' class='reveal-modal' data-reveal $sWidth>".$content."<a class='close-reveal-modal' aria-label='Close'>x</a></div>"; // foundation
               //$script = '$("#blapopup").foundation("reveal","open")'; // foundation
               break;
         }

         $aScript[] = $script;
         $cfg->setGlobalParameter('scripts' . $sSufix, $aScript);

         setcookie("blapopup", $sCookieValue, time() + 14 * 24 * 60 * 60, "/");

      }

      return $html;
   }
}