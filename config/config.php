<?php

$GLOBALS['CATALOG_MANAGER_WIZARDS'] = [];

$GLOBALS['BE_MOD']['catalog-manager-extensions']['catalog-manager']['tables'][] = 'tl_catalog_wizards';

$GLOBALS['TL_HOOKS']['loadDataContainer'][] = [ 'CatalogManager\Wizards\BackendWizardCallbacks', 'setFieldWizardCallbacks' ];
$GLOBALS['TL_HOOKS']['catalogManagerFrontendEditingOnSave'][] = [ 'CatalogManager\Wizards\AutoFieldWizard', 'callFromFrontend' ];

$GLOBALS['TL_HOOKS']['catalogManagerEntityOnCreate'][] = [ 'CatalogManager\Wizards\Publisher', 'onCreate' ];
$GLOBALS['TL_HOOKS']['catalogManagerEntityOnUpdate'][] = [ 'CatalogManager\Wizards\Publisher', 'onUpdate' ];
$GLOBALS['TL_HOOKS']['catalogManagerEntityOnDelete'][] = [ 'CatalogManager\Wizards\Publisher', 'onDelete' ];