<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Fixed_trip
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;
/**
 * create_trip Table class
 *
 * @since  1.6
 */
class Fixed_tripTablecreate_trip extends JTable
{
	
	/**
	 * Constructor
	 *
	 * @param   JDatabase  &$db  A database connector object
	 */
	public function __construct(&$db)
	{
		JObserverMapper::addObserverClassToClass('JTableObserverContenthistory', 'Fixed_tripTablecreate_trip', array('typeAlias' => 'com_fixed_trip.create_trip'));
		parent::__construct('#__create_trip', 'id', $db);
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

		// Support for multiple field: type
		if (isset($array['type']))
		{
			if (is_array($array['type']))
			{
				$array['type'] = implode(',',$array['type']);
			}
			elseif (strpos($array['type'], ',') != false)
			{
				$array['type'] = explode(',',$array['type']);
			}
			elseif (strlen($array['type']) == 0)
			{
				$array['type'] = '';
			}
		}
		else
		{
			$array['type'] = '';
		}
		// Support for multi file field: pdfplanning1
		if (!empty($array['pdfplanning1']))
		{
			if (is_array($array['pdfplanning1']))
			{
				$array['pdfplanning1'] = implode(',', $array['pdfplanning1']);
			}
			elseif (strpos($array['pdfplanning1'], ',') != false)
			{
				$array['pdfplanning1'] = explode(',', $array['pdfplanning1']);
			}
		}
		else
		{
			$array['pdfplanning1'] = '';
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
		// Support for multi file field: pdfplanning2
		if (!empty($array['pdfplanning2']))
		{
			if (is_array($array['pdfplanning2']))
			{
				$array['pdfplanning2'] = implode(',', $array['pdfplanning2']);
			}
			elseif (strpos($array['pdfplanning2'], ',') != false)
			{
				$array['pdfplanning2'] = explode(',', $array['pdfplanning2']);
			}
		}
		else
		{
			$array['pdfplanning2'] = '';
		}

		// Support for multi file field: pdfplanning3
		if (!empty($array['pdfplanning3']))
		{
			if (is_array($array['pdfplanning3']))
			{
				$array['pdfplanning3'] = implode(',', $array['pdfplanning3']);
			}
			elseif (strpos($array['pdfplanning3'], ',') != false)
			{
				$array['pdfplanning3'] = explode(',', $array['pdfplanning3']);
			}
		}
		else
		{
			$array['pdfplanning3'] = '';
		}

		// Support for multi file field: pdfplanning4
		if (!empty($array['pdfplanning4']))
		{
			if (is_array($array['pdfplanning4']))
			{
				$array['pdfplanning4'] = implode(',', $array['pdfplanning4']);
			}
			elseif (strpos($array['pdfplanning4'], ',') != false)
			{
				$array['pdfplanning4'] = explode(',', $array['pdfplanning4']);
			}
		}
		else
		{
			$array['pdfplanning4'] = '';
		}

		// Support for multi file field: pdfplanning5
		if (!empty($array['pdfplanning5']))
		{
			if (is_array($array['pdfplanning5']))
			{
				$array['pdfplanning5'] = implode(',', $array['pdfplanning5']);
			}
			elseif (strpos($array['pdfplanning5'], ',') != false)
			{
				$array['pdfplanning5'] = explode(',', $array['pdfplanning5']);
			}
		}
		else
		{
			$array['pdfplanning5'] = '';
		}

		// Support for multi file field: pdfplanning6
		if (!empty($array['pdfplanning6']))
		{
			if (is_array($array['pdfplanning6']))
			{
				$array['pdfplanning6'] = implode(',', $array['pdfplanning6']);
			}
			elseif (strpos($array['pdfplanning6'], ',') != false)
			{
				$array['pdfplanning6'] = explode(',', $array['pdfplanning6']);
			}
		}
		else
		{
			$array['pdfplanning6'] = '';
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

		if (!JFactory::getUser()->authorise('core.admin', 'com_fixed_trip.create_trip.' . $array['id']))
		{
			$actions         = JAccess::getActionsFromFile(
				JPATH_ADMINISTRATOR . '/components/com_fixed_trip/access.xml',
				"/access/section[@name='create_trip']/"
			);
			$default_actions = JAccess::getAssetRules('com_fixed_trip.create_trip.' . $array['id'])->getData();
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
		
		
		// Support multi file field: pdfplanning1
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['pdfplanning1'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = Fixed_tripHelper::getFiles($this->id, $this->_tbl, 'pdfplanning1');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/Fixed_Planning_pdf/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->pdfplanning1 = "";

			foreach ($files['pdfplanning1'] as $singleFile )
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
					if (isset($array['pdfplanning1']))
					{
						$this->pdfplanning1 = $array['pdfplanning1'];
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
					$uploadPath = JPATH_ROOT . '/Fixed_Planning_pdf/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->pdfplanning1 .= (!empty($this->pdfplanning1)) ? "," : "";
					$this->pdfplanning1 .= $filename;
				}
			}
		}
		else
		{
			$this->pdfplanning1 .= $array['pdfplanning1_hidden'];
		}
		// Support multi file field: pdfplanning2
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['pdfplanning2'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = Fixed_tripHelper::getFiles($this->id, $this->_tbl, 'pdfplanning2');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/Fixed_Planning_pdf/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->pdfplanning2 = "";

			foreach ($files['pdfplanning2'] as $singleFile )
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
					if (isset($array['pdfplanning2']))
					{
						$this->pdfplanning2 = $array['pdfplanning2'];
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
					$uploadPath = JPATH_ROOT . '/Fixed_Planning_pdf/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->pdfplanning2 .= (!empty($this->pdfplanning2)) ? "," : "";
					$this->pdfplanning2 .= $filename;
				}
			}
		}
		else
		{
			$this->pdfplanning2 .= $array['pdfplanning2_hidden'];
		}
		// Support multi file field: pdfplanning3
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['pdfplanning3'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = Fixed_tripHelper::getFiles($this->id, $this->_tbl, 'pdfplanning3');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/Fixed_Planning_pdf/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->pdfplanning3 = "";

			foreach ($files['pdfplanning3'] as $singleFile )
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
					if (isset($array['pdfplanning3']))
					{
						$this->pdfplanning3 = $array['pdfplanning3'];
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
					$uploadPath = JPATH_ROOT . '/Fixed_Planning_pdf/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->pdfplanning3 .= (!empty($this->pdfplanning3)) ? "," : "";
					$this->pdfplanning3 .= $filename;
				}
			}
		}
		else
		{
			$this->pdfplanning3 .= $array['pdfplanning3_hidden'];
		}
		// Support multi file field: pdfplanning4
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['pdfplanning4'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = Fixed_tripHelper::getFiles($this->id, $this->_tbl, 'pdfplanning4');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/Fixed_Planning_pdf/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->pdfplanning4 = "";

			foreach ($files['pdfplanning4'] as $singleFile )
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
					if (isset($array['pdfplanning4']))
					{
						$this->pdfplanning4 = $array['pdfplanning4'];
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
					$uploadPath = JPATH_ROOT . '/Fixed_Planning_pdf/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->pdfplanning4 .= (!empty($this->pdfplanning4)) ? "," : "";
					$this->pdfplanning4 .= $filename;
				}
			}
		}
		else
		{
			$this->pdfplanning4 .= $array['pdfplanning4_hidden'];
		}
		// Support multi file field: pdfplanning5
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['pdfplanning5'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = Fixed_tripHelper::getFiles($this->id, $this->_tbl, 'pdfplanning5');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/Fixed_Planning_pdf/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->pdfplanning5 = "";

			foreach ($files['pdfplanning5'] as $singleFile )
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
					if (isset($array['pdfplanning5']))
					{
						$this->pdfplanning5 = $array['pdfplanning5'];
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
					$uploadPath = JPATH_ROOT . '/Fixed_Planning_pdf/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->pdfplanning5 .= (!empty($this->pdfplanning5)) ? "," : "";
					$this->pdfplanning5 .= $filename;
				}
			}
		}
		else
		{
			$this->pdfplanning5 .= $array['pdfplanning5_hidden'];
		}
		// Support multi file field: pdfplanning6
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['pdfplanning6'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = Fixed_tripHelper::getFiles($this->id, $this->_tbl, 'pdfplanning6');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/Fixed_Planning_pdf/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->pdfplanning6 = "";

			foreach ($files['pdfplanning6'] as $singleFile )
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
					if (isset($array['pdfplanning6']))
					{
						$this->pdfplanning6 = $array['pdfplanning6'];
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
					$uploadPath = JPATH_ROOT . '/Fixed_Planning_pdf/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->pdfplanning6 .= (!empty($this->pdfplanning6)) ? "," : "";
					$this->pdfplanning6 .= $filename;
				}
			}
		}
		else
		{
			$this->pdfplanning6 .= $array['pdfplanning6_hidden'];
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

		return 'com_fixed_trip.create_trip.' . (int) $this->$k;
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
		$assetParent->loadByName('com_fixed_trip');

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

			foreach ($this->pdfplanning1 as $pdfplanning1File)
			{
				JFile::delete(JPATH_ROOT . '/Fixed_Planning_pdf/' . $pdfplanning1File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->pdfplanning2 as $pdfplanning2File)
			{
				JFile::delete(JPATH_ROOT . '/Fixed_Planning_pdf/' . $pdfplanning2File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->pdfplanning3 as $pdfplanning3File)
			{
				JFile::delete(JPATH_ROOT . '/Fixed_Planning_pdf/' . $pdfplanning3File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->pdfplanning4 as $pdfplanning4File)
			{
				JFile::delete(JPATH_ROOT . '/Fixed_Planning_pdf/' . $pdfplanning4File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->pdfplanning5 as $pdfplanning5File)
			{
				JFile::delete(JPATH_ROOT . '/Fixed_Planning_pdf/' . $pdfplanning5File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->pdfplanning6 as $pdfplanning6File)
			{
				JFile::delete(JPATH_ROOT . '/Fixed_Planning_pdf/' . $pdfplanning6File);
			}
		}

		return $result;
	}
}
