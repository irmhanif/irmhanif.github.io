
<?PHP
define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(__FILE__) );
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
global $mainframe;
$mainframe =JFactory::getApplication('site');
$mainframe->initialise();
$name='Idris';
$final_installment=12000;
$message ='Dear '.$name.',
The date of your booking with us is fast approaching and the final balance is due soon. The outstanding balance of '.$final_installment.' is due within the next 48 hours.
Thanks,
FranceByFrench';
            $phone=7010221314;
           /* $data = array(
                   'sender' => 'FBFMSG',
                   'route' => '4',
                   'mobiles' => 9566697885,
				   'authkey' => '251010ABuhjQsbrn2s5c0bcd2d',
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
*/
	/* Order SMS to customer code END */