<?php

$GLOBALS['TL_DCA']['tl_catalog']['config']['ctable'][] = 'tl_catalog_wizards';

array_insert( $GLOBALS['TL_DCA']['tl_catalog']['list']['operations'], 1, [

    'editWizards' => [

        'label' => &$GLOBALS['TL_LANG']['tl_catalog']['editWizards'],
        'href' => 'table=tl_catalog_wizards',
        'icon' => 'edit.gif'
    ],
]);