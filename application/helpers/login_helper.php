<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function generate_hash($password){

	$cost = 10;

	// Crea una sal aleatoria
	$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

	// Prefijo para que php lo recuerde.
	// "$2a$" Blowfish. 
	$salt = sprintf("$2a$%02d$", $cost) . $salt;

	// Value:
	// $2a$10$eImiTXuWVxfM37uY4JANjQ==

	// Hash del password con la sal, esto es lo que se almacena en la DB.
	$hash = crypt($password, $salt);

	
	return $hash;
}

function generate_token(){
	$cost = 60;
	// Crea una sal aleatoria
	$salt = strtr(base64_encode(mcrypt_create_iv(50, MCRYPT_DEV_URANDOM)), '+', '.');

	// Prefijo para que php lo recuerde.
	// "$2a$" Blowfish. 
	$salt = sprintf("$2a$%02d$", $cost) . $salt;

	$salt = str_replace(".", "x", $salt);
	$salt = str_replace("/", "w", $salt);
	$salt = str_replace("\\", "l", $salt);
	// Value:
	// $2a$10$eImiTXuWVxfM37uY4JANjQ==

	return $salt;
}

/** obtener el hash del usuario 
* Cambiar por modelo a usar en usuarios o usar query de codeigniter para obtener el hash de la db.
*/
function verify_login($nombre_usuario, $password){
	$CI = & get_instance();
	
	$user_hash = $CI->db->query("select contrasena as hash from usuarios where usuario = '$nombre_usuario'")->row()->hash;

	if ( $user_hash!=null && hash_equals($user_hash, crypt($password, $user_hash)) ) {
	 	return true;
	}else{
		return false;
	}
}

/** obtener el hash del usuario administrador
* Cambiar por modelo a usar en usuarios o usar query de codeigniter para obtener el hash de la db.
*/
function verify_login_admin($nombre_usuario, $password){
	$CI = & get_instance();
	
	$user_hash = $CI->db->query("select contrasena as hash from administradores where usuario = '$nombre_usuario'")->row()->hash;

	if ( $user_hash!=null && hash_equals($user_hash, crypt($password, $user_hash)) ) {
	 	return true;
	}else{
		return false;
	}
}

// Encrypt Function
function mc_encrypt($encrypt, $key){
    $encrypt = serialize($encrypt);
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
    $key = pack('H*', $key);
    $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
    $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
    $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
    return $encoded;
}

// Decrypt Function
function mc_decrypt($decrypt, $key){
    $decrypt = explode('|', $decrypt.'|');
    $decoded = base64_decode($decrypt[0]);
    $iv = base64_decode($decrypt[1]);
    if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
    $key = pack('H*', $key);
    $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
    $mac = substr($decrypted, -64);
    $decrypted = substr($decrypted, 0, -64);
    $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
    if($calcmac!==$mac){ return false; }
    $decrypted = unserialize($decrypted);
    return $decrypted;
}

// Random name para cualquier cosa que necesite random :3
function random($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str; 	
}

function verify_login_user($usuario_id, $password){
	$CI = & get_instance();
	
	$user_hash = $CI->db->query("select password as hash from admins where admin_id = '$usuario_id'")->row()->hash;

	if ( $user_hash!=null && hash_equals($user_hash, crypt($password, $user_hash)) ) {
	 	return true;
	}else{
		return false;
	}
}

function verify_user_exists($usr_email){
	$CI = & get_instance();
	$usr_email_db = $CI->db->query("select * from estudiantes where usuario_id = '$usr_email'")->row()->usuario_id;
	if( $usr_email_db ){
		return true;
	}else{
		return false;
	}
}

?>