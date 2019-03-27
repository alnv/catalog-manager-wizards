<?php

namespace CatalogManager\Wizards;

class Publisher extends \Frontend {


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

            if ( \CatalogManager\Toolkit::isEmpty( $arrData['row'][ $arrMap['key'] ] ) ) {

                continue;
            }

            $arrPublish[ $arrMap['value'] ] = $arrData['row'][ $arrMap['key'] ];
        }

        $arrPublish['rid'] = $arrData['row']['id'];
        $arrPublish['rtable'] = $arrData['table'];
        $arrPublish['tstamp'] = time();

        $this->publish( $arrPublish, $objModule->catalogPublisherTable );
    }


    public function onUpdate( $arrData, $objModule ) {

        if ( TL_MODE != 'FE' ) {

            return null;
        }

        if ( !$objModule->catalogUsePublisher ) {

            return null;
        }

        if ( !$arrData['row']['published'] ) {

            $this->onDelete( $arrData, $objModule );

            return null;
        }

        $arrPublish = [];
        $arrPublishMap = \StringUtil::deserialize( $objModule->catalogPublisherMap, true );

        foreach ( $arrPublishMap as $arrMap ) {

            if ( \CatalogManager\Toolkit::isEmpty( $arrData['row'][ $arrMap['key'] ] ) ) {

                continue;
            }

            $arrPublish[ $arrMap['value'] ] = $arrData['row'][ $arrMap['key'] ];
        }

        $arrPublish['rid'] = $arrData['row']['id'];
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

        $this->Database->prepare( 'DELETE FROM ' . $objModule->catalogPublisherTable . ' WHERE rid = ?' )->execute( $arrData['id'] );
    }


    protected function publish( $arrPublish, $strDestinationTable ) {

        $objEntity = $this->Database->prepare('SELECT * FROM ' . $strDestinationTable . ' WHERE rid = ?' )->limit(1)->execute( $arrPublish['rid'] );

        if ( !$arrPublish['alias'] ) {

            $arrPublish['alias'] = \CatalogManager\Toolkit::slug( $arrPublish['title'] );
        }

        if ( $objEntity->numRows ) {

            $this->Database->prepare( 'UPDATE ' . $strDestinationTable . ' %s WHERE rid = ?' )->set( $arrPublish )->execute( $arrPublish['rid'] );
        }

        else {

            $this->Database->prepare( 'INSERT INTO ' . $strDestinationTable . ' %s' )->set( $arrPublish )->execute();
        }
    }
}