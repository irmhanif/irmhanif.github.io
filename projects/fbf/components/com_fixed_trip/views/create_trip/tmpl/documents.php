<?php
    $db = JFactory::getDbo();
    $user = JFactory::getUser();
    $user_id=$user->id;
   $tshirt = JRequest::getvar('tshirt');
   $oid = JRequest::getvar('oid');
   $orderby = JRequest::getvar('orderby');
   $foid = explode('.', $oid);
   $foid = $oid;

 if ($orderby=='customized') {
    $getorderdetails="SELECT no_people FROM `#__customized_order` WHERE uid='$user_id' AND trip_status='final_quote' AND id=$oid";
    $db->setQuery($getorderdetails);
    $noofpeople=$db->loadResult();
 }
  if ($orderby=='fixed') {
    $getorderdetails="SELECT no_of_people FROM `#__fixed_trip_orders` WHERE uid='$user_id' AND id='$foid'";
    $db->setQuery($getorderdetails);
    $noofpeople=$db->loadResult();
    $route="index.php?option=com_fixed_trip&view=create_trip&layout=success";
    $route=JRoute::_($route);

 $sqllist="SELECT * FROM `#__fixed_trip_orders` WHERE id='$foid'";
$db->setQuery($sqllist);
$result=$db->loadObjectList();
foreach($result as $data) {
  $uid=$data->uid;
  $fname=$data->uname;
  $email=$data->uemail;
  $phone=$data->umobile;
  $product=$data->pack_title;
  $amount=$data->first_installment;
}
 }
   if ($orderby=='semi') {
    $getorderdetails="SELECT number_peoples FROM `#__semicustomized_order` WHERE uid='$user_id' AND trip_status='final_quote'";
    $db->setQuery($getorderdetails);
    $noofpeople=$db->loadResult();
 }


    if (isset($_FILES['my_file'])) {
      // Getting file name

     $myFile = $_FILES['my_file'];
     $fileCount = count($myFile["name"]);

      for ($i = 0; $i < $fileCount; $i++) {

      // Valid extension
      $valid_ext = array('png','jpeg','jpg','docx','rtf','pdf');


     if (!file_exists(JPATH_SITE.'/'."images".'/'."documents".'/'.$user_id))
            {
                mkdir(JPATH_SITE.'/'."images".'/'."documents".'/'.$user_id);
            }
         $filename=rand().'-'.$user_id.'-'.$myFile["name"][$i];

          $location = JPATH_SITE.'/'."images".'/'."documents".'/'.$user_id.'/'.$filename;

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

    if (isset($_FILES['panfile'])) {
      // Getting file name

     $myFile = $_FILES['panfile'];
     $fileCount = count($myFile["name"]);

      for ($i = 0; $i < $fileCount; $i++) {

      // Valid extension
      $valid_ext = array('png','jpeg','jpg','docx','rtf','pdf');


     if (!file_exists(JPATH_SITE.'/'."images".'/'."pandocument".'/'.$user_id))
            {
                mkdir(JPATH_SITE.'/'."images".'/'."pandocument".'/'.$user_id);
            }
         $proof=rand().'-'.$user_id.'-'.$myFile["name"][$i];

          $location = JPATH_SITE.'/'."images".'/'."pandocument".'/'.$user_id.'/'.$proof;

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
      if($myFile){
                $date = date('Y-m-d H:i:s');
                $object = new stdClass();
                $object->id = '';
                $object->document =$filename;
                $object->pancard =$proof;
                $object->user_id  =$user_id;
               $object->tshirt  =$tshirt;
                $object->trip_type  =$orderby;
                $object->order_id  =$foid;
                $db->insertObject('#__user_documents', $object);
      }
   }
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
<div class="item"><img src="images/fixedb/P12GFTP4.jpg" alt=""></div>
<div class="doc_upload">
  <form method='post' action='<?php echo $route; ?>' enctype='multipart/form-data'>
  <?php
  for($i=1; $i<=$noofpeople; $i++){

    echo "<div class='price_update'>
    <label>passport $i</label><input type='file' name='my_file[]' id='imagefile_$i' ></br>
        <label>pancard $i</label><input type='file' name='panfile[]' id='panfile_$i' ></br>
            <label>tshirt $i</label><select  name='tshirt' id='tshirt_$i' ></br>
            <option value=''>Select any</option>
            <option value='s'>s</option>
            <option value='m'>m</option>
            <option value='L'>L</option>
            <option value='XL'>XL</option>
            <option value='XXL'>XXL</option>
            <option value='XXXL'>XXXL</option>
            <option value='XXXXL'>XXXXL</option>
    </select>

    </div>";

    }
    echo "<p><input type='checkbox' name='price_check' value='' required>I agree the <a href='#'>terms and conditions</a><br></p>";
  ?>

   <input type='submit' value='Upload' name='document'>
   <input type='hidden' value='<?php echo $uid; ?>' name='udf1'>
   <input type='hidden' value='<?php echo $oid; ?>' name='udf2'>
   <input type='hidden' value='<?php echo $fname; ?>' name='firstname'>
   <input type='hidden' value='<?php echo $email; ?>' name='email'>
   <input type='hidden' value='<?php echo $phone; ?>' name='phone'>
   <input type='hidden' value='<?php echo $product; ?>' name='productinfo'>
   <input type='hidden' value='<?php echo $amount; ?>' name='amount'>

  </form>
</div>
