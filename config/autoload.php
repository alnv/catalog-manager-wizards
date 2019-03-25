<?php

ClassLoader::addNamespace( 'CatalogManager\Wizards' );

ClassLoader::addClasses([

    'CatalogManager\Wizards\Publisher' => 'system/modules/catalog-manager-wizards/Publisher.php',
    'CatalogManager\Wizards\AutoFieldWizard' => 'system/modules/catalog-manager-wizards/AutoFieldWizard.php',
    'CatalogManager\Wizards\BackendWizardCallbacks' => 'system/modules/catalog-manager-wizards/BackendWizardCallbacks.php',
    'CatalogManager\Wizards\tl_catalog_wizards' => 'system/modules/catalog-manager-wizards/classes/tl_catalog_wizards.php'
]);