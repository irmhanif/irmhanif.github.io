<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Media_coverage
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2019 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Coverage controller class.
 *
 * @since  1.6
 */
class Media_coverageControllerCoverage extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'coverages';
		parent::__construct();
	}
}
