<?php

/**
 * @file classes/plugins/ImportExportPlugin.inc.php
 *
 * Copyright (c) 2014 Simon Fraser University Library
 * Copyright (c) 2003-2014 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ImportExportPlugin
 * @ingroup plugins
 *
 * @brief Abstract class for import/export plugins
 */

import('lib.pkp.classes.plugins.Plugin');

class ImportExportPlugin extends Plugin {
	function ImportExportPlugin() {
		parent::Plugin();
	}

	/**
	 * Get the name of this plugin. The name must be unique within
	 * its category.
	 * @return String name of plugin
	 */
	function getName() {
		assert(false); // Should always be overridden
	}

	/**
	 * Get the display name of this plugin. This name is displayed on the
	 * Journal Manager's import/export page, for example.
	 * @return String
	 */
	function getDisplayName() {
		// This name should never be displayed because child classes
		// will override this method.
		return 'Abstract Import/Export Plugin';
	}

	/**
	 * Get a description of the plugin.
	 */
	function getDescription() {
		return 'This is the ImportExportPlugin base class. Its functions can be overridden by subclasses to provide import/export functionality for various formats.';
	}

	/**
	 * Display the import/export plugin UI.
	 * @param $args array The array of arguments the user supplied.
	 * @param $request Request
	 */
	function display(&$args, $request) {
		$templateManager = TemplateManager::getManager($request);
		$templateManager->register_function('plugin_url', array($this, 'smartyPluginUrl'));
	}

	/**
	 * Execute import/export tasks using the command-line interface.
	 * @param $scriptName The name of the command-line script (displayed as usage info)
	 * @param $args Parameters to the plugin
	 */
	function executeCLI($scriptName, &$args) {
		$this->usage();
		// Implemented by subclasses
	}

	/**
	 * Display the command-line usage information
	 */
	function usage($scriptName) {
		// Implemented by subclasses
	}

	/**
	 * Display verbs for the management interface.
	 */
	function getManagementVerbs() {
		return array(
			array(
				'importexport',
				__('manager.importExport')
			)
		);
	}

 	/**
	 * @see Plugin::manage()
	 */
	function manage($verb, $args, &$message, &$messageParams, &$pluginModalContent = null) {
		$request =& $this->getRequest();
		if ($verb === 'importexport') {
			$request->redirect(null, 'manager', 'importexport', array('plugin', $this->getName()));
		}
		$templateMgr = TemplateManager::getManager($request);
		$templateMgr->register_function('plugin_url', array($this, 'smartyPluginUrl'));
		return false;
	}

	/**
	 * Extend the {url ...} smarty to support import/export plugins.
	 */
	function smartyPluginUrl($params, &$smarty) {
		if (!empty($params['path'])) $path = $params['path'];
		if (!is_array($path)) $path = array($params['path']);

		// Check whether our path points to a management verb.
		$managementVerbs = array();
		foreach($this->getManagementVerbs() as $managementVerb) {
			$managementVerbs[] = $managementVerb[0];
		}
		if (count($path) == 1 && in_array($path[0], $managementVerbs)) {
			// Management verbs will be routed to the plugin's manage method.
			$params['op'] = 'plugin';
			return parent::smartyPluginUrl($params, $smarty);
		} else {
			// All other paths will be routed to the plugin's display method.
			$params['path'] = array_merge(array('plugin', $this->getName()), $path);
			return $smarty->smartyUrl($params, $smarty);
		}
	}
}

?>
