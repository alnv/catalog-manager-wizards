<?php

namespace CatalogManager\Wizards;

use CatalogManager\Toolkit as Toolkit;
use CatalogManager\CatalogController as CatalogController;
use CatalogManager\CatalogFieldBuilder as CatalogFieldBuilder;


class AutoFieldWizard extends CatalogController {


    public function callFromBackend( \DataContainer $objDc ) {

        if ( !$objDc->id || !$objDc->activeRecord || !is_array( $objDc->activeRecord->row() ) ) return null;
        if ( !is_array( $GLOBALS['CATALOG_MANAGER_WIZARDS'] ) || !isset( $GLOBALS['CATALOG_MANAGER_WIZARDS'][ $objDc->table ] ) ) return null;

        if ( Toolkit::isEmpty( $GLOBALS['CATALOG_MANAGER_WIZARDS'][ $objDc->table ]['destinationTable'] ) ) return null;
        if ( Toolkit::isEmpty( $GLOBALS['CATALOG_MANAGER_WIZARDS'][ $objDc->table ]['destinationField'] ) ) return null;
        if ( Toolkit::isEmpty( $GLOBALS['CATALOG_MANAGER_WIZARDS'][ $objDc->table ]['template'] ) ) return null;

        $this->import( 'Database' );

        $strValue = $this->render( $objDc->activeRecord->row(), $objDc->table, $GLOBALS['CATALOG_MANAGER_WIZARDS'][ $objDc->table ] );

        $arrSet = [];
        $arrSet[ $GLOBALS['CATALOG_MANAGER_WIZARDS'][ $objDc->table ]['destinationField'] ] = $strValue;

        $this->Database
            ->prepare( 'UPDATE ' . $GLOBALS['CATALOG_MANAGER_WIZARDS'][ $objDc->table ]['destinationTable'] .' %s WHERE id = ?' )
            ->set( $arrSet )
            ->execute( $objDc->id );
    }


    public function callFromFrontend( $arrValues, $strAct, $arrCatalog ) {

        $this->import( 'Database' );

        if ( !$this->Database->tableExists( 'tl_catalog_wizards' ) ) return $arrValues;

        $objWizards = $this->Database
            ->prepare( 'SELECT * FROM tl_catalog_wizards WHERE `executeTable` = ?' )
            ->execute( $arrCatalog['tablename'] );

        if ( !$objWizards->numRows ) return $arrValues;

        $arrWizard = $objWizards->row();
        $arrValues[ $arrWizard['destinationField'] ] = $this->render( $arrValues, $arrCatalog['tablename'], $arrWizard );

        return $arrValues;
    }


    protected function render( $arrValues, $strExecuteTable, $arrOptions = [] ) {

        $arrRows = Toolkit::prepareValues4Db( $arrValues );

        $objFields = new CatalogFieldBuilder();
        $objFields->initialize( $strExecuteTable );
        $arrFields = $objFields->getCatalogFields( false );
        $arrParsedRows = Toolkit::parseCatalogValues( $arrRows, $arrFields, true );

        if ( is_array( $arrParsedRows ) && !empty( $arrParsedRows ) ) {

            foreach ( $arrParsedRows as $strField => $strValue ) {

                $arrRows[ $strField . '_parsed' ] = $strValue;
            }
        }

        $strValue = \StringUtil::parseSimpleTokens( $arrOptions['template'], $arrRows );

        if ( $arrOptions['isAlias'] ) {

            $strValue = str_replace(',', '-', $strValue );
            $strValue = \StringUtil::generateAlias( $strValue );
        }

        return $strValue;
    }
}