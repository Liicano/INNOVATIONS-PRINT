<?php

function store_token($token, $name)
{
	file_put_contents("../../library/tokens/$name.token", serialize($token));
}

function load_token($name)
{

	if(!file_exists("../../library/tokens/$name.token")) return null;
	return @unserialize(@file_get_contents("../../library/tokens/$name.token"));
	
}

function delete_token($name)
{
	@unlink("../../library/tokens/$name.token");
}
// ================================================================================

function handle_dropbox_auth($dropbox, $return_url, $oauth_token=null,$auth_callback=null)
{
	// first try to load existing access token
	$access_token = load_token("access");
	if(!empty($access_token)) {
		$dropbox->SetAccessToken($access_token);
	}
	elseif(!empty($auth_callback)) // are we coming from dropbox's auth page?
	{
		// then load our previosly created request token
		$request_token = load_token($oauth_token);
		if(empty($request_token)) die('Request token not found!');
		
		// get & store access token, the request token is not needed anymore
		$access_token = $dropbox->GetAccessToken($request_token);	
		store_token($access_token, "access");
		delete_token($oauth_token);
	}

	// checks if access token is required
	if(!$dropbox->IsAuthorized())
	{
		// redirect user to dropbox auth page
		//$return_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?auth_callback=1";
		//$return_url = "http://".$_SERVER['HTTP_HOST']."/imprenta_final/listar_orden_trabajo.html?auth_callback=1";
		
		if ((strpos($return_url, "admin.php?sec=".(base64_encode("listar_archivos_dropbox"))))===false)
		$auth_url = $dropbox->BuildAuthorizeUrl($return_url."&auth_callback=1");
		else
		$auth_url = $dropbox->BuildAuthorizeUrl($return_url."?auth_callback=1");
		
		$request_token = $dropbox->GetRequestToken();
		store_token($request_token, $request_token['t']);
		die("<div class=\"formRow\" id=\"Mensaje\">Autenticaci&oacute;n Requerida. <a href='$auth_url' >Dar Click.</a></div>");
	}
}

?>