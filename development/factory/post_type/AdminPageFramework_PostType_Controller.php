<?php
/**
 * Admin Page Framework
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2013-2015 Michael Uno; Licensed MIT
 * 
 */

/**
 * Provides methods of views for the post type factory class.
 * 
 * Those methods are public and provides means for users to set property values.
 * 
 * @abstract
 * @since       3.0.4
 * @package     AdminPageFramework
 * @subpackage  PostType
 */
abstract class AdminPageFramework_PostType_Controller extends AdminPageFramework_PostType_View {    

    /**
     * Sets up hooks and properties.
     * 
     * @internal
     * @remark      Make sure to call the parent construct first as the factory router need to set up sub-class objects.
     */
    public function __construct( $oProp ) {
                
        parent::__construct( $oProp );
        
        // 3.4.2+ Changed the hook to init from wp_loaded.
        // 3.5.1+ Moved to after the constructor.
        $this->oUtil->registerAction( 'init', array( $this, 'setup_pre' ) );
        
    }

    /**
    * The method for necessary set-ups.
    * 
    * <h4>Example</h4>
    * <code>public function setUp() {
    *         $this->setAutoSave( false );
    *         $this->setAuthorTableFilter( true );
    *         $this->addTaxonomy( 
    *             'sample_taxonomy', // taxonomy slug
    *             array( // argument - for the argument array keys, refer to : http://codex.wordpress.org/Function_Reference/register_taxonomy#Arguments
    *                 'labels'              => array(
    *                     'name'            => 'Genre',
    *                     'add_new_item'    => 'Add New Genre',
    *                     'new_item_name'   => "New Genre"
    *                 ),
    *                 'show_ui'                 => true,
    *                 'show_tagcloud'           => false,
    *                 'hierarchical'            => true,
    *                 'show_admin_column'       => true,
    *                 'show_in_nav_menus'       => true,
    *                 'show_table_filter'       => true, // framework specific key
    *                 'show_in_sidebar_menus'   => false, // framework specific key
    *             )
    *         );
    *     }</code>
    * 
    * @abstract
    * @since        2.0.0
    * @remark       The user should override this method in their class definition.
    * @remark       A callback for the `wp_loaded` hook.
    */
    public function setUp() {}    
        
    /*
     * Head Tag Methods
     */
    /**
     * {@inheritdoc}
     * 
     * {@inheritdoc}
     * 
     * @since       3.0.0
     * @return      array       An array holding the handle IDs of queued items.
     */
    public function enqueueStyles( $aSRCs, $aCustomArgs=array() ) {     
        if ( method_exists( $this->oResource, '_enqueueStyles' ) ) {
            return $this->oResource->_enqueueStyles( $aSRCs, array( $this->oProp->sPostType ), $aCustomArgs );
        }
    }
    /**
     * {@inheritdoc}
     * 
     * {@inheritdoc}
     * 
     */    
    public function enqueueStyle( $sSRC, $aCustomArgs=array() ) {
        if ( method_exists( $this->oResource, '_enqueueStyle' ) ) {
            return $this->oResource->_enqueueStyle( $sSRC, array( $this->oProp->sPostType ), $aCustomArgs );     
        }
    }
    /**
     * {@inheritdoc}
     * 
     * {@inheritdoc}
     * 
     * @return      array       An array holding the handle IDs of queued items.
     */
    public function enqueueScripts( $aSRCs, $aCustomArgs=array() ) {
        if ( method_exists( $this->oResource, '_enqueueScripts' ) ) {
            return $this->oResource->_enqueueScripts( $aSRCs, array( $this->oProp->sPostType ), $aCustomArgs );
        }
    }    
    /**
     * {@inheritdoc}
     * 
     * {@inheritdoc}
     *  
     * @since       3.0.0
     */
    public function enqueueScript( $sSRC, $aCustomArgs=array() ) {    
        if ( method_exists( $this->oResource, '_enqueueScript' ) ) {
            return $this->oResource->_enqueueScript( $sSRC, array( $this->oProp->sPostType ), $aCustomArgs );
        }
    }     
    
    /*
     * Front-end methods
     */
    /**
    * Enables or disables the auto-save feature in the custom post type's post submission page.
    * 
    * <h4>Example</h4>
    * <code>$this->setAutoSave( false );
    * </code>
    * 
    * @since        2.0.0
    * @param        boolean         If true, it enables the auto-save; otherwise, it disables it.
    * return        void
    */ 
    protected function setAutoSave( $bEnableAutoSave=True ) {
        $this->oProp->bEnableAutoSave = $bEnableAutoSave;     
    }
    
