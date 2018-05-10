<?php

namespace CatalogManager\Wizards;

use CatalogManager\Toolkit as Toolkit;

class tl_catalog_wizards extends \Backend {


    public function setBackendList( $arrRow ) {

        return $arrRow['name'];
    }


    public function getTables() {

        return $this->Database->listTables( null );
    }


    public function getFields( \DataContainer $dc ) {

        $strTable = $dc->activeRecord->destinationTable;

        if ( $strTable && $this->Database->tableExists( $strTable ) ) {

            $arrColumns = $this->Database->listFields( $strTable );

            return Toolkit::parseColumns( $arrColumns );
        }

        return [];
    }
}