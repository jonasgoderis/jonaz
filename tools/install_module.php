<?php

/*
 * This is a simple script to install a module from the command-line.
 * Note that options for php 5.3 (longopts) are commented out
 *
 * @author Jelmer Snoeck <jelmer.snoeck@wijs.be>
 * @author Per Juchtmans <per.juchtmans@wijs.be>
 */
// bootstrap Fork
require __DIR__ . '/../autoload.php';
require __DIR__ . '/../app/AppKernel.php';
require __DIR__ . '/../app/KernelLoader.php';
$kernel = new AppKernel();
$loader = new KernelLoader($kernel);
$loader->passContainerToModels();

defined('FRONTEND_LANGUAGE') || define('FRONTEND_LANGUAGE', 'nl');

/**
 * @param string $module
 * @return string
 */
function createModuleName($module)
{
	$name = strtolower($module);
	$name = preg_replace("/[^a-zA-Z0-9_\s]/", "", $name);

	$parts = explode('_', $name);

	// loop trough the parts to ucfirst it
	$newName = '';
	foreach($parts as $part) $newName.= ucfirst($part);

	return $newName;
}

/**
 * Install a specified module.
 *
 * @param string $module
 */
function deltaInstallModule($module)
{
	require_once PATH_WWW . '/backend/modules/' . $module . '/installer/installer.php';

	$moduleName = createModuleName($module);
	$installerClass = $moduleName . 'Installer';

	// go installer, go!  (for nl and fr in this case)
	$installer = new $installerClass(BackendModel::getDB(), array('nl', 'fr'), array('nl', 'fr'));
	$installer->install();
}
