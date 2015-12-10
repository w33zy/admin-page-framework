<?php
/**
 Admin Page Framework v3.7.2 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class AdminPageFramework_Form_View___Generate_FieldTagID extends AdminPageFramework_Form_View___Generate_Field_Base {
    public function get() {
        return $this->_getFiltered($this->_getBaseFieldTagID());
    }
    public function getModel() {
        return $this->get() . '__' . $this->sIndexMark;
    }
    protected function _getBaseFieldTagID() {
        $_sSectionIndex = isset($this->aArguments['_section_index']) ? '__' . $this->aArguments['_section_index'] : '';
        $_sSectionPart = implode('_', $this->aArguments['_section_path_array']);
        $_sFieldPart = implode('_', $this->aArguments['_field_path_array']);
        return $this->_isSectionSet() ? $_sSectionPart . $_sSectionIndex . '_' . $_sFieldPart : $_sFieldPart;
    }
}