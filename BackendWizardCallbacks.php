<?php

namespace CatalogManager\Wizards;

class BackendWizardCallbacks extends \Backend {


    public function setFieldWizardCallbacks( $strTable ) {

        if ( !$this->Database->tableExists( 'tl_catalog_wizards' ) ) return null;

        $objWizards = $this->Database
            ->prepare( 'SELECT * FROM tl_catalog_wizards WHERE `executeTable` = ?' )
            ->execute( $strTable );

        if ( !$objWizards->numRows ) return null;
        if ( !isset( $GLOBALS['TL_DCA'][ $strTable ] ) ) return null;

        $GLOBALS['CATALOG_MANAGER_WIZARDS'][ $strTable ] = $objWizards->row();

        $GLOBALS['TL_DCA'][ $strTable ]['config']['onsubmit_callback'][] = [ 'CatalogManager\Wizards\AutoFieldWizard', 'callFromBackend' ];
    }
}