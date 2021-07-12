<?php

include "simple_html_dom.php";

$USERNAME = '199107072020121002';
$PASSWORD = '199107072020121002';

if(!file_exists("cookie.txt")){

	$ch = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_URL => "https://ekinerja.mojokertokota.go.id/auth/login",
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_HEADER => 1,
	));
	$response	= curl_exec($ch);
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
	//var_dump($matches[0]);
	//$header	= $matches[1];
	//die();
	$cookies = "Cookie: " . implode(";",$matches[1]);
	$header	= [$cookies];
	$html	= str_get_html($response);
	$token	= $html->find("[name=_token]");
	$token	= $token[0]->value;
	$post = [
		'username'	=> $USERNAME,
		'password'	=> $PASSWORD,
		'_token'	=> $token,
	];
	$ch = curl_init();
	curl_setopt_array($ch, [
		CURLOPT_URL => "https://ekinerja.mojokertokota.go.id/auth/login/proses",
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_HEADER => 1,
		CURLOPT_POSTFIELDS=> $post,
		CURLOPT_HTTPHEADER => $header
	]);
	$response	= curl_exec($ch);
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
	$cookies = "Cookie: " . implode(";",$matches[1]);
	$err = curl_error($ch);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
		//echo 'logged';
		file_put_contents("cookie.txt", $cookies);
		file_put_contents("token.txt", $token);
	}
}else{
	$pcookies = file_get_contents("cookie.txt");
	$token = file_get_contents("token.txt");
	//var_dump($token,$cookies);

	$ch = curl_init();
	curl_setopt_array($ch, [
		CURLOPT_URL => "https://ekinerja.mojokertokota.go.id/aktifitas/realisasi",
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_HEADER => 1,
		CURLOPT_VERBOSE=>1,
		CURLOPT_HTTPHEADER => [$pcookies]
	]);
	$response	= curl_exec($ch);
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
	$cookies = "Cookie: " . implode(";",$matches[1]);
	file_put_contents("cookie.txt", $cookies);
	//var_dump($pcookies,$cookies,$response);
	//var_dump($cookies);//,$response);

	$rows	= array_map(function($row){return str_getcsv($row,","); }, file('data_aktifitas_juli.csv'));
	$header = array_shift($rows);
	$csv    = array();
	foreach($rows as $row) {
		$post = array_combine($header, $row);
		unset($post['SKP']);
		unset($post['No']);
		$post['action'] = 'add';
		$post['id'] = '0';
		$post['_token'] = $token;
		$post['attachment'] = new CURLFile('token.txt');
		var_dump($post);




	$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL => "https://ekinerja.mojokertokota.go.id/aktifitas/realisasi/proses",
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HEADER => 1,
			CURLOPT_VERBOSE=>1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS=> $post,
			CURLOPT_HTTPHEADER => [$cookies]
		]);
		$response = curl_exec($ch);
		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);
		$cookies = "Cookie: " . implode(";",$matches[1]);
		file_put_contents("cookie.txt", $cookies);
		var_dump($response);
		$info = curl_getinfo($ch);
		die();

	}
}

//echo "<pre>";
//var_dump($csv);