    /**
    * Adds a custom taxonomy to the class post type.
    * <h4>Example</h4>
    * <code>$this->addTaxonomy( 
    *   'sample_taxonomy', // taxonomy slug
    *   array( // argument
    *       'labels'        => array(
    *       'name'          => 'Genre',
    *       'add_new_item'  => 'Add New Genre',
    *       'new_item_name' => "New Genre"
    *   ),
    *   'show_ui'               => true,
    *   'show_tagcloud'         => false,
    *   'hierarchical'          => true,
    *   'show_admin_column'     => true,
    *   'show_in_nav_menus'     => true,
    *   'show_table_filter'     => true,  // framework specific key
    *   'show_in_sidebar_menus' => false, // framework specific key
    *   )
    * );</code>
    * 
    * @see      http://codex.wordpress.org/Function_Reference/register_taxonomy#Arguments
    * @since    2.0.0
    * @since    3.1.1       Added the third parameter.
    * @param    string      $sTaxonomySlug              The taxonomy slug.
    * @param    array       $aArgs                      The taxonomy argument array passed to the second parameter of the <a href="http://codex.wordpress.org/Function_Reference/register_taxonomy#Arguments">register_taxonomy()</a> function.
    * @param    array       $aAdditionalObjectTypes     Additional object types (post types) besides the caller post type.
    * @return   void
    */ 
    protected function addTaxonomy( $sTaxonomySlug, array $aArgs, array $aAdditionalObjectTypes=array() ) {

        $sTaxonomySlug  = $this->oUtil->sanitizeSlug( $sTaxonomySlug );
        $aArgs          = $aArgs + array(
            'show_table_filter'     => null,
            'show_in_sidebar_menus' => null,
        ) ;
        $this->oProp->aTaxonomies[ $sTaxonomySlug ] = $aArgs;
        
        if ( $aArgs['show_table_filter'] ) {
            $this->oProp->aTaxonomyTableFilters[] = $sTaxonomySlug;
        }
        if ( ! $aArgs['show_in_sidebar_menus'] ) {
            $this->oProp->aTaxonomyRemoveSubmenuPages[ "edit-tags.php?taxonomy={$sTaxonomySlug}&amp;post_type={$this->oProp->sPostType}" ] = "edit.php?post_type={$this->oProp->sPostType}";
        }

        $_aExistingObjectTypes = $this->oUtil->getElementAsArray(
            $this->oProp->aTaxonomyObjectTypes,
            $sTaxonomySlug,
            array()
        );
        
        $aAdditionalObjectTypes = array_merge( $_aExistingObjectTypes, $aAdditionalObjectTypes );
        $this->oProp->aTaxonomyObjectTypes[ $sTaxonomySlug ] = array_unique( $aAdditionalObjectTypes );

        // Set up hooks. If the 'init' hook is already done, register it now.
        $this->_addTaxonomy_setUpHooks( 
            $sTaxonomySlug, 
            $aArgs,
            $aAdditionalObjectTypes
        );

    }    
        /**
         * Sets up hooks for adding taxonomies.
         * 
         * @remark      assumes to be called from the `addTaxonomy()` method.
         * @since       3.5.3
         * @return      void
         * @internal
         */
        private function _addTaxonomy_setUpHooks( $sTaxonomySlug, array $aArgs, array $aAdditionalObjectTypes ) {
                
            if ( did_action( 'init' ) ) {
                $this->_registerTaxonomy( $sTaxonomySlug, $aAdditionalObjectTypes, $aArgs );
            } else {
                if ( 1 == count( $this->oProp->aTaxonomies ) ) {
                    add_action( 'init', array( $this, '_replyToRegisterTaxonomies' ) ); // the hook should not be admin_init because taxonomies need to be accessed in regular pages.
                }
            }
            
            if ( did_action( 'admin_menu' ) ) {
                $this->_replyToRemoveTexonomySubmenuPages();
            } else {
                if ( 1 == count( $this->oProp->aTaxonomyRemoveSubmenuPages ) ) {
                    add_action( 'admin_menu', array( $this, '_replyToRemoveTexonomySubmenuPages' ), 999 ); 
                }
            } 
            
        }

    /**
    * Sets whether the author drop-down filter is enabled/disabled in the post type post list table.
    * 
    * <h4>Example</h4>
    * <code>$this->setAuthorTableFilter( true );
    * </code>
    * 
    * @since        2.0.0
    * @param        boolean     $bEnableAuthorTableFileter      If true, it enables the author filter; otherwise, it disables it.
    * @return       void
    */ 
    protected function setAuthorTableFilter( $bEnableAuthorTableFileter=false ) {
        $this->oProp->bEnableAuthorTableFileter = $bEnableAuthorTableFileter;
    }
    
    /**
     * Sets the post type arguments.
     * 
     * This is only necessary if it is not set in the constructor.
     * 
     * @since           2.0.0
     * @deprecated      3.2.0           Use the setArguments() method instead.
     * @return          void
     */ 
    protected function setPostTypeArgs( $aArgs ) {
        $this->setArguments( ( array ) $aArgs );
    }
    
    /**
     * Sets the post type arguments.
     * 
     * @remark      The alias of `setPostTypeArgs()`.
     * @see         http://codex.wordpress.org/Function_Reference/register_post_type#Arguments
     * @param       array       $aArguments     The <a href="http://codex.wordpress.org/Function_Reference/register_post_type#Arguments">array of arguments</a> to be passed to the second parameter of the `register_post_type()` function.
     * @since       3.2.0
     */
    protected function setArguments( array $aArguments=array() ) {
        $this->oProp->aPostTypeArgs = $aArguments;
    }

}