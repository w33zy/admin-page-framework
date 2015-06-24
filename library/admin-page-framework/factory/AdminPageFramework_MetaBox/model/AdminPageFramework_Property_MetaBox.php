<?php
/**
 Admin Page Framework v3.5.9b09 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class AdminPageFramework_Property_MetaBox extends AdminPageFramework_Property_Base {
    public $_sPropertyType = 'post_meta_box';
    public $sMetaBoxID = '';
    public $sTitle = '';
    public $aPostTypes = array();
    public $aPages = array();
    public $sContext = 'normal';
    public $sPriority = 'default';
    public $sClassName = '';
    public $sCapability = 'edit_posts';
    public $sThickBoxTitle = '';
    public $sThickBoxButtonUseThis = '';
    public $aHelpTabText = array();
    public $aHelpTabTextSide = array();
    public $sFieldsType = 'post_meta_box';
    public function __construct($oCaller, $sClassName, $sCapability = 'edit_posts', $sTextDomain = 'admin-page-framework', $sFieldsType = 'post_meta_box') {
        parent::__construct($oCaller, null, $sClassName, $sCapability, $sTextDomain, $sFieldsType);
    }
    protected function _getOptions() {
        return array();
    }
}