<?php
/**
 Admin Page Framework v3.7.2 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
abstract class AdminPageFramework_HelpPane_Base extends AdminPageFramework_Debug {
    public $oProp;
    public $oUtil;
    protected $_oScreen;
    function __construct($oProp) {
        $this->oProp = $oProp;
        $this->oUtil = new AdminPageFramework_WPUtility;
    }
    protected function _setHelpTab($sID, $sTitle, $aContents, $aSideBarContents = array()) {
        if (empty($aContents)) {
            return;
        }
        $this->_oScreen = isset($this->_oScreen) ? $this->_oScreen : get_current_screen();
        $this->_oScreen->add_help_tab(array('id' => $sID, 'title' => $sTitle, 'content' => implode(PHP_EOL, $aContents),));
        if (!empty($aSideBarContents)) {
            $this->_oScreen->set_help_sidebar(implode(PHP_EOL, $aSideBarContents));
        }
    }
    protected function _formatHelpDescription($sHelpDescription) {
        return "<div class='contextual-help-description'>" . $sHelpDescription . "</div>";
    }
}