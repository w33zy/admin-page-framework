<?php
/**
 Admin Page Framework v3.5.7 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
class AdminPageFramework_FormElement_Meta extends AdminPageFramework_FormElement {
    public function getUserSubmitDataFromPOST(array $aFieldDefinitionArrays, array $aSectionDefinitionArrays) {
        $_aInput = array();
        foreach ($aFieldDefinitionArrays as $_sSectionID => $_aSubSectionsOrFields) {
            if ('_default' == $_sSectionID) {
                $_aFields = $_aSubSectionsOrFields;
                foreach ($_aFields as $_aField) {
                    $_aInput[$_aField['field_id']] = $this->getElement($_POST, $_aField['field_id'], null);
                }
                continue;
            }
            $_aInput[$_sSectionID] = $this->getElementAsArray($_aInput, $_sSectionID, array());
            if (!count($this->getIntegerKeyElements($_aSubSectionsOrFields))) {
                $_aFields = $_aSubSectionsOrFields;
                foreach ($_aFields as $_aField) {
                    $_aInput[$_sSectionID][$_aField['field_id']] = $this->getElement($_POST, array($_sSectionID, $_aField['field_id']), null);
                }
                continue;
            }
            foreach ($_POST[$_sSectionID] as $_iIndex => $_aFields) {
                $_aInput[$_sSectionID][$_iIndex] = $this->getElement($_POST, array($_sSectionID, $_iIndex), null);
            }
        }
        return $_aInput;
    }
    public function updateMetaDataByType($iObjectID, array $aInput, array $aSavedMeta, $sFieldsType = 'post_meta_box') {
        if (!$iObjectID) {
            return;
        }
        $_aFunctionNameMapByFieldsType = array('post_meta_box' => 'update_post_meta', 'user_meta' => 'update_user_meta',);
        if (!in_array($sFieldsType, array_keys($_aFunctionNameMapByFieldsType))) {
            return;
        }
        $_sFunctionName = $this->getElement($_aFunctionNameMapByFieldsType, $sFieldsType);
        foreach ($aInput as $_sSectionOrFieldID => $_vValue) {
            $this->_updateMetaDatumByFuncitonName($iObjectID, $_vValue, $aSavedMeta, $_sSectionOrFieldID, $_sFunctionName);
        }
    }
    private function _updateMetaDatumByFuncitonName($iObjectID, $_vValue, array $aSavedMeta, $_sSectionOrFieldID, $_sFunctionName) {
        if (is_null($_vValue)) {
            return;
        }
        $_vSavedValue = $this->getElement($aSavedMeta, $_sSectionOrFieldID, null);
        if ($_vValue == $_vSavedValue) {
            return;
        }
        $_sFunctionName($iObjectID, $_sSectionOrFieldID, $_vValue);
    }
}