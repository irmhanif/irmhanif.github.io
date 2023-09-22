<?php 

      $name='idris';
      
      $to =  'subash.zinavo@gmail.com' ;
			$subject ='Document submited';
			$message = '<p>'.$name.', Submitted his documents for following trip  and his order id is</p>';
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
            $headers .= 'From: <vikram.zinavo@gmail.com>' . "\r\n";
            $sentmail = mail($to,$subject,$message,$headers);
            if($sentmail){
                echo 'mail sends';
            }
            ?>