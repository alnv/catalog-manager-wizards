<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'catalogUsePublisher';
$GLOBALS['TL_DCA']['tl_module']['palettes']['catalogUniversalView'] = str_replace( 'catalogUseFrontendEditingViewPage;', 'catalogUseFrontendEditingViewPage,catalogUsePublisher;', $GLOBALS['TL_DCA']['tl_module']['palettes']['catalogUniversalView'] );
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['catalogUsePublisher'] = 'catalogPublisherTable,catalogPublisherMap';

$GLOBALS['TL_DCA']['tl_module']['fields']['catalogUsePublisher'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['catalogUsePublisher'],
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'clr',
    ],
    'exclude' => true,
    'sql' => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['catalogPublisherTable'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['catalogPublisherTable'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 128,
        'tl_class' => 'w50',
        'mandatory' => true
    ],
    'exclude' => true,
    'sql' => "varchar(128) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_module']['fields']['catalogPublisherMap'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['catalogPublisherMap'],
    'inputType' => 'keyValueWizard',
    'eval' => [
        'mandatory' => true,
        'tl_class' => 'clr',
    ],
    'exclude' => true,
    'sql' => "blob NULL"
];