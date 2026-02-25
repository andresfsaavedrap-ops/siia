<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function recaptcha_validate($token)
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_KEY, 'response' => $token)));
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);
	curl_close();
	$data = json_decode($response, true);
	return $data;
}
?>

