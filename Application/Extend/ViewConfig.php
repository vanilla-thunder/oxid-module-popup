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

namespace VanillaThunder\Popup\Application\Extend;

use OxidEsales\Eshop\Application\Model\Content;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Registry;

class ViewConfig extends ViewConfig_parent
{

    public function vtPopup()
    {
        // do not display popup for local requests
        if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1" || $_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR']) return "";

        /** @var Config $cfg */
        $cfg = Registry::getConfig();
        $active = $cfg->getConfigParam('blPopupActive');
        $from = ($cfg->getConfigParam('sPopupActiveFrom') == "0000-00-00 00:00:00") ? false : $cfg->getConfigParam('sPopupActiveFrom');
        $to = ($cfg->getConfigParam('sPopupActiveTo') == "0000-00-00 00:00:00") ? false : $cfg->getConfigParam('sPopupActiveTo');
        $now = date("Y-m-d H:i:s");

        $blPopup = false;
        if ($now >= $from && $to > $now) $blPopup = true; // bis > jetzt > von  = popup an
        if ($active) $blPopup = $active; // override: active?

        $sBootstrapVersion = "4";
        $blDebug = $cfg->getConfigParam("blPopupDebug");
        $sHeader = $cfg->getConfigParam('sPopupHeader');
        $sType = $cfg->getConfigParam('sPopupContentType');
        $sIdentUrl = $cfg->getConfigParam('sPopupContentIdent');
        $aStatic = $cfg->getConfigParam('aPopupContentHTML');
        $sCookieValue = $cfg->getConfigParam('sPopupCookie');
        $sSize = ($cfg->getConfigParam('sPopupSize') === 'default') ? "" : "modal-".$cfg->getConfigParam('sPopupSize');

        $sModalHTML = "";

        // check of popup has already beed displayed
        if (($blPopup && ($sIdentUrl || $aStatic))) {
            $smarty = Registry::getUtilsView()->getSmarty();
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

                <div id='vtpopup' class='reveal-modal' data-reveal> content <a class='close-reveal-modal' aria-label='Close'>x</a></div>

            */
            $content = "";
            $script = "";

            switch ($sType) {
                case "cms":
                    /** @var Content $cms */
                    $cms = oxNew(Content::class);
                    $cms->loadByIdent($sIdentUrl);
                    $sHeader =  ($sHeader ? $sHeader : $cms->oxcontents__oxtitle->value);
                    $content = Registry::get("oxUtilsView")->parseThroughSmarty($cms->oxcontents__oxcontent->value);

                    //$html = "<div id='vtpopup' class='reveal-modal' data-reveal $sWidth>".$content."<a class='close-reveal-modal' aria-label='Close'>x</a></div>"; // foundation
                    //$script = '$("#vtpopup").foundation("reveal","open")'; // foundation
                    break;
                case "url":
                    $script .= '$("#vtpopup").on("show.bs.modal", function (e) { $("#vtpopup .modal-content").load("' . $sIdentUrl . '"); });';

                    //$html = "<div id='vtpopup' class='reveal-modal' data-reveal $sWidth><a class='close-reveal-modal' aria-label='Close'>x</a></div>"; // foundation
                    //$script = '$("#vtpopup").foundation("reveal","open","'.$sIdentUrl.'")'; // foundation
                    break;
                case "static":
                    $content = Registry::get("oxUtilsView")->parseThroughSmarty(implode("", $aStatic));

                    //$html = "<div id='vtpopup' class='reveal-modal' data-reveal $sWidth>".$content."<a class='close-reveal-modal' aria-label='Close'>x</a></div>"; // foundation
                    //$script = '$("#vtpopup").foundation("reveal","open")'; // foundation
                    break;
            }
            $aModalHTML = [
                "3" => "<div class='modal fade' id='vtpopup' tabindex='-1' role='dialog'><div class='modal-dialog {$sSize}' role='document'><div class='modal-content'><div class='modal-body'>" . $content . "</div></div></div></div>", //bootstrap 3
                "4" => "<div class='modal fade' id='vtpopup' tabindex='-1' role='dialog'><div class='modal-dialog {$sSize}' role='document'><div class='modal-content'>".
                    ($sHeader ? "<div class='modal-header'><h5 class='modal-title'>".$sHeader."</h5><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>" : "").
                    "<div class='modal-body'>" . $content . "</div></div></div></div>", //bootstrap 4
                "5" => "<div class='modal fade' id='vtpopup' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'><div class='modal-dialog {$sSize}'><div class='modal-content'>".
                    ($sHeader ? "<div class='modal-header'><h5 class='modal-title' id='exampleModalLabel'>".$sHeader."</h5><button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button></div>" : "").
                    "<div class='modal-body'>".$content."</div></div></div></div>" // bootstrap 5
            ];
            $sModalHTML = $aModalHTML[$sBootstrapVersion];

            $aModalScript = [
                "3" => '$("#vtpopup").modal("show")',
                "4" => '$("#vtpopup").modal("show")',
                "5" => 'document.getElementById("vtpopup").show()',
            ];
            $aScript[] = $script.$aModalScript[$sBootstrapVersion];
            if($blDebug || $_COOKIE['vtpopup'] !== $sCookieValue) $cfg->setGlobalParameter('scripts' . $sSufix, $aScript);

            setcookie("vtpopup", $sCookieValue, time() + 14 * 24 * 60 * 60, "/");

        }

        return $sModalHTML;
    }
}