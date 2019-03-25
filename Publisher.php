<?php

namespace CatalogManager\Wizards;

class Publisher {


    public function onCreate( $arrData, $objModule ) {

        if ( TL_MODE != 'FE' ) {

            return null;
        }

        if ( !$objModule->catalogUsePublisher || !$arrData['row']['published'] ) {

            return null;
        }

        $arrPublish = [];
        $arrPublishMap = \StringUtil::deserialize( $objModule->catalogPublisherMap, true );

        foreach ( $arrPublishMap as $arrMap ) {

            $arrPublish[ $arrMap['value'] ] = $arrData['row'][ $arrMap['key'] ];
        }

        $arrPublish['rid'] = $arrData['id'];
        $arrPublish['rtable'] = $arrData['table'];
        $arrPublish['tstamp'] = time();

        $this->publish( $arrPublish, $objModule->catalogPublisherTable );
    }


    public function onUpdate( $arrData, $objModule ) {

        if ( TL_MODE != 'FE' ) {

            return null;
        }

        if ( !$objModule->catalogUsePublisher || !$arrData['row']['published'] ) {

            return null;
        }

        $arrPublish = [];
        $arrPublishMap = \StringUtil::deserialize( $objModule->catalogPublisherMap, true );

        foreach ( $arrPublishMap as $arrMap ) {

            $arrPublish[ $arrMap['value'] ] = $arrData['row'][ $arrMap['key'] ];
        }

        $arrPublish['rid'] = $arrData['id'];
        $arrPublish['rtable'] = $arrData['table'];
        $arrPublish['tstamp'] = time();

        $this->publish( $arrPublish, $objModule->catalogPublisherTable );
    }


    public function onDelete( $arrData, $objModule ) {

        if ( TL_MODE != 'FE' ) {

            return null;
        }

        if ( !$objModule->catalogUsePublisher ) {

            return null;
        }

        $objDatabase = \Database::getInstance();
        $objDatabase->prepare( 'DELETE FROM ' . $objModule->catalogPublisherTable . ' WHERE rid = ?' )->execute( $arrData['id'] );
    }


    protected function publish( $arrPublish, $strDestinationTable ) {

        $objDatabase = \Database::getInstance();
        $objEntity = $objDatabase->prepare('SELECT * FROM ' . $strDestinationTable . ' WHERE rid = ?' )->limit(1)->execute( $arrPublish['rid'] );

        if ( !$arrPublish['alias'] ) {

            $arrPublish['alias'] = \CatalogManager\Toolkit::slug( $arrPublish['title'] );
        }

        if ( $objEntity->numRows ) {

            $objDatabase->prepare( 'UPDATE ' . $strDestinationTable . ' %s WHERE rid = ?' )->set( $arrPublish )->execute( $arrPublish['rid'] );
        }

        else {

            $objDatabase->prepare( 'INSERT INTO ' . $strDestinationTable . ' %s' )->set( $arrPublish )->execute();
        }
    }
}