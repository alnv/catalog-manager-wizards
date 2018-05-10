<?php

$GLOBALS['CATALOG_MANAGER_WIZARDS'] = [];

$GLOBALS['BE_MOD']['catalog-manager-extensions']['catalog-manager']['tables'][] = 'tl_catalog_wizards';

$GLOBALS['TL_HOOKS']['loadDataContainer'][] = [ 'CatalogManager\Wizards\BackendWizardCallbacks', 'setFieldWizardCallbacks' ];
$GLOBALS['TL_HOOKS']['catalogManagerFrontendEditingOnSave'][] = [ 'CatalogManager\Wizards\AutoFieldWizard', 'callFromFrontend' ];