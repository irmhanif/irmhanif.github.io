<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Customized_trip
 * @author     vikram <vikram.zinavo@gmail.com>
 * @copyright  2018 vikram
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Place controller class.
 *
 * @since  1.6
 */
class Customized_tripControllerPlace extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'places';
		parent::__construct();
	}
}
