<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Fixed_orders
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2019 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Bcorders list controller class.
 *
 * @since  1.6
 */
class Fixed_ordersControllerBcorders extends Fixed_ordersController
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional
	 * @param   array   $config  Configuration array for model. Optional
	 *
	 * @return object	The model
	 *
	 * @since	1.6
	 */
	public function &getModel($name = 'Bcorders', $prefix = 'Fixed_ordersModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
}
