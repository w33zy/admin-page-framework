<?php
/**
 * Admin Page Framework
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2013-2015 Michael Uno; Licensed MIT
 * 
 */

/**
 * Provides methods for the user to interact with the class object.
 * 
 * @package     AdminPageFramework
 * @subpackage  Form
 * @since       DEVVER
 */
class AdminPageFramework_Form_Controller extends AdminPageFramework_Form_View {
    
    /**
     * Adds the given section definition array to the form property.
     * 
     * @since       3.0.0
     * @since       DEVVER       Moved from `AminPageFramework_FormDefinition`.
     * @return      void
     */
    public function addSection( array $aSectionset ) {
        
        // $aSectionset                 = $aSectionset + AdminPageFramework_Form_Model___FormatSectionset::$aStructure;
        // Pre-format
        $aSectionset                 = $aSectionset + array(
            'section_id'    => null,
        );
        $aSectionset[ 'section_id' ] = $this->sanitizeSlug( $aSectionset[ 'section_id' ] );
        
        $this->aSectionsets[ $aSectionset[ 'section_id' ] ] = $aSectionset;    
        $this->aFieldsets[ $aSectionset[ 'section_id' ] ]   = $this->getElement(
            $this->aFieldsets,  // subject array
            $aSectionset[ 'section_id' ], // key
            array()      // default
        );                                
        
    }
    
    /**
     * Removes a section definition array from the property by the given section ID.
     * 
     * @since       3.0.0
     * @since       DEVVER       Moved from `AminPageFramework_FormDefinition`.
     */
    public function removeSection( $sSectionID ) {
        
        if ( '_default' === $sSectionID ){ 
            return; 
        }
        unset( 
            $this->aSectionsets[ $sSectionID ],
            $this->aFieldsets[ $sSectionID ]
        );
        
    }
    
    /**
     * Returns the added resource items.
     * @since       DEVVER
     * @return      array
     */
    public function getResources( $sKey ) {
        return $this->getElement( self::$_aResources, $sKey );
    }
    /**
     * Sets the resouce items.
     * @return      void
     */
    public function setResources( $sKey, $mValue ) {
        return self::$_aResources[ $sKey ] = $mValue;
    }
    /**
     * @since       DEVVER
     * @return      void
     */
    public function addResource( $sKey, $sValue ) {
        self::$_aResources[ $sKey ][] = $sValue;
    }
    
    /**
     * Stores the target page slug which will be applied when no page slug is specified.
     * 
     * @since       3.0.0
     * @since       DEVVER      Accepts an array.
     * @since       DEVVER      Moved from `AminPageFramework_FormDefinition`.
     */
    protected $_asTargetSectionID = '_default';    
    
