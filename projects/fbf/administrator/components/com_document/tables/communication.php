<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Document
 * @author     Subash R <subash.zinavo@gmail.com>
 * @copyright  2019 Subash R
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;
/**
 * communication Table class
 *
 * @since  1.6
 */
class DocumentTablecommunication extends JTable
{
	
	/**
	 * Constructor
	 *
	 * @param   JDatabase  &$db  A database connector object
	 */
	public function __construct(&$db)
	{
		JObserverMapper::addObserverClassToClass('JTableObserverContenthistory', 'DocumentTablecommunication', array('typeAlias' => 'com_document.communication'));
		parent::__construct('#__document_communication', 'id', $db);
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
	    $db = JFactory::getDbo();
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
			
			
		$user_id=$array['user_id'];

		
       $sqlc="SELECT * FROM `#__users` WHERE id=$user_id";
        $db->setQuery($sqlc);
        $users_detailc=$db->loadObjectList();
        foreach($users_detailc as $user_dispc) {
            $username=$user_dispc->name;
            $contact=$user_dispc->phone;
            $mail=$user_dispc->email;
        }
		$from_id = "admin@francebyfrench.com";
			$to =  $mail ;
			$subject ='FRANCEBYFRENCH DOCUMENT UPDATE NOTIFICATION';
$message = '<p>Dear '.$username.' <br>
We have updated new information concerning your trip! Have a look in your account<br>
A bientot,
FranceByFrench</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_id. "\r\n";
            $sentmail = mail($to,$subject,$message,$headers); 
       
$message = 'Dear '.$username.',
We have updated new information concerning your trip! Kindly check your account.
A bientot,
FranceByFrench';
       $data = array(
                   'sender' => 'FBFMSG',
                   'route' => '4',
                   'mobiles' => $contact,
				   'authkey' => 'test', //251010ABuhjQsbrn2s5c0bcd2d
				   'country' => 'INDIA',
				   'message' => $message
				);

				# Create a connection
				$url = 'http://api.msg91.com/api/sendhttp.php';
				$ch = curl_init($url);

				# Form data string
				echo $postString = http_build_query($data, '', '&');

				# Setting our options
				echo curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
				 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				# Get the response
				echo $response = curl_exec($ch);

				$array_station = json_decode($response, true);

                print_r($array_station);
				curl_close($ch);

	/* Order SMS to customer code END */
	
			
			
		}

		// Support for multiple field: user_id
		if (isset($array['user_id']))
		{
			if (is_array($array['user_id']))
			{
				$array['user_id'] = implode(',',$array['user_id']);
			}
			elseif (strpos($array['user_id'], ',') != false)
			{
				$array['user_id'] = explode(',',$array['user_id']);
			}
			elseif (strlen($array['user_id']) == 0)
			{
				$array['user_id'] = '';
			}
		}
		else
		{
			$array['user_id'] = '';
		}

		// Support for multiple field: quote
		if (isset($array['quote']))
		{
			if (is_array($array['quote']))
			{
				$array['quote'] = implode(',',$array['quote']);
			}
			elseif (strpos($array['quote'], ',') != false)
			{
				$array['quote'] = explode(',',$array['quote']);
			}
			elseif (strlen($array['quote']) == 0)
			{
				$array['quote'] = '';
			}
		}
		else
		{
			$array['quote'] = '';
		}
		// Support for multi file field: document1
		if (!empty($array['document1']))
		{
			if (is_array($array['document1']))
			{
				$array['document1'] = implode(',', $array['document1']);
			}
			elseif (strpos($array['document1'], ',') != false)
			{
				$array['document1'] = explode(',', $array['document1']);
			}
		}
		else
		{
			$array['document1'] = '';
		}

		// Support for multi file field: document2
		if (!empty($array['document2']))
		{
			if (is_array($array['document2']))
			{
				$array['document2'] = implode(',', $array['document2']);
			}
			elseif (strpos($array['document2'], ',') != false)
			{
				$array['document2'] = explode(',', $array['document2']);
			}
		}
		else
		{
			$array['document2'] = '';
		}

		// Support for multi file field: document3
		if (!empty($array['document3']))
		{
			if (is_array($array['document3']))
			{
				$array['document3'] = implode(',', $array['document3']);
			}
			elseif (strpos($array['document3'], ',') != false)
			{
				$array['document3'] = explode(',', $array['document3']);
			}
		}
		else
		{
			$array['document3'] = '';
		}

		// Support for multi file field: document4
		if (!empty($array['document4']))
		{
			if (is_array($array['document4']))
			{
				$array['document4'] = implode(',', $array['document4']);
			}
			elseif (strpos($array['document4'], ',') != false)
			{
				$array['document4'] = explode(',', $array['document4']);
			}
		}
		else
		{
			$array['document4'] = '';
		}

		// Support for multi file field: document5
		if (!empty($array['document5']))
		{
			if (is_array($array['document5']))
			{
				$array['document5'] = implode(',', $array['document5']);
			}
			elseif (strpos($array['document5'], ',') != false)
			{
				$array['document5'] = explode(',', $array['document5']);
			}
		}
		else
		{
			$array['document5'] = '';
		}

		// Support for multi file field: document6
		if (!empty($array['document6']))
		{
			if (is_array($array['document6']))
			{
				$array['document6'] = implode(',', $array['document6']);
			}
			elseif (strpos($array['document6'], ',') != false)
			{
				$array['document6'] = explode(',', $array['document6']);
			}
		}
		else
		{
			$array['document6'] = '';
		}

		// Support for multi file field: document7
		if (!empty($array['document7']))
		{
			if (is_array($array['document7']))
			{
				$array['document7'] = implode(',', $array['document7']);
			}
			elseif (strpos($array['document7'], ',') != false)
			{
				$array['document7'] = explode(',', $array['document7']);
			}
		}
		else
		{
			$array['document7'] = '';
		}

		// Support for multi file field: document8
		if (!empty($array['document8']))
		{
			if (is_array($array['document8']))
			{
				$array['document8'] = implode(',', $array['document8']);
			}
			elseif (strpos($array['document8'], ',') != false)
			{
				$array['document8'] = explode(',', $array['document8']);
			}
		}
		else
		{
			$array['document8'] = '';
		}

		// Support for multi file field: document9
		if (!empty($array['document9']))
		{
			if (is_array($array['document9']))
			{
				$array['document9'] = implode(',', $array['document9']);
			}
			elseif (strpos($array['document9'], ',') != false)
			{
				$array['document9'] = explode(',', $array['document9']);
			}
		}
		else
		{
			$array['document9'] = '';
		}

		// Support for multi file field: document10
		if (!empty($array['document10']))
		{
			if (is_array($array['document10']))
			{
				$array['document10'] = implode(',', $array['document10']);
			}
			elseif (strpos($array['document10'], ',') != false)
			{
				$array['document10'] = explode(',', $array['document10']);
			}
		}
		else
		{
			$array['document10'] = '';
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

		if (!JFactory::getUser()->authorise('core.admin', 'com_document.communication.' . $array['id']))
		{
			$actions         = JAccess::getActionsFromFile(
				JPATH_ADMINISTRATOR . '/components/com_document/access.xml',
				"/access/section[@name='communication']/"
			);
			$default_actions = JAccess::getAssetRules('com_document.communication.' . $array['id'])->getData();
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
		
		
		// Support multi file field: document1
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['document1'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = DocumentHelper::getFiles($this->id, $this->_tbl, 'document1');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/images/document1/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->document1 = "";

			foreach ($files['document1'] as $singleFile )
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
					if (isset($array['document1']))
					{
						$this->document1 = $array['document1'];
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
					$uploadPath = JPATH_ROOT . '/images/document1/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->document1 .= (!empty($this->document1)) ? "," : "";
					$this->document1 .= $filename;
				}
			}
		}
		else
		{
			$this->document1 .= $array['document1_hidden'];
		}
		// Support multi file field: document2
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['document2'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = DocumentHelper::getFiles($this->id, $this->_tbl, 'document2');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/images/document2/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->document2 = "";

			foreach ($files['document2'] as $singleFile )
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
					if (isset($array['document2']))
					{
						$this->document2 = $array['document2'];
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
					$uploadPath = JPATH_ROOT . '/images/document2/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->document2 .= (!empty($this->document2)) ? "," : "";
					$this->document2 .= $filename;
				}
			}
		}
		else
		{
			$this->document2 .= $array['document2_hidden'];
		}
		// Support multi file field: document3
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['document3'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = DocumentHelper::getFiles($this->id, $this->_tbl, 'document3');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/images/document3/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->document3 = "";

			foreach ($files['document3'] as $singleFile )
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
					if (isset($array['document3']))
					{
						$this->document3 = $array['document3'];
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
					$uploadPath = JPATH_ROOT . '/images/document3/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->document3 .= (!empty($this->document3)) ? "," : "";
					$this->document3 .= $filename;
				}
			}
		}
		else
		{
			$this->document3 .= $array['document3_hidden'];
		}
		// Support multi file field: document4
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['document4'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = DocumentHelper::getFiles($this->id, $this->_tbl, 'document4');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/images/document4/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->document4 = "";

			foreach ($files['document4'] as $singleFile )
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
					if (isset($array['document4']))
					{
						$this->document4 = $array['document4'];
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
					$uploadPath = JPATH_ROOT . '/images/document4/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->document4 .= (!empty($this->document4)) ? "," : "";
					$this->document4 .= $filename;
				}
			}
		}
		else
		{
			$this->document4 .= $array['document4_hidden'];
		}
		// Support multi file field: document5
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['document5'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = DocumentHelper::getFiles($this->id, $this->_tbl, 'document5');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/images/document5/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->document5 = "";

			foreach ($files['document5'] as $singleFile )
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
					if (isset($array['document5']))
					{
						$this->document5 = $array['document5'];
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
					$uploadPath = JPATH_ROOT . '/images/document5/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->document5 .= (!empty($this->document5)) ? "," : "";
					$this->document5 .= $filename;
				}
			}
		}
		else
		{
			$this->document5 .= $array['document5_hidden'];
		}
		// Support multi file field: document6
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['document6'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = DocumentHelper::getFiles($this->id, $this->_tbl, 'document6');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/images/document6/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->document6 = "";

			foreach ($files['document6'] as $singleFile )
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
					if (isset($array['document6']))
					{
						$this->document6 = $array['document6'];
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
					$uploadPath = JPATH_ROOT . '/images/document6/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->document6 .= (!empty($this->document6)) ? "," : "";
					$this->document6 .= $filename;
				}
			}
		}
		else
		{
			$this->document6 .= $array['document6_hidden'];
		}
		// Support multi file field: document7
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['document7'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = DocumentHelper::getFiles($this->id, $this->_tbl, 'document7');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/images/document7/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->document7 = "";

			foreach ($files['document7'] as $singleFile )
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
					if (isset($array['document7']))
					{
						$this->document7 = $array['document7'];
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
					$uploadPath = JPATH_ROOT . '/images/document7/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->document7 .= (!empty($this->document7)) ? "," : "";
					$this->document7 .= $filename;
				}
			}
		}
		else
		{
			$this->document7 .= $array['document7_hidden'];
		}
		// Support multi file field: document8
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['document8'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = DocumentHelper::getFiles($this->id, $this->_tbl, 'document8');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/images/document8/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->document8 = "";

			foreach ($files['document8'] as $singleFile )
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
					if (isset($array['document8']))
					{
						$this->document8 = $array['document8'];
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
					$uploadPath = JPATH_ROOT . '/images/document8/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->document8 .= (!empty($this->document8)) ? "," : "";
					$this->document8 .= $filename;
				}
			}
		}
		else
		{
			$this->document8 .= $array['document8_hidden'];
		}
		// Support multi file field: document9
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['document9'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = DocumentHelper::getFiles($this->id, $this->_tbl, 'document9');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/images/document9/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->document9 = "";

			foreach ($files['document9'] as $singleFile )
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
					if (isset($array['document9']))
					{
						$this->document9 = $array['document9'];
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
					$uploadPath = JPATH_ROOT . '/images/document9/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->document9 .= (!empty($this->document9)) ? "," : "";
					$this->document9 .= $filename;
				}
			}
		}
		else
		{
			$this->document9 .= $array['document9_hidden'];
		}
		// Support multi file field: document10
		$app = JFactory::getApplication();
		$files = $app->input->files->get('jform', array(), 'raw');
		$array = $app->input->get('jform', array(), 'ARRAY');

		if ($files['document10'][0]['size'] > 0)
		{
			// Deleting existing files
			$oldFiles = DocumentHelper::getFiles($this->id, $this->_tbl, 'document10');

			foreach ($oldFiles as $f)
			{
				$oldFile = JPATH_ROOT . '/images/document10/' . $f;

				if (file_exists($oldFile) && !is_dir($oldFile))
				{
					unlink($oldFile);
				}
			}

			$this->document10 = "";

			foreach ($files['document10'] as $singleFile )
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
					if (isset($array['document10']))
					{
						$this->document10 = $array['document10'];
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
					$uploadPath = JPATH_ROOT . '/images/document10/' . $filename;
					$fileTemp = $singleFile['tmp_name'];

					if (!JFile::exists($uploadPath))
					{
						if (!JFile::upload($fileTemp, $uploadPath))
						{
							$app->enqueueMessage('Error moving file', 'warning');

							return false;
						}
					}

					$this->document10 .= (!empty($this->document10)) ? "," : "";
					$this->document10 .= $filename;
				}
			}
		}
		else
		{
			$this->document10 .= $array['document10_hidden'];
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

		return 'com_document.communication.' . (int) $this->$k;
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
		$assetParent->loadByName('com_document');

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

			foreach ($this->document1 as $document1File)
			{
				JFile::delete(JPATH_ROOT . '/images/document1/' . $document1File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->document2 as $document2File)
			{
				JFile::delete(JPATH_ROOT . '/images/document2/' . $document2File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->document3 as $document3File)
			{
				JFile::delete(JPATH_ROOT . '/images/document3/' . $document3File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->document4 as $document4File)
			{
				JFile::delete(JPATH_ROOT . '/images/document4/' . $document4File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->document5 as $document5File)
			{
				JFile::delete(JPATH_ROOT . '/images/document5/' . $document5File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->document6 as $document6File)
			{
				JFile::delete(JPATH_ROOT . '/images/document6/' . $document6File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->document7 as $document7File)
			{
				JFile::delete(JPATH_ROOT . '/images/document7/' . $document7File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->document8 as $document8File)
			{
				JFile::delete(JPATH_ROOT . '/images/document8/' . $document8File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->document9 as $document9File)
			{
				JFile::delete(JPATH_ROOT . '/images/document9/' . $document9File);
			}
			jimport('joomla.filesystem.file');

			foreach ($this->document10 as $document10File)
			{
				JFile::delete(JPATH_ROOT . '/images/document10/' . $document10File);
			}
		}

		return $result;
	}
}
