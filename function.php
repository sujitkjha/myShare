<?php
	
	function getRandomName($size) {
		$alpha_key = '';
		$keys = range('a', 'z');

		for ($i = 0; $i < 2; $i++) {
			$alpha_key .= $keys[array_rand($keys)];
		}

		$length = $size - 2;

		$key = '';
		$keys = range(0, 9);

		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}

		return $alpha_key . $key;
	}

	function saveImageFromUrl( $url ){

		$filename = getRandomName( 16 ) . '.jpg';

		//file_put_contents( __DIR__ . "/downloads/$filename", file_get_contents(( $url )));

		saveRemoteFile( $url, $filename );
		
		return $filename;
	}

	function getFacebook(){
		return new Facebook\Facebook([
		  	'app_id' => APP_ID,
		  	'app_secret' => APP_SECRET,
		  	'default_graph_version' => 'v2.5',
		]);
	}

	function saveRemoteFile( $url, $filename ){

		$fp = fopen (__DIR__ . "/downloads/$filename", 'w+');
	
		//Here is the file we are downloading, replace spaces with %20
		$ch = curl_init(str_replace(" ", "%20", $url));
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		
		// write curl response to file
		curl_setopt($ch, CURLOPT_FILE, $fp); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		
		// get curl response
		curl_exec($ch); 
		curl_close($ch);
		fclose($fp);
	}
?>