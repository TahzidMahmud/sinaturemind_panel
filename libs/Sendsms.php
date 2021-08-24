<?php
class Sendsms{

	function validate_msisdn($msisdn)
		{
			$msisdn = trim(preg_replace("/[^0-9]+/", "", $msisdn));
			$msisdn = preg_replace("/^(00)?(88)?0/", "", $msisdn);
			if (strlen($msisdn) != 10 || strncmp($msisdn, "1", 1) != 0)
				return false;

			$msisdn = "880" . $msisdn;
			return $msisdn;
		}

		function send_sms($sms_text, $recipients, $ta='pv', $mask='', $type='text')
		{
			$destination = '';
			if ($ta == 'pv') { # private message (to numbers)
				if (!is_array($recipients)) { # one or more numbers specified in string, comma delimited
				$recipients = explode(',', $recipients); # make array of numbers
				}
				$destination = implode(',', array_filter($recipients, "validate_msisdn")); # filter out invalid numbers
			} else { # broadcast message (to group)
				$destination = strtoupper(trim($recipients));
			}


			if ($destination == '') return false;
			if ($type != 'flash') $type = 'text';
			
			
			

			$url = "http://sms.nixtecsys.com/index.php?app=webservices&ta=$ta&u=rajibd2k"
				. "&h=cf433f78aa2da3d4fdf3d9fdef0fbd24771b4c6d&to=" . rawurlencode($destination)
				. "&msg=" . rawurlencode($sms_text) . "&mask=" . rawurlencode($mask)
				. "&type=$type";
			return file_get_contents($url);
		}

// 		function send_single_sms($sms_text, $recipients, $ta='pv', $mask='', $type='text')
// 		{
		

// 			$url = "http://sms.nixtecsys.com/index.php?app=webservices&ta=$ta&u=amarbazar"
// 				. "&h=29aca4fd6477796af346b35a2120b7d2b82417ef&to=" . rawurlencode($recipients)
// 				. "&msg=" . rawurlencode($sms_text) . "&mask=" . rawurlencode($mask)
// 				. "&type=$type";
// 			return file_get_contents($url);
// 		}

function send_single_sms($sms_text, $recipients, $ta='pv', $mask='', $type='text')
		{
		    
		    
		
// 			$url = "https://smsportal.dotbdcloud.com/smsapi/sendsms?apitoken=5634527gdfd3484834287FRTvVdfdhsC54656v&username=amarbazar&tono=".rawurlencode($recipients)."&priority=0&company=amarbazar&message=".rawurlencode($sms_text);
			
				$url = "https://smsportal.dotbdcloud.com/smsapi/sendsms?apitoken=5467486464hsgczzDAS6457FRTvVhdfbdhdhdgd464563ndhh&username=dotademy&tono=".rawurlencode($recipients)."&priority=0&company=dotademy&message=".rawurlencode($sms_text);
			return file_get_contents($url);
		}

	function randPass($length, $strength=8) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength >= 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength >= 2) {
			$vowels .= "AEUY";
		}
		if ($strength >= 4) {
			$consonants .= '23456789';
		}
		if ($strength >= 8) {
			$consonants .= '@#$%';
		}

		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}

	
}