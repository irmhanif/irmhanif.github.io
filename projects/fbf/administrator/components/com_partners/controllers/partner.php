<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Partners
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2019 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Partner controller class.
 *
 * @since  1.6
 */
class PartnersControllerPartner extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'partners';
		parent::__construct();
	}
}
