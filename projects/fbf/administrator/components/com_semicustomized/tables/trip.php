<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Semicustomized
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2018 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;
/**
 * trip Table class
 *
 * @since  1.6
 */
class SemicustomizedTabletrip extends JTable
{
	
	/**
	 * Constructor
	 *
	 * @param   JDatabase  &$db  A database connector object
	 */
	public function __construct(&$db)
	{
		JObserverMapper::addObserverClassToClass('JTableObserverContenthistory', 'SemicustomizedTabletrip', array('typeAlias' => 'com_semicustomized.trip'));
		parent::__construct('#__semicustomized_trip', 'id', $db);
        $this->setColumnAlias('published', 'state');
    }

	/**
	 * Overloaded bind function to pre-process the params.
	 *
	 * @param   array  $array   Named array
	 * @param   mixed  $ignore  Optional array or list of parameters to ignore
	 *
	 * @return  null|string  null is operation was satisfactory, otherwise returns an error
	 *
	 * @see     JTable:bind
	 * @since   1.5
	 */
	public function bind($array, $ignore = '')
	{
	    $date = JFactory::getDate();
		$task = JFactory::getApplication()->input->get('task');
	    
		$input = JFactory::getApplication()->input;
		$task = $input->getString('task', '');

		if ($array['id'] == 0 && empty($array['created_by']))
		{
			$array['created_by'] = JFactory::getUser()->id;
		}

		if ($array['id'] == 0 && empty($array['modified_by']))
		{
			$array['modified_by'] = JFactory::getUser()->id;
		}

		if ($task == 'apply' || $task == 'save')
		{
			$array['modified_by'] = JFactory::getUser()->id;
		}
		// Support for multi file field: image
		if (!empty($array['image']))
		{
			if (is_array($array['image']))
			{
				$array['image'] = implode(',', $array['image']);
			}
			elseif (strpos($array['image'], ',') != false)
			{
				$array['image'] = explode(',', $array['image']);
			}
		}
		else
		{
			$array['image'] = '';
		}

		if (!empty($array['images']))
		{
			if (is_array($array['images']))
			{
				$array['images'] = implode(',', $array['images']);
			}
			elseif (strpos($array['images'], ',') != false)
			{
				$array['images'] = explode(',', $array['images']);
			}
		}
		else
		{
			$array['images'] = '';
		}


		// Support for multiple field: carrousselselection
		if (isset($array['carrousselselection']))
		{
			if (is_array($array['carrousselselection']))
			{
				$array['carrousselselection'] = implode(',',$array['carrousselselection']);
			}
			elseif (strpos($array['carrousselselection'], ',') != false)
			{
				$array['carrousselselection'] = explode(',',$array['carrousselselection']);
			}
			elseif (strlen($array['carrousselselection']) == 0)
			{
				$array['carrousselselection'] = '';
			}
		}
		else
		{
			$array['carrousselselection'] = '';
		}

		// Support for multiple field: keeperconsumer
		if (isset($array['keeperconsumer']))
		{
			if (is_array($array['keeperconsumer']))
			{
				$array['keeperconsumer'] = implode(',',$array['keeperconsumer']);
			}
			elseif (strpos($array['keeperconsumer'], ',') != false)
			{
				$array['keeperconsumer'] = explode(',',$array['keeperconsumer']);
			}
			elseif (strlen($array['keeperconsumer']) == 0)
			{
				$array['keeperconsumer'] = '';
			}
		}
		else
		{
			$array['keeperconsumer'] = '';
		}

		// Support for multiple field: nokeeperconsumer
		if (isset($array['nokeeperconsumer']))
		{
			if (is_array($array['nokeeperconsumer']))
			{
				$array['nokeeperconsumer'] = implode(',',$array['nokeeperconsumer']);
			}
			elseif (strpos($array['nokeeperconsumer'], ',') != false)
			{
				$array['nokeeperconsumer'] = explode(',',$array['nokeeperconsumer']);
			}
			elseif (strlen($array['nokeeperconsumer']) == 0)
			{
				$array['nokeeperconsumer'] = '';
			}
		}
		else
		{
			$array['nokeeperconsumer'] = '';
		}

		// Support for multiple field: transportconsumer
		if (isset($array['transportconsumer']))
		{
			if (is_array($array['transportconsumer']))
			{
				$array['transportconsumer'] = implode(',',$array['transportconsumer']);
			}
			elseif (strpos($array['transportconsumer'], ',') != false)
			{
				$array['transportconsumer'] = explode(',',$array['transportconsumer']);
			}
			elseif (strlen($array['transportconsumer']) == 0)
			{
				$array['transportconsumer'] = '';
			}
		}
		else
		{
			$array['transportconsumer'] = '';
		}

		// Support for multiple field: notransportconsumer
		if (isset($array['notransportconsumer']))
		{
			if (is_array($array['notransportconsumer']))
			{
				$array['notransportconsumer'] = implode(',',$array['notransportconsumer']);
			}
			elseif (strpos($array['notransportconsumer'], ',') != false)
			{
				$array['notransportconsumer'] = explode(',',$array['notransportconsumer']);
			}
			elseif (strlen($array['notransportconsumer']) == 0)
			{
				$array['notransportconsumer'] = '';
			}
		}
		else
		{
			$array['notransportconsumer'] = '';
		}

		// Support for multiple field: hotelconsumer
		if (isset($array['hotelconsumer']))
		{
			if (is_array($array['hotelconsumer']))
			{
				$array['hotelconsumer'] = implode(',',$array['hotelconsumer']);
			}
			elseif (strpos($array['hotelconsumer'], ',') != false)
			{
				$array['hotelconsumer'] = explode(',',$array['hotelconsumer']);
			}
			elseif (strlen($array['hotelconsumer']) == 0)
			{
				$array['hotelconsumer'] = '';
			}
		}
		else
		{
			$array['hotelconsumer'] = '';
		}

		// Support for multiple field: nohotelconsumer
		if (isset($array['nohotelconsumer']))
		{
			if (is_array($array['nohotelconsumer']))
			{
				$array['nohotelconsumer'] = implode(',',$array['nohotelconsumer']);
			}
			elseif (strpos($array['nohotelconsumer'], ',') != false)
			{
				$array['nohotelconsumer'] = explode(',',$array['nohotelconsumer']);
			}
			elseif (strlen($array['nohotelconsumer']) == 0)
			{
				$array['nohotelconsumer'] = '';
			}
		}
		else
		{
			$array['nohotelconsumer'] = '';
		}

		// Support for multiple field: planning1
		if (isset($array['planning1']))
		{
			if (is_array($array['planning1']))
			{
				$array['planning1'] = implode(',',$array['planning1']);
			}
			elseif (strpos($array['planning1'], ',') != false)
			{
				$array['planning1'] = explode(',',$array['planning1']);
			}
			elseif (strlen($array['planning1']) == 0)
			{
				$array['planning1'] = '';
			}
		}
		else
		{
			$array['planning1'] = '';
		}

		// Support for multiple field: planning2
		if (isset($array['planning2']))
		{
			if (is_array($array['planning2']))
			{
				$array['planning2'] = implode(',',$array['planning2']);
			}
			elseif (strpos($array['planning2'], ',') != false)
			{
				$array['planning2'] = explode(',',$array['planning2']);
			}
			elseif (strlen($array['planning2']) == 0)
			{
				$array['planning2'] = '';
			}
		}
		else
		{
			$array['planning2'] = '';
		}

		// Support for multiple field: planning3
		if (isset($array['planning3']))
		{
			if (is_array($array['planning3']))
			{
				$array['planning3'] = implode(',',$array['planning3']);
			}
			elseif (strpos($array['planning3'], ',') != false)
			{
				$array['planning3'] = explode(',',$array['planning3']);
			}
			elseif (strlen($array['planning3']) == 0)
			{
				$array['planning3'] = '';
			}
		}
		else
		{
			$array['planning3'] = '';
		}

		// Support for multiple field: planning4
		if (isset($array['planning4']))
		{
			if (is_array($array['planning4']))
			{
				$array['planning4'] = implode(',',$array['planning4']);
			}
			elseif (strpos($array['planning4'], ',') != false)
			{
				$array['planning4'] = explode(',',$array['planning4']);
			}
			elseif (strlen($array['planning4']) == 0)
			{
				$array['planning4'] = '';
			}
		}
		else
		{
			$array['planning4'] = '';
		}

		if (isset($array['params']) && is_array($array['params']))
		{
			$registry = new JRegistry;
			$registry->loadArray($array['params']);
			$array['params'] = (string) $registry;
		}

		if (isset($array['metadata']) && is_array($array['metadata']))
		{
			$registry = new JRegistry;
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string) $registry;
		}

