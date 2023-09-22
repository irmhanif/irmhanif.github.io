<div class="innerpage_banner2">
       <div class="item"><img src="images/pro.png" alt=""></div>
</div>
<?php
    $db = JFactory::getDbo();
    $user = JFactory::getUser();
    $user_id=$user->id;
    $tshirt = JRequest::getvar('tshirt');
    $oid = JRequest::getvar('oid');
    $orderby = JRequest::getvar('orderby');
    $filenames='';
    $proofs='';
    $tshirtsizes='';
    $result='';

    $sql="SELECT * FROM `#__users` WHERE id=$user_id";
    $db->setQuery($sql);
    $users_detail=$db->loadObjectList();
    foreach($users_detail as $user_disp) {
        $username=$user_disp->name;
        $contact=$user_disp->phone;
        $mail=$user_disp->email;
    }

    $getdocument_count="SELECT COUNT(id) FROM `#__user_documents` WHERE oid=$oid AND trip_type='$orderby'";
    $db->setQuery($getdocument_count);
    $doc_countz=$db->loadResult();

    if($doc_countz==0) {

    if ($orderby=='customized') {
    $getorderdetails="SELECT * FROM `#__customized_order` WHERE uid=$user_id AND trip_status='final_quote' AND id=$oid";
    $db->setQuery($getorderdetails);
    $orderdetail=$db->loadObjectList();

    foreach($orderdetail as $order_res) {
    	$noofpeople=$order_res->no_people;
    	$payment_type=$order_res->payment_type;
    }

 } else if ($orderby=='semi') {
    $getorderdetails="SELECT * FROM `#__semicustomized_order` WHERE uid=$user_id AND trip_status='quotation' AND id=$oid";
    $db->setQuery($getorderdetails);
    $orderdetail=$db->loadObjectList();
    
     foreach($orderdetail as $order_res) {
    	$noofpeople=$order_res->number_peoples;
    	$payment_type=$order_res->paymethod;
    }
    
    
 } else if ($orderby=='fixed') {
    $getorderdetails="SELECT *  FROM `#__fixed_trip_orders` WHERE uid=$user_id AND trip_status='quotation' AND id=$oid";
    $db->setQuery($getorderdetails);
    $orderdetail=$db->loadObjectList();
    
    foreach($orderdetail as $order_res) {
    	$noofpeople=$order_res->no_of_people;
    	$payment_type=$order_res->paymethod;
    }
 }


    if (isset($_FILES['my_file'])) {
      // Getting file name

     $myFile = $_FILES['my_file'];
     $fileCount1 = count($myFile["name"]);

 for ($i = 0; $i < $fileCount1; $i++) {

      // Valid extension
      $valid_ext = array('png','jpeg','jpg','docx','rtf','pdf');


     if (!file_exists(JPATH_SITE.'/'."images".'/'."documents".'/'.$user_id))
            {
                mkdir(JPATH_SITE.'/'."images".'/'."documents".'/'.$user_id);
            }
         $filename=rand().'-'.$user_id.'-'.$myFile["name"][$i];

         $location = JPATH_SITE.'/'."images".'/'."documents".'/'.$user_id.'/'.$filename;
		 $filenames.=$filename.',';
      // file extension

      $file_extension = pathinfo($location, PATHINFO_EXTENSION);
      $file_extension = strtolower($file_extension);
        // Check extension
      if(in_array($file_extension,$valid_ext)){
        // Compress Image
        compressImage($_FILES['my_file']['tmp_name'][$i],$location,60);
      }
      else{
        echo "Invalid file type.";
      }
   }
}

    if (isset($_FILES['panfile'])) {
      // Getting file name

     $myFile = $_FILES['panfile'];
     $fileCount2 = count($myFile["name"]);

      for ($i = 0; $i < $fileCount2; $i++) {

      // Valid extension
      $valid_ext = array('png','jpeg','jpg','docx','rtf','pdf');


     if (!file_exists(JPATH_SITE.'/'."images".'/'."pandocument".'/'.$user_id))
            {
                mkdir(JPATH_SITE.'/'."images".'/'."pandocument".'/'.$user_id);
            }
         $proof=rand().'-'.$user_id.'-'.$myFile["name"][$i];

          $location = JPATH_SITE.'/'."images".'/'."pandocument".'/'.$user_id.'/'.$proof;
		$proofs.=$proof.',';
      // file extension

      $file_extension = pathinfo($location, PATHINFO_EXTENSION);
      $file_extension = strtolower($file_extension);


      // Check extension
      if(in_array($file_extension,$valid_ext)){
        // Compress Image
        compressImage($_FILES['panfile']['tmp_name'][$i],$location,60);
      }
      else{
        echo "Invalid file type.";
      }
   }
 }

  if(isset($_POST['tshirt'])) {
     	$tshirts = $_POST['tshirt'];
		foreach($tshirts as $value) {
		   $tshirtsizes .= $value.",";
		}
    }
  if(isset($_POST['address'])) {
     	$address = $_POST['address'];
    }
    
    
   if(isset($_POST['share_msg'])) {
       
       $share_msg = $_POST['share_msg'];
       
        if ($orderby=='customized') {
              $date = date('Y-m-d H:i:s');
              $objectz = new stdClass();
              $objectz->id = $oid;
              $objectz->share_msg = $share_msg;
              $result = JFactory::getDbo()->updateObject('#__customized_order', $objectz, 'id');
          } else if ($orderby=='semi') {
              $date = date('Y-m-d H:i:s');
              $objectz = new stdClass();
              $objectz->id = $oid;
              $objectz->share_msg = $share_msg;
              $result = JFactory::getDbo()->updateObject('#__semicustomized_order', $objectz, 'id');
          } else if ($orderby=='fixed') {
              $date = date('Y-m-d H:i:s');
              $objectz = new stdClass();
              $objectz->id = $oid;
              $objectz->share_msg = $share_msg;
              $result = JFactory::getDbo()->updateObject('#__fixed_trip_orders', $objectz, 'id');
          }  else {
              echo '';
          }
    }
    

if (isset($_FILES['my_file'])) {

    $getdocument_count="SELECT COUNT(id) FROM `#__user_documents` WHERE oid=$oid AND trip_type='$orderby'";
    $db->setQuery($getdocument_count);
    $doc_count=$db->loadResult();

      if($doc_count==0) {
      $date = date('Y-m-d H:i:s');
      $object = new stdClass();
      $object->id = '';
      $object->document =$filenames;
      $object->pancard =$proofs;
      $object->user_id  =$user_id;
      $object->tshirt  =$tshirtsizes;
      $object->trip_type  =$orderby;
      $object->oid  =$oid;
      $object->address  =$address;
      $result =$db->insertObject('#__user_documents', $object);
      } else {
    $getdocument_countz="SELECT id FROM `#__user_documents` WHERE oid=$oid AND trip_type='$orderby'";
    $db->setQuery($getdocument_countz);
    $previd=$db->loadResult();
      $date = date('Y-m-d H:i:s');
      $object = new stdClass();
      $object->id = $previd;
      $object->document =$filenames;
      $object->pancard =$proofs;
      $object->user_id  =$user_id;
      $object->tshirt  =$tshirtsizes;
      $object->trip_type  =$orderby;
      $object->oid  =$oid;
      $object->address  =$address;
      $result = JFactory::getDbo()->updateObject('#__user_documents', $object, 'id');
      }
      
      $sql="SELECT name FROM `#__users` WHERE id=$user_id";
      $db->setQuery($sql);
      $name=$db->loadResult();

      $from_id='admin@francebyfrench.com';
      $to =  'paul.martin@francebyfrench.com' ;
	  $subject ='FRANCEBYFRENCH NEW DOCUMENT CHECK';
	  $message = '<p>'.$name.', – has submitted his documents for order id '.$oid.' ('.$orderby.')- . Please do follow up with our partners</p><p>Thanks</p><p>FranceByFrench </p>';
	  $headers = "MIME-Version: 1.0" . "\r\n";
	  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
      $headers .= 'From:'.$from_id. "\r\n";
      $headers .= 'Cc: apoorva.uniyal@francebyfrench.com' . "\r\n";
      $headers .= 'Bcc: souria.boumedine@francebyfrench.com' . "\r\n";
      $sentmail = mail($to,$subject,$message,$headers);
      if($sentmail){
          echo 'mail sent';
      }


}

?>
<div class="doc_upload">
<div class="doc_file">
<div class="doc_file1">
  <form method='post' action='' enctype='multipart/form-data' id='passport_upload'>
      <h1 class="des">Upload Documents</h1>
      <div class="doc_icon">
        	<p class='drop'><img src='images/pass.png'></p>
        	<p class='drop'><img src='images/pan.png'></p>
        	        	<p class='drop'><img src='images/tshirt.png'></p>
        	        	</div>
  <?php
  for($i=1; $i<=$noofpeople; $i++){

    echo "<div class='price_update5'>
    <div class='price_update4'>
    <img src='images/Traveller.png'>
    </div>
    <div class='price_update7'>
	<div class='price_upto'>
    <label>Passport $i</label>
    <div class='drag'>
	<p class='drop_drag'>Upload Your Passport</p>
    <input type='file' name='my_file[]' id='imagefile_$i' required></br>
    </div>
    </div>	<div class='price_upto'>
    <div class='price_update'>

        <label>pancard $i</label>
        		<div class='drag'>
		<p class='drop_drag'>Upload Your Pancard</p>
        <input type='file' name='panfile[]' id='panfile_$i' required></br>
        	</div>    </div> </div>
        	<div class='price_upto'>
        	<div class='price_update'>
            <label>T-Shirt Size $i</label>
            <select  name='tshirt[]' id='tshirt_$i' required></br>
            <option value=''>Select T--shirt Size</option>
            <option value='S'>S</option>
            <option value='M'>M</option>
            <option value='L'>L</option>
            <option value='XL'>XL</option>
    </select> </div>
    </div></div></div>";

    }
    echo "";
  ?>
    <div class='price_update1'>
  <p> <label>Address</label><textarea rows="4" cols="50" name="address" placeholder="Address" required></textarea><br>
  </div>

    <?php 
      if($payment_type!='Normal') {
           echo ' <div class="price_update1"><p> <label>Message to Friends</label><textarea rows="4" cols="50" name="share_msg" placeholder="Type here...."></textarea></div>';
      }
    
    ?>
<p id='chk_box'><input type='checkbox' name='price_check' value='' required id='agree_chk'>I agree the <a target="_blank" href='<?php echo JURI::root(); ?>index.php?option=com_content&view=article&id=11&Itemid=169' target="_blank">terms and conditions</a><br></p>
<div class='sub_btn'>
  <input type='submit' value='Upload' name='document' id='doc_submit'>
  </div>

  </form>
</div>
</div>
</div>
</div>
</div>
<?php
    }
	if($result==1) {
	    header("Location:index.php?option=com_trips&view=trips&layout=paynow&trip_type=$orderby&oid=$oid");
	}


  // Compress image
function compressImage($source, $destination, $quality) {

  $info = getimagesize($source);

  if ($info['mime'] == 'image/jpeg')
    $image = imagecreatefromjpeg($source);

  elseif ($info['mime'] == 'image/gif')
    $image = imagecreatefromgif($source);

  elseif ($info['mime'] == 'image/png')
    $image = imagecreatefrompng($source);

  elseif ($info['mime'] == 'image/pdf')
    $image = imagecreatefrompng($source);

  elseif ($info['mime'] == 'image/docx')
    $image = imagecreatefrompng($source);

  elseif ($info['mime'] == 'image/rtf')
    $image = imagecreatefrompng($source);

  imagejpeg($image, $destination, $quality);
   }
?>