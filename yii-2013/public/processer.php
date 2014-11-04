<?php

require_once('recaptchalib.php');
$privatekey = "6Ld7_PwSAAAAAMNp02FDTQfpd8gO91BJEdyBaktr";

function getIP() {
	if (!empty($_SERVER['HTTP_CLIENT_IP']))  //check ip from share internet
           $IP=$_SERVER['HTTP_CLIENT_IP'];
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  //to check ip is pass from proxy
            $IP=$_SERVER['HTTP_X_FORWARDED_FOR'];
	else $IP=$_SERVER['REMOTE_ADDR'];
	return $IP;
}


if (isset($_POST['ftype'])) {
	if ($_POST['ftype'] == "er") {
		if (isset($_POST['urn'])) $urn = $_POST['urn'];
		else { 
			echo json_encode(array('status' => 1, 'message' => "An error occurred."));
			return;
		}

		$errortype = $_POST['type'].$_POST['otherrror'];
		$errortext = $_POST['re_additional'];
		$email = $_POST['email'];
		if (strlen($email) <= 3) $email = "sunnah@iman.net";
		
		$resp = recaptcha_check_answer ($privatekey,
			$_SERVER["REMOTE_ADDR"],
		    $_POST["recaptcha_challenge_field"],
			$_POST["recaptcha_response_field"]);
		
		if (!$resp->is_valid) {
			echo json_encode(array('status' => 2, 'message' => "The captcha was entered	"
				. "incorrectly. Please try again."));
		}
		else {
			$fullString = "Error type: ".$errortype."\n";
		  	$fullString = $fullString."Details: ".$errortext."\n";
		  	$fullString = $fullString."Submitted by ".$email."\n";
			$fullString = $fullString."IP address: ".getIP()."\n";
			$fullString = $fullString."\nhttp://sunnah.com/urn/".$urn."\n";
		  	$to = "sunnah@iman.net";
			$subject = "[Error Report] URN ".$urn;
			$headers = "From: report@sunnah.com\r\nReply-To: $email";
			mail($to, $subject, $fullString, $headers);

			echo json_encode(array('status' => 0, 'message' => "Report submitted, thank you!"));
		}
	}
	elseif ($_POST['ftype'] == "cc") {
		
	}
}
?>