    /*
     * Adds the given field definition array to the form property.
     * 
     * @since       3.0.0
     * @since       DEVVER       Moved from `AminPageFramework_FormDefinition`.
     * @param       array|string            $asFieldset        A field definition array.
     * @return      array|string|null       If the passed field is set, it returns the set field array. If the target section id is set, the set section id is returned. Otherwise null.
     */    
    public function addField( $asFieldset ) {

        // If it is a target section, update the property and return.
        if ( ! $this->_isFieldsetDefinition( $asFieldset ) ) {
            $this->_asTargetSectionID = $this->_getTargetSectionID( $asFieldset );
            return $this->_asTargetSectionID;
        }

        $_aFieldset = $asFieldset;
        
        // Set the target section ID
        $this->_asTargetSectionID = $this->getElement(
            $_aFieldset,  // subject array
            'section_id', // key
            $this->_asTargetSectionID // default
        );                               

        // Required Keys
        if ( ! isset( $_aFieldset[ 'field_id' ], $_aFieldset[ 'type' ] ) ) { 
            return null; 
        }         
                
        // Update the fieldset property
        $this->_setFieldset( $_aFieldset );

        return $_aFieldset;
        
    }    
        /**
         * @return      void
         * @since       DEVVER
         */
        private function _setFieldset( array $aFieldset ) {
            
            // Pre-format
            $aFieldset = array( 
                    '_fields_type'    => $this->aArguments[ 'structure_type' ], // @todo deprecate this item.
                    '_structure_type' => $this->aArguments[ 'structure_type' ],
                )
                + $aFieldset
                + array( 
                    'section_id'      => $this->_asTargetSectionID,
                    'class_name'      => $this->aArguments[ 'caller_id' ], // for backward-compatibility
                )
                // + self::$_aStructure_Field // @deprecated 3.6.0 as the field will be formatted later anyway.
                ;         
        
            // Sanitize the IDs since they are used as a callback method name.
            $aFieldset[ 'field_id' ]     = $this->getIDSanitized( $aFieldset[ 'field_id' ] );
            $aFieldset[ 'section_id' ]   = $this->getIDSanitized( $aFieldset[ 'section_id' ] );
            
            // DEVVER+ A section path (e.g. parent_section|nested_section|more_nested_section) will be stored in the key.
            // Also in the fieldsets dimension, a field path is stored in the key.
            $_aSectionPath    = $this->getAsArray( $aFieldset[ 'section_id' ] );
            $_sSectionPath    = implode( '|', $_aSectionPath );
            
            $_aFieldPath      = $this->getAsArray( $aFieldset[ 'field_id' ] );
            $_sFieldPath      = implode( '|', $_aFieldPath );
            
            $this->aFieldsets[ $_sSectionPath ][ $_sFieldPath ] = $aFieldset;
            
        }

        /**
         * Checks if the given item is a fieldset definition or not.
         * @since       DEVVER
         * @return      boolean
         */
        private function _isFieldsetDefinition( $asFieldset ) {
            
            if ( is_scalar( $asFieldset ) ) {
                return false;
            }
            // if ( ! is_array( $asFieldset ) ) {
                // return false;
            // }
            return $this->isAssociative( $asFieldset );
            
        }
        /**
         * @return      string
         */
        private function _getTargetSectionID( $asTargetSectionID ) {
            
            if ( is_scalar( $asTargetSectionID ) ) {
                return $asTargetSectionID;
            }
            return $asTargetSectionID;
            // return implode( '|', $asTargetSectionID );
            
        }
        
    /**
     * Removes a field definition array from the property array by the given field ID.
     * 
     *  The structure of the aFields property array looks like this:
     *  <code>    array( 
     *          'my_sec_a' => array(
     *              'my_field_a' => array( ... ),
     *              'my_field_b' => array( ... ),
     *              'my_field_c' => array( ... ),
     *          ),
     *          'my_sec_b' => array(
     *              'my_field_a' => array( ... ),
     *              'my_field_b' => array( ... ),
     *              1 => array(
     *                  'my_field_a' => array( ... ),
     *                  'my_field_b' => array( ... ),
     *              )
     *              2 => array(
     *                  'my_field_a' => array( ... ),
     *                  'my_field_b' => array( ... ),
     *              )     
     *          )
     *      )</code>
     * 
     * @since       3.0.0
     * @since       DEVVER       Moved from `AminPageFramework_FormDefinition`.
     */     
    public function removeField( $sFieldID ) {
               
        foreach( $this->aFieldsets as $_sSectionID => $_aSubSectionsOrFields ) {

            if ( array_key_exists( $sFieldID, $_aSubSectionsOrFields ) ) {
                unset( $this->aFieldsets[ $_sSectionID ][ $sFieldID ] );
            }
            
            // Check sub-sections.
            foreach ( $_aSubSectionsOrFields as $_sIndexOrFieldID => $_aSubSectionOrFields ) {
                
                // if it's a sub-section
                if ( $this->isNumericInteger( $_sIndexOrFieldID ) ) {
                    if ( array_key_exists( $sFieldID, $_aSubSectionOrFields ) ) {
                        unset( $this->aFieldsets[ $_sSectionID ][ $_sIndexOrFieldID ] );
                    }
                    continue;
                }
                
            }
        }
        
    }
        
}