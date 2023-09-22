<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Trips
 * @author     Mohamed Idris <idriswan@gmail.com>
 * @copyright  2018 Mohamed Idris
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Trips list controller class.
 *
 * @since  1.6
 */
class TripsControllerTrips extends TripsController
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
	public function &getModel($name = 'Trips', $prefix = 'TripsModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}

	public function shareLink() {
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$user_id=$user->id;

		$friendemail = JRequest::getVar('friendemail');
		$friendnum = JRequest::getVar('friendnum');
		$triptype = JRequest::getVar('triptype');
		$orderid = JRequest::getVar('orderid');

    	$object2 = new stdClass();
    	$object2->id='';
	    $object2->trip_type=$triptype;
	    $object2->orderid=$orderid;
	    $object2->organizer_id=$user_id;
	    $object2->friendemail=$friendemail;
	    $object2->friendnum=$friendnum;
	    $db->insertObject('#__sharepayment', $object2);
	    $last_inserted =$db->insertid();

        $url='index.php?option=com_trips&view=trips&layout=sharepay&orderid='.$orderid.'&uid='.$user_id.'&sharid='.$last_inserted.'';

	    $object3 = new stdClass();
	    $object3->id=$last_inserted;
	    $object3->paymentlink=$url;
	    JFactory::getDbo()->updateObject('#__sharepayment', $object3, 'id');
	}
	public function review()
    {
    $db = JFactory::getDbo();
    $user = JFactory::getUser();
    $user_id=$user->id;

    $sqlc="SELECT * FROM `#__customer_rev1ews`  WHERE state=1 ORDER BY id DESC"; 
    $db->setQuery($sqlc);
    $users_detailc=$db->loadObjectList();
    
    foreach($users_detailc as $key=> $user_dispc) {
        $username=$user_dispc->uid;
        $created_by=$user_dispc->created_by;
        $reviewtext=$user_dispc->reviewtext;
        $image=$user_dispc->image;
        $tittle=$user_dispc->tittle;
        $author_name=$user_dispc->author_name;
        if($key%2 !=0){
         $addclass='img_right_side';
        }
        else{
            $addclass='img_left_side';
        }
        echo '<div class="rbox">
        <div class="reviewbox1"><div class="reviewbox2">
            <div class="rbox2 '.$addclass.'">
                <p class="review_txt7">'.$tittle.'</p>
                <div class="review_txt">'.$reviewtext.'</div>
                <p class="author_name"> - '.$author_name.'</p>
            </div>
        <div class="rbox3">';
        ?> 
        
        <?php
        
        if($created_by==726){
              echo '<img src="'.JURI::root().'review_gallery/'.$image.'">';
        } else {
            echo '<img src="'.JURI::root().'review/'.$username.'/'.$image.'">';
        }
        
        echo '</div></div></div>
        </div>';
     
    }
	exit;
    }
}