		if (!JFactory::getUser()->authorise('core.admin', 'com_semicustomized.trip.' . $array['id']))
		{
			$actions         = JAccess::getActionsFromFile(
				JPATH_ADMINISTRATOR . '/components/com_semicustomized/access.xml',
				"/access/section[@name='trip']/"
			);
			$default_actions = JAccess::getAssetRules('com_semicustomized.trip.' . $array['id'])->getData();
			$array_jaccess   = array();

			foreach ($actions as $action)
			{
                if (key_exists($action->name, $default_actions))
                {
                    $array_jaccess[$action->name] = $default_actions[$action->name];
                }
			}

			$array['rules'] = $this->JAccessRulestoArray($array_jaccess);
		}

		// Bind the rules for ACL where supported.
		if (isset($array['rules']) && is_array($array['rules']))
		{
			$this->setRules($array['rules']);
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * This function convert an array of JAccessRule objects into an rules array.
	 *
	 * @param   array  $jaccessrules  An array of JAccessRule objects.
	 *
	 * @return  array
	 */
	private function JAccessRulestoArray($jaccessrules)
	{
		$rules = array();

		foreach ($jaccessrules as $action => $jaccess)
		{
			$actions = array();

			if ($jaccess)
			{
				foreach ($jaccess->getData() as $group => $allow)
				{
					$actions[$group] = ((bool)$allow);
				}
			}

			$rules[$action] = $actions;
		}

		return $rules;
	}

	/**
	 * Overloaded check function
	 *
	 * @return bool
	 */
	public function check()
	{
		// If there is an ordering column and this is a new row then get the next ordering value
		if (property_exists($this, 'ordering') && $this->id == 0)
		{
			$this->ordering = self::getNextOrder();
		}
		
		
		// Support multi file field: image
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['image'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = SemicustomizedHelper::getFiles($this->id, $this->_tbl, 'image');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/trip_gallery/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->image = "";

			foreach ($files['image'] as $singleFile )
			{
				jimport('joomla.filesystem.file');

				// Check if the server found any error.
				$fileError = $singleFile['error'];
				$message = '';

				if ($fileError > 0 && $fileError != 4)
				{
					switch ($fileError)
					{
						case 1:
							$message = JText::_('File size exceeds allowed by the server');
							break;
						case 2:
							$message = JText::_('File size exceeds allowed by the html form');
							break;
						case 3:
							$message = JText::_('Partial upload error');
							break;
					}

					if ($message != '')
					{
						$app->enqueueMessage($message, 'warning');

						return false;
					}
				}
				elseif ($fileError == 4)
				{
					if (isset($array['image']))
					{
						$this->image = $array['image'];
					}
				}
				else
				{

					// Replace any special characters in the filename
					jimport('joomla.filesystem.file');
					$filename = JFile::stripExt($singleFile['name']);
					$extension = JFile::getExt($singleFile['name']);
					$filename = preg_replace("/[^A-Za-z0-9]/i", "-", $filename);
					$filename = $filename . '.' . $extension;
					$uploadPath = JPATH_ROOT . '/trip_gallery/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->image .= (!empty($this->image)) ? "," : "";
					$this->image .= $filename;
				}
			}
		}
		else
		{
			$this->image .= $array['image_hidden'];
		}



		if ($files['images'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = SemicustomizedHelper::getFiles($this->id, $this->_tbl, 'images');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/trip_gallery_banner/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->images = "";

			foreach ($files['images'] as $singleFile )
			{
				jimport('joomla.filesystem.file');

				// Check if the server found any error.
				$fileError = $singleFile['error'];
				$message = '';

				if ($fileError > 0 && $fileError != 4)
				{
					switch ($fileError)
					{
						case 1:
							$message = JText::_('File size exceeds allowed by the server');
							break;
						case 2:
							$message = JText::_('File size exceeds allowed by the html form');
							break;
						case 3:
							$message = JText::_('Partial upload error');
							break;
					}

					if ($message != '')
					{
						$app->enqueueMessage($message, 'warning');

						return false;
					}
				}
				elseif ($fileError == 4)
				{
					if (isset($array['images']))
					{
						$this->images = $array['images'];
					}
				}
				else
				{

					// Replace any special characters in the filename
					jimport('joomla.filesystem.file');
					$filename = JFile::stripExt($singleFile['name']);
					$extension = JFile::getExt($singleFile['name']);
					$filename = preg_replace("/[^A-Za-z0-9]/i", "-", $filename);
					$filename = $filename . '.' . $extension;
					$uploadPath = JPATH_ROOT . '/trip_gallery_banner/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->images .= (!empty($this->images)) ? "," : "";
					$this->images .= $filename;
				}
			}
		}
		else
		{
			$this->images .= $array['images_hidden'];
		}

		return parent::check();
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param   mixed    $pks     An optional array of primary key values to update.  If not
	 *                            set the instance property value is used.
	 * @param   integer  $state   The publishing state. eg. [0 = unpublished, 1 = published]
	 * @param   integer  $userId  The user id of the user performing the operation.
	 *
	 * @return   boolean  True on success.
	 *
	 * @since    1.0.4
	 *
	 * @throws Exception
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		ArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k)
			{
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else
			{
				throw new Exception(500, JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
			}
		}

		// Build the WHERE clause for the primary keys.
		$where = $k . '=' . implode(' OR ' . $k . '=', $pks);

		// Determine if there is checkin support for the table.
		if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time'))
		{
			$checkin = '';
		}
		else
		{
			$checkin = ' AND (checked_out = 0 OR checked_out = ' . (int) $userId . ')';
		}

		// Update the publishing state for rows with the given primary keys.
		$this->_db->setQuery(
			'UPDATE `' . $this->_tbl . '`' .
			' SET `state` = ' . (int) $state .
			' WHERE (' . $where . ')' .
			$checkin
		);
		$this->_db->execute();

		// If checkin is supported and all rows were adjusted, check them in.
		if ($checkin && (count($pks) == $this->_db->getAffectedRows()))
		{
			// Checkin each row.
			foreach ($pks as $pk)
			{
				$this->checkin($pk);
			}
		}

		// If the JTable instance value is in the list of primary keys that were set, set the instance.
		if (in_array($this->$k, $pks))
		{
			$this->state = $state;
		}

		return true;
	}

	/**
	 * Define a namespaced asset name for inclusion in the #__assets table
	 *
	 * @return string The asset name
	 *
	 * @see JTable::_getAssetName
	 */
	protected function _getAssetName()
	{
		$k = $this->_tbl_key;

		return 'com_semicustomized.trip.' . (int) $this->$k;
	}

	/**
	 * Returns the parent asset's id. If you have a tree structure, retrieve the parent's id using the external key field
	 *
	 * @param   JTable   $table  Table name
	 * @param   integer  $id     Id
	 *
	 * @see JTable::_getAssetParentId
	 *
	 * @return mixed The id on success, false on failure.
	 */
	protected function _getAssetParentId(JTable $table = null, $id = null)
	{
		// We will retrieve the parent-asset from the Asset-table
		$assetParent = JTable::getInstance('Asset');

		// Default: if no asset-parent can be found we take the global asset
		$assetParentId = $assetParent->getRootId();

		// The item has the component as asset-parent
		$assetParent->loadByName('com_semicustomized');

		// Return the found asset-parent-id
		if ($assetParent->id)
		{
			$assetParentId = $assetParent->id;
		}

		return $assetParentId;
	}

	/**
	 * Delete a record by id
	 *
	 * @param   mixed  $pk  Primary key value to delete. Optional
	 *
	 * @return bool
	 */
	public function delete($pk = null)
	{
		$this->load($pk);
		$result = parent::delete($pk);
		
		if ($result)
		{
			jimport('joomla.filesystem.file');

			foreach ($this->image as $imageFile)
			{
				JFile::delete(JPATH_ROOT . '/trip_gallery/' . $imageFile);
			}
			foreach ($this->images as $imagesFile)
			{
				JFile::delete(JPATH_ROOT . '/trip_gallery_banner/' . $imageFile);
			}
		}

		return $result;
	}
}
