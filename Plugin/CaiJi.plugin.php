<?php

class CaiJiPlugin extends Plugin{
	
	public function run($data){

		$url=$data['url'];
		
		$curl=curl_init();

		curl_setopt($curl,CURLOPT_URL,$url);

		curl_setopt($curl,CURLOPT_TIMEOUT,10);

		//curl_setopt($curl,CURLOPT_HEADER,0);

		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);

		curl_setopt($curl,CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");

		$result=curl_exec($curl);
		
		$result=preg_replace('/\s/','',$result);
		
		$status=preg_match_all('/<img[^>]*src="(.*?[png|jpg|gif])"/',$result,$matches);

		if(!status) return array();
		
		return $matches[1];
		
	}
}