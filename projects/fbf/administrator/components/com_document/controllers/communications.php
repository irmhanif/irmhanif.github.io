<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Document
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2019 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

use Joomla\Utilities\ArrayHelper;

/**
 * Communications list controller class.
 *
 * @since  1.6
 */
class DocumentControllerCommunications extends JControllerAdmin
{
	/**
	 * Method to clone existing Communications
	 *
	 * @return void
	 */
	public function duplicate()
	{
		// Check for request forgeries
		Jsession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Get id(s)
		$pks = $this->input->post->get('cid', array(), 'array');

		try
		{
			if (empty($pks))
			{
				throw new Exception(JText::_('COM_DOCUMENT_NO_ELEMENT_SELECTED'));
			}

			ArrayHelper::toInteger($pks);
			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(Jtext::_('COM_DOCUMENT_ITEMS_SUCCESS_DUPLICATED'));
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'warning');
		}

		$this->setRedirect('index.php?option=com_document&view=communications');
	}

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    Optional. Model name
	 * @param   string  $prefix  Optional. Class prefix
	 * @param   array   $config  Optional. Configuration array for model
	 *
	 * @return  object	The Model
	 *
	 * @since    1.6
	 */
	public function getModel($name = 'communication', $prefix = 'DocumentModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}

	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function saveOrderAjax()
	{
		// Get the input
		$input = JFactory::getApplication()->input;
		$pks   = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');

		// Sanitize the input
		ArrayHelper::toInteger($pks);
		ArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return)
		{
			echo "1";
		}

		// Close the application
		JFactory::getApplication()->close();
	}
	public function documentUpdate() {
		$db=JFactory::getDbo();
		$user_id = JRequest::getvar('uid','');

		/* Get  order details for customized*/
	    $Customized="SELECT COUNT(id) FROM `#__customized_order` WHERE uid=$user_id";
	    $db->setQuery($Customized);
	    $customized_count=$db->loadResult();

	    if($customized_count!=0) {
		    $getorderdetails="SELECT * FROM `#__customized_order` WHERE uid=$user_id";
		    $db->setQuery($getorderdetails);
		    $orderdetail=$db->loadObjectList();
		    $q=0;
			echo '<optgroup label="Customized">';
			echo '<option value="">Select Quote</option>';
		    foreach($orderdetail as $order_res) {
		    	 $q++;
		    	 $order_id=$order_res->id;
		    	 echo '<option value="c-'.$order_id.'">Quote - '.$q.'</option>';
		    }
	    }
	    $semicustomized_order="SELECT COUNT(id) FROM `#__semicustomized_order` WHERE uid=$user_id";
	    $db->setQuery($semicustomized_order);
	    $semicustomized_order_count=$db->loadResult();

		if($semicustomized_order_count!=0) {
			$getorderdetails2="SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND ( (payment_status='finalizebyuser') || (payment_status='first_installment') || (payment_status='final_installment')) AND id IN (SELECT MAX(id) FROM `#__semicustomized_order` WHERE uid=$user_id GROUP BY quote_status)";
		    $db->setQuery($getorderdetails2);
		    $orderdetail2=$db->loadObjectList();
		    echo '<optgroup label="Semi_Customized">';
		    	echo '<option value="">Select Quote</option>';
		    $q=0;
		    foreach($orderdetail2 as $order_res2) {
		    	$q++;
		    	$order_id2=$order_res2->id;
		    	$quote_status=$order_res2->quote_status;
		    	echo '<option value="s-'.$order_id2.'">Quote - '.$q.'</option>';
		    }
		}

	    $fixed_trip_orders="SELECT COUNT(id)  FROM `#__fixed_trip_orders` WHERE uid=$user_id";
        $db->setQuery($fixed_trip_orders);
        $fixed_trip_orders_count=$db->loadResult();

		if($fixed_trip_orders_count!=0) {
			$getorderdetails3="SELECT *  FROM `#__fixed_trip_orders` WHERE uid=$user_id";
	        $db->setQuery($getorderdetails3);
	        $orderdetail3=$db->loadObjectList();
	        $q=0;
	          echo '<optgroup label="Fixed">';
	          	echo '<option value="">Select Quote</option>';
	        foreach($orderdetail3 as $order_res3) {
	        	$q++;
		    	$order_id3=$order_res3->id;
		    	echo '<option value="f-'.$order_id3.'">Quote - '.$q.'</option>';
		    }
		}
		exit;
	}
}
