<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Customer_rev1ews
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2019 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Rev1ew controller class.
 *
 * @since  1.6
 */
class Customer_rev1ewsControllerRev1ew extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'rev1ews';
		parent::__construct();
	}
}
