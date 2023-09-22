<?php
/**
 * @package         Modules Anywhere
 * @version         7.5.0
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2018 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

require_once __DIR__ . '/script.install.helper.php';

class PlgEditorsXtdModulesAnywhereInstallerScript extends PlgEditorsXtdModulesAnywhereInstallerScriptHelper
{
	public $name           = 'MODULES_ANYWHERE';
	public $alias          = 'modulesanywhere';
	public $extension_type = 'plugin';
	public $plugin_folder  = 'editors-xtd';

	public function uninstall($adapter)
	{
		$this->uninstallPlugin($this->extname, 'system');
	}
}
