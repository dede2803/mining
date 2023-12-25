<?php
system('clear');
error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

//================ warna ====================
$RedTebal    = "\33[1;31m";
$GreenTebal  = "\33[1;32m";
$YellowTebal = "\33[1;33m";
$PurpleTebal = "\33[1;34m";
$PinkTebal   = "\33[1;35m";
$CyanTebal   = "\33[1;36m";
$WhiteTebal  = "\33[1;37m";
$NormalTebal = "\33[1m";

echo $WhiteTebal. "Menghubungkan Server ";
sleep(4);

//============================ CONVERT WAKTU =====================================
function timer($tmr){ 
     $timr=time()+$tmr; 
      while(true): 
      echo "\r                                                                         \r"; 
      $res=$timr-time(); 
      if($res < 1){break;} 
      echo "\33[1;37mSedang Mengambil Waktu Claim \33[1;31m".date($res)." Detik "; 
      sleep(1); 
      endwhile;
}

function wktClaim($tmr){ 
     $timr=time()+$tmr; 
      while(true): 
      echo "\r                                                                         \r"; 
      $res=$timr-time(); 
      if($res < 1){break;} 
      echo "\33[1;37mHarap Tunggu Claim Sedang Berlangsung \33[1;31m".date($res)." Detik "; 
      sleep(1); 
      endwhile;
}

//============================ CONVERT WAKTU =====================================
function waktu($waktu){
    if(($waktu>0) and ($waktu<60)){
        $lama=number_format($waktu,2)." detik";
        return $lama;
    }
    if(($waktu>60) and ($waktu<3600)){
        $detik=fmod($waktu,60);
        $menit=$waktu-$detik;
        $menit=$menit/60;
        $lama=$menit." Menit ".number_format($detik,2)." detik";
        return $lama;
    }
    elseif($waktu >3600){
        $detik=fmod($waktu,60);
        $tempmenit=($waktu-$detik)/60;
        $menit=fmod($tempmenit,60);
        $jam=($tempmenit-$menit)/60;    
        $lama=$jam." Jam ".$menit." Menit ".number_format($detik,2)." detik";
        return $lama;
    }
}

// AWALAN UNTUK PARSING JSON
function fetch_value($str,$find_start,$find_end) {
	$start = @strpos($str,$find_start);
	if ($start === false) {
		return "";
	}
	$length = strlen($find_start);
	$end = strpos(substr($str,$start +$length),$find_end);
	return trim(substr($str,$start +$length,$end));
}

//============================ CURL =============================================
function curl($url, $post = 0, $httpheader = 0, $proxy = 0){ 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_COOKIE,TRUE);
    curl_setopt($ch, CURLOPT_COOKIEFILE,"cookie.txt");
    curl_setopt($ch, CURLOPT_COOKIEJAR,"cookie.txt");
    if($post){
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    
    if($httpheader){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    }
    
    if($proxy){
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        // curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
    }
    
    curl_setopt($ch, CURLOPT_HEADER, true);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch);
    if(!$httpcode) return "Curl Error : ".curl_error($ch); else{
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        curl_close($ch);
        return array($header, $body);
    }
}
system('clear');
echo $WhiteTebal. "Sedang mengambil Data Website ";

//============================================================================================
//============================================================================================
//REFLEX
function headIndexReflex() {
    $h[] = "user-agent: Mozilla/5.0 (Linux; Android 8.1.0; ASUS_X00TD Build/OPM1; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/120.0.6099.43 Mobile Safari/537.36";
    $h[] = "accept: text/html,application/xhtml+xml,application/xml";
    $h[] = "cookie: _ga=GA1.1.1865686609.1701613848";
    $h[] = "cookie: bitmedia_fid=eyJmaWQiOiJhNjk1NjMwM2Q5ZThmZDQ4ZWQ2NTE1YWZlZDAyNTFmNCIsImZpZG5vdWEiOiJmN2VhZjcwYTg3NDkzYzk5NDEyOGUwNzMzY2ZiNTUzOCJ9";
    $h[] = "cookie: bfp_sn_rf_8b2087b102c9e3e5ffed1c1478ed8b78=Direct";
    $h[] = "cookie: bafpCS=17016140929173718823021";
    $h[] = "cookie: bafp=20148fd0-91e9-11ee-ab0e-2d6ca8534f19";
    $h[] = "cookie: trc_cookie_storage=taboola%2520global%253Auser-id%3D3c10ba0e-6bc1-4398-a2f4-670ff90ee877-tuctc66178f";
    $h[] = "cookie: ci_session=bc7d79d40cea43426209c3bbdd57e47cfc2b0621";
    $h[] = "cookie: session_depth=cloudmining.reflextoken.com%3D1%7C120545816%3D1";
    $h[] = "cookie: _ga_TB1NTKR7KW=GS1.1.1702445480.6.0.1702445480.60.0.0";
    $h[] = "cookie: bfp_sn_rt_8b2087b102c9e3e5ffed1c1478ed8b78=1702445481634";
    $h[] = "cookie: bfp_sn_pl=1702445481|1_399516453470";

    return $h;
}

//LITECOIN
function headIndexLitecoin() {
    $h[] = "user-agent: Mozilla/5.0 (Linux; Android 8.1.0; ASUS_X00TD Build/OPM1; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/117.0.0.0 Mobile Safari/537.36";
    $h[] = "accept: text/html,application/xhtml+xml,application/xml;";
    $h[] = "content-type: application/x-www-form-urlencoded;";
    $h[] = "cookie: _ga=GA1.1.1240598660.1699550193";
    $h[] = "cookie: bitmedia_fid=eyJmaWQiOiIwMDY3ODMwOGM1ODAzMzc2NzUzOTNlNWQzZGZkMjNjYyIsImZpZG5vdWEiOiJmN2VhZjcwYTg3NDkzYzk5NDEyOGUwNzMzY2ZiNTUzOCJ9";
    $h[] = "cookie: ci_session=20a02789ae14138f16d54d95ac51fb6268d18630";
    $h[] = "cookie: _ga_J8MJE0GN6R=GS1.1.1702446610.18.0.1702446610.0.0.0";

    return $h;
}

//BITEX
function headIndexBitex() {
    $h[] = "user-agent: Mozilla/5.0 (Linux; Android 8.1.0; ASUS_X00TD Build/OPM1; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/117.0.0.0 Mobile Safari/537.36";
    $h[] = "accept: text/html,application/xhtml+xml,application/xml;";
    $h[] = "content-type: application/x-www-form-urlencoded;";
    $h[] = "cookie: _ga=GA1.1.901347844.1695862457";
    $h[] = "cookie: bitmedia_fid=eyJmaWQiOiI5OThjZGVjMmJkYTJhMDIxMzc5Mjc5NWI0Yzg3M2RhYiIsImZpZG5vdWEiOiJlZTYxYzg3YTJmZDljNmIxYjg3ZWFhNTY1ZWVmNWUwMSJ9";
    $h[] = "cookie: ci_session=c1a302960803b3e2a8d9bac3ceb358488e77034f";
    $h[] = "cookie: _ga_SPZ43FCWCN=GS1.1.1702447310.24.0.1702447310.0.0.0";

    return $h;
}

//SHIBA
function headIndexShiba() {
    $h[] = "user-agent: Mozilla/5.0 (Linux; Android 8.1.0; ASUS_X00TD Build/OPM1; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/117.0.0.0 Mobile Safari/537.36";
    $h[] = "accept: text/html,application/xhtml+xml,application/xml;";
    $h[] = "content-type: application/x-www-form-urlencoded;";
    $h[] = "cookie: bitmedia_fid=eyJmaWQiOiJkYWY2ZDVhNjlhMmVjN2VkNGE4MTZjYzMyZmQ4YTg5ZCIsImZpZG5vdWEiOiJkMThkY2EwMDJmZDY1NjgwMzZkODkyZTljYWE1Yzg0MCJ9";
    $h[] = "cookie: _ga_R9XTMF85JD=deleted";
    $h[] = "cookie: ci_session=b5e31248983791d9b63fdf9bdff622490816a3b2";
    $h[] = "cookie: _ga_R9XTMF85JD=GS1.1.1702447549.4.0.1702447549.0.0.0";
    $h[] = "cookie: _ga=GA1.2.1329130634.1695862284";
    $h[] = "cookie: _gid=GA1.2.1599344828.1702447550";;
    $h[] = "cookie: _gat_gtag_UA_27145904_58=1";

    return $h;
}

//============================================================================================
//============================================================================================
//REFLEX
function headRunReflex() {
    $h[] = "accept: application/json, text/javascript";
    $h[] = "user-agent: Mozilla/5.0 (Linux; Android 8.1.0; ASUS_X00TD Build/OPM1; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/120.0.6099.43 Mobile Safari/537.36";
    $h[] = "referer: https://cloudmining.reflextoken.com/index.php/dashboard";
    $h[] = "cookie: _ga=GA1.1.1865686609.1701613848";
    $h[] = "cookie: bitmedia_fid=eyJmaWQiOiJhNjk1NjMwM2Q5ZThmZDQ4ZWQ2NTE1YWZlZDAyNTFmNCIsImZpZG5vdWEiOiJmN2VhZjcwYTg3NDkzYzk5NDEyOGUwNzMzY2ZiNTUzOCJ9";
    $h[] = "cookie: bfp_sn_rf_8b2087b102c9e3e5ffed1c1478ed8b78=Direct";
    $h[] = "cookie: bafpCS=17016140929173718823021";
    $h[] = "cookie: bafp=20148fd0-91e9-11ee-ab0e-2d6ca8534f19";
    $h[] = "cookie: trc_cookie_storage=taboola%2520global%253Auser-id%3D3c10ba0e-6bc1-4398-a2f4-670ff90ee877-tuctc66178f";
    $h[] = "cookie: ci_session=bc7d79d40cea43426209c3bbdd57e47cfc2b0621";
    $h[] = "cookie: session_depth=cloudmining.reflextoken.com%3D1%7C120545816%3D1";
    $h[] = "cookie: _ga_TB1NTKR7KW=GS1.1.1702445480.6.0.1702445480.60.0.0";
    $h[] = "cookie: bfp_sn_rt_8b2087b102c9e3e5ffed1c1478ed8b78=1702445481634";
    $h[] = "cookie: bfp_sn_pl=1702445481|1_399516453470";

    return $h;
}

//LITECOIN
function headRunLitecoin() {
    $h[] = "user-agent: Mozilla/5.0 (Linux; Android 8.1.0; ASUS_X00TD Build/OPM1; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/117.0.0.0 Mobile Safari/537.36";
    $h[] = "accept: application/json, text/javascript";
    $h[] = "cookie: _ga=GA1.1.1240598660.1699550193";
    $h[] = "cookie: bitmedia_fid=eyJmaWQiOiIwMDY3ODMwOGM1ODAzMzc2NzUzOTNlNWQzZGZkMjNjYyIsImZpZG5vdWEiOiJmN2VhZjcwYTg3NDkzYzk5NDEyOGUwNzMzY2ZiNTUzOCJ9";
    $h[] = "cookie: ci_session=20a02789ae14138f16d54d95ac51fb6268d18630";
    $h[] = "cookie: _ga_J8MJE0GN6R=GS1.1.1702446610.18.1.1702446631.0.0.0";

    return $h;
}

//BITEX
function headRunBitex() {
    $h[] = "user-agent: Mozilla/5.0 (Linux; Android 8.1.0; ASUS_X00TD Build/OPM1; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/117.0.0.0 Mobile Safari/537.36";
    $h[] = "accept: application/json, text/javascript";
    $h[] = "cookie: _ga=GA1.1.901347844.1695862457";
    $h[] = "cookie: bitmedia_fid=eyJmaWQiOiI5OThjZGVjMmJkYTJhMDIxMzc5Mjc5NWI0Yzg3M2RhYiIsImZpZG5vdWEiOiJlZTYxYzg3YTJmZDljNmIxYjg3ZWFhNTY1ZWVmNWUwMSJ9";
    $h[] = "cookie: ci_session=c1a302960803b3e2a8d9bac3ceb358488e77034f";
    $h[] = "cookie: _ga_SPZ43FCWCN=GS1.1.1702447310.24.0.1702447310.0.0.0";

    return $h;
}

//SHIBA
function headRunShiba() {
    $h[] = "user-agent: Mozilla/5.0 (Linux; Android 8.1.0; ASUS_X00TD Build/OPM1; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/117.0.0.0 Mobile Safari/537.36";
    $h[] = "accept: application/json, text/javascript";
    $h[] = "cookie: bitmedia_fid=eyJmaWQiOiJkYWY2ZDVhNjlhMmVjN2VkNGE4MTZjYzMyZmQ4YTg5ZCIsImZpZG5vdWEiOiJkMThkY2EwMDJmZDY1NjgwMzZkODkyZTljYWE1Yzg0MCJ9";
    $h[] = "cookie: _ga_R9XTMF85JD=deleted";
    $h[] = "cookie: ci_session=b5e31248983791d9b63fdf9bdff622490816a3b2";
    $h[] = "cookie: _ga_R9XTMF85JD=GS1.1.1702447549.4.0.1702447549.0.0.0";
    $h[] = "cookie: _ga=GA1.2.1329130634.1695862284";;
    $h[] = "cookie: _gid=GA1.2.1599344828.1702447550";
    $h[] = "cookie: _gat_gtag_UA_27145904_58=1";

    return $h;
}

sleep(4);
system('clear');

//mengambil data index
//REFLEX
function dashboardReflex(){
    $url = "https://cloudmining.reflextoken.com/index.php/dashboard";
  return curl($url,'',headIndexReflex())[1];
}

//LITECOIN
function dashboardLitecoin(){
    $url = "https://skymining.club/litecoin/index.php/dashboard";
  return curl($url,'',headIndexLitecoin())[1];
}


//BITEX
function dashboardBitex(){
    $url = "https://skymining.club/bitcoin/index.php/dashboard";
  return curl($url,'',headRunLitecoin())[1];
}

//SHIBA
function dashboardShiba(){
    $url = "https://skymining.club/shiba/index.php/dashboard";
  return curl($url,'',headRunLitecoin())[1];
}

//----------------- reCAPTCHA v3--------------------

//Your Credentials
define('CLIENT_ID', '1042'); //****CHANGE HERE WITH YOUR VALUE*******
define('CLIENT_SECRET', 'JwMPC4SjJdnzCvAUYyUXFnaWF1f8dua60HtQMlhv'); //****CHANGE HERE WITH YOUR VALUE*******
define('EMAIL', 'coolarrayreader2@gmail.com'); //****CHANGE HERE WITH YOUR VALUE*******
define('PASSWORD', 'aulya221209'); //****CHANGE HERE WITH YOUR VALUE*******

//token file path
define('TOKEN_FILE_PATH',dirname(__FILE__).'/metabypass.token');

//requester
function request(string $url,$params,string $method,array $headers){
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST =>strtoupper($method),
    CURLOPT_POSTFIELDS =>$params,
    CURLOPT_HTTPHEADER =>$headers,
  ));
  $response = json_decode(curl_exec($curl));
  curl_close($curl);
  return $response;
}

//access_token requester
function getNewAccessToken(){

    $request_url = "https://app.metabypass.tech/CaptchaSolver/oauth/token";

    $payload=json_encode([
      "grant_type"=>"password" ,
      "client_id"=>CLIENT_ID,
      "client_secret"=>CLIENT_SECRET,
      "username"=>EMAIL,
      "password"=>PASSWORD
    ]);

    $headers = [
      'Content-Type: application/json',
      'Accept: application/json'
    ];
    $response=request($request_url,$payload,'POST',$headers);

    if(!empty($response->access_token)){
      file_put_contents(TOKEN_FILE_PATH,$response->access_token);
      return $response->access_token;
    }else{
      echo 'error! unauth';
      die();
    }
}

//reCAPTCHA v3 requester
function reCAPTCHAV3($url,$site_key){

    $request_url = "https://app.metabypass.tech/CaptchaSolver/api/v1/services/bypassReCaptcha";
    $payload=json_encode([
      "url"=>$url ,
      "sitekey"=>$site_key,
      "version"=>3,
    ]);

   
    #generate access token
    if(file_exists(TOKEN_FILE_PATH)){
        $access_token=file_get_contents(TOKEN_FILE_PATH);
    }else{
        $access_token=getNewAccessToken();
    }
    
    $headers = [
      'Content-Type: application/json',
      'Accept: application/json',
      'Authorization: Bearer '.$access_token,
    ];

    $response = request($request_url,$payload,'POST',$headers);

    if(!empty($response->status_code) ){

      if($response->status_code==401){
          $access_token=getNewAccessToken();

          $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer '.$access_token,
          ];
          $response = request($request_url,$payload,'POST',$headers);
      }
      
      if($response->status_code==200){
        return $response->data->RecaptchaResponse;
      }else{
        return false;
      }

    }

    return false;
}

//=====================================================================================
//=====================================================================================
//REFLEX
function startReflex($rc3Reflex, $header){
    $url = "https://cloudmining.reflextoken.com/index.php/miners/startMining";
    $data = http_build_query(array('token'=>$rc3Reflex));
    return curl($url, $data, $header)[1];
}

//LITECOIN
function startLitecoin($rc3Litex, $header){
    $url = "https://skymining.club/litecoin/index.php/miners/startMining";
    $data = http_build_query(array('token'=>$rc3Litex));
    return curl($url, $data, $header)[1];
}

//BITEX
function startBitex($rc3Bitex, $header){
    $url = "https://skymining.club/bitcoin/index.php/miners/startMining";
    $data = http_build_query(array('token'=>$rc3Bitex));
    return curl($url, $data, $header)[1];
}

//SHIBA
function startShiba($rc3Shiba, $header){
    $url = "https://skymining.club/shiba/index.php/miners/startMining";
    $data = http_build_query(array('token'=>$rc3Shiba));
    return curl($url, $data, $header)[1];
}

//=====================================================================================
//=====================================================================================

//REFLEX
function getRunReflex(){
    $url = "https://cloudmining.reflextoken.com/index.php/miners/runNow";
  return curl($url,'',headRunReflex())[1];
}

//LITECOIN
function getRunLitecoin(){
    $url = "https://skymining.club/litecoin/index.php/miners/runNow";
  return curl($url,'',headRunLitecoin())[1];
}


//BITEX
function getRunBitex(){
    $url = "https://skymining.club/bitcoin/index.php/miners/runNow";
  return curl($url,'',headRunLitecoin())[1];
}


//SHIBA
function getRunShiba(){
    $url = "https://skymining.club/shiba/index.php/miners/runNow";
  return curl($url,'',headRunLitecoin())[1];
}

while(true):
    //===========================================================================
    //===========================================================================
    //REFLEX
    $RunReflex = getRunReflex();

    $jsonReflex         = json_decode($RunReflex);
    $sttsReflex         = $jsonReflex->minerStatus;
    $sttsOnlineReflex   = $jsonReflex->activeMiners;
    $timeReflex         = $jsonReflex->avaiableSeconds;
    $balanceReflex      = $jsonReflex->pointBalance;

    if($sttsReflex == "1"){
        echo $WhiteTebal. "". str_repeat("=",42)."\n";
        echo $WhiteTebal. "Server        = ". $YellowTebal. "REFLEX\n";
        sleep(2);
        echo $WhiteTebal. "Aktif         = ". $PinkTebal. "   ". $sttsOnlineReflex. "".$WhiteTebal." Orang\n";
        sleep(2);
        echo $WhiteTebal. "Menambang     = ". $GreenTebal. "". $balanceReflex. "".$WhiteTebal." RFX\n";
        sleep(2);
        echo $WhiteTebal. "Waktu Claim   = ". $CyanTebal. "". waktu($timeReflex). "\n";
        sleep(2);
        echo $WhiteTebal. "". str_repeat("_",42)."\n";
    }else{
        wktClaim(10);
        $dashboardReflex = dashboardReflex();
        $tokenReflex = explode("'",explode("grecaptcha.execute('",$dashboardReflex)[1])[0];
        
        //---------------------- USAGE ----------------------
        $site_url="https://cloudmining.reflextoken.com/index.php/dashboard"; //****CHANGE HERE WITH YOUR VALUE*******
        $site_key=$tokenReflex; //****CHANGE HERE WITH YOUR VALUE*******
        $rc3Reflex=reCAPTCHAV3($site_url,$site_key);
        $startReflex = startReflex($rc3Reflex,array_merge(headIndexReflex(),array("referer: https://cloudmining.reflextoken.com/index.php/dashboard")));
        echo $WhiteTebal."Claim ". $GreenTebal."BERHASIL !!!!";
        sleep(2);
        echo "\r                                                     \r";
        echo $WhiteTebal. "\nServer        = ". $YellowTebal. "REFLEX\n";
        sleep(2);
        echo $WhiteTebal. "Aktif         = ". $PinkTebal. "   ". $sttsOnlineReflex. "".$WhiteTebal." Orang\n";
        sleep(2);
        echo $WhiteTebal. "Menambang     = ". $GreenTebal. "". $balanceReflex. "".$WhiteTebal." RFX\n";
        timer(25);
        echo $WhiteTebal. "Waktu Claim   = ". $CyanTebal. "". waktu($timeReflex). "\n";
        sleep(2);
        echo $WhiteTebal. "". str_repeat("_",42)."\n";
    }


    //===========================================================================
    //===========================================================================
    //LITEX
    $RunLitecoin = getRunLitecoin();
    
    $jsonLitecoin         = json_decode($RunLitecoin);
    $sttsLitecoin         = $jsonLitecoin->minerStatus;
    $sttsOnlineLitecoin   = $jsonLitecoin->activeMiners;
    $timeLitecoin         = $jsonLitecoin->avaiableSeconds;
    $balanceLitecoin      = $jsonLitecoin->pointBalance;
    
    if($sttsLitecoin == "1"){
        echo $WhiteTebal. "\nServer        = ". $YellowTebal. "LITEX\n";
        sleep(2);
        echo $WhiteTebal. "Aktif         = ". $PinkTebal. "   ". $sttsOnlineLitecoin. "".$WhiteTebal." Orang\n";
        sleep(2);
        echo $WhiteTebal. "Menambang     = ". $GreenTebal. "". $balanceLitecoin. "".$WhiteTebal." Litex\n";
        sleep(2);
        echo $WhiteTebal. "Waktu Claim   = ". $CyanTebal. "". waktu($timeLitecoin). "\n";
        sleep(2);
        echo $WhiteTebal. "". str_repeat("_",42)."\n";
    }else{
        wktClaim(10);
        $dashboardLitecoin = dashboardLitecoin();
        $tokenLitecoin = explode("'",explode("grecaptcha.execute('",$dashboardLitecoin)[1])[0];
        
        //---------------------- USAGE ----------------------
        $site_url="https://skymining.club/litecoin/index.php/dashboard"; //****CHANGE HERE WITH YOUR VALUE*******
        $site_key=$tokenLitecoin; //****CHANGE HERE WITH YOUR VALUE*******
        $rc3Litex=reCAPTCHAV3($site_url,$site_key);
        $startLitecoin = startLitecoin($rc3Litex,array_merge(headIndexLitecoin(),array("referer: https://skymining.club/litecoin/index.php/dashboard")));
        echo $WhiteTebal."Claim ". $GreenTebal."BERHASIL !!!!";
        sleep(2);
        echo "\r                                                     \r";
        echo $WhiteTebal. "\nServer        = ". $YellowTebal. "LITEX\n";
        sleep(2);
        echo $WhiteTebal. "Aktif         = ". $PinkTebal. "   ". $sttsOnlineLitecoin. "".$WhiteTebal." Orang\n";
        sleep(2);
        echo $WhiteTebal. "Menambang     = ". $GreenTebal. "". $balanceLitecoin. "".$WhiteTebal." Litex\n";
        timer(25);
        echo $WhiteTebal. "Waktu Claim   = ". $CyanTebal. "". waktu($timeLitecoin). "\n";
        sleep(2);
        echo $WhiteTebal. "". str_repeat("_",42)."\n";
    }

    //===========================================================================
    //===========================================================================
    //BITEX
    $RunBitex = getRunBitex();
    
    $jsonBitex         = json_decode($RunBitex);
    $sttsBitex         = $jsonBitex->minerStatus;
    $sttsOnlineBitex   = $jsonBitex->activeMiners;
    $timeBitex         = $jsonBitex->avaiableSeconds;
    $balanceBitex      = $jsonBitex->pointBalance;
    echo $RunBitex."\n";

    if($sttsBitex == "1"){
        echo $WhiteTebal. "\nServer        = ". $YellowTebal. "BITEX\n";
        sleep(2);
        echo $WhiteTebal. "Aktif         = ". $PinkTebal. "   ". $sttsOnlineBitex. "".$WhiteTebal." Orang\n";
        sleep(2);
        echo $WhiteTebal. "Menambang     = ". $GreenTebal. "". $balanceBitex. "".$WhiteTebal." Bitex\n";
        sleep(2);
        echo $WhiteTebal. "Waktu Claim   = ". $CyanTebal. "". waktu($timeBitex). "\n";
        sleep(2);
        echo $WhiteTebal. "". str_repeat("_",42)."\n";
    }else{
        wktClaim(10);
        $dashboardBitex = dashboardBitex();
        $tokenBitex = explode("'",explode("grecaptcha.execute('",$dashboardBitex)[1])[0];
    
        //---------------------- USAGE ----------------------
        $site_url="https://skymining.club/bitcoin/index.php/dashboard"; //****CHANGE HERE WITH YOUR VALUE*******
        $site_key=$tokenBitex; //****CHANGE HERE WITH YOUR VALUE*******
        $rc3Bitex=reCAPTCHAV3($site_url,$site_key);
        $startBitex = startBitex($rc3Bitex,array_merge(headIndexBitex(),array("referer: https://skymining.club/bitcoin/index.php/dashboard")));
        echo $WhiteTebal."Claim ". $GreenTebal."BERHASIL !!!!";
        sleep(2);
        echo "\r                                                     \r";
        echo $WhiteTebal. "\nServer        = ". $YellowTebal. "BITEX\n";
        sleep(2);
        echo $WhiteTebal. "Aktif         = ". $PinkTebal. "   ". $sttsOnlineBitex. "".$WhiteTebal." Orang\n";
        sleep(2);
        echo $WhiteTebal. "Menambang     = ". $GreenTebal. "". $balanceBitex. "".$WhiteTebal." Bitex\n";
        timer(25);
        echo $WhiteTebal. "Waktu Claim   = ". $CyanTebal. "". waktu($timeBitex). "\n";
        sleep(2);
        echo $WhiteTebal. "". str_repeat("_",42)."\n";
    }

    //===========================================================================
    //===========================================================================
    //SHIBA
    $RunShiba = getRunShiba();
    
    $jsonShiba         = json_decode($RunShiba);
    $sttsShiba         = $jsonShiba->minerStatus;
    $sttsOnlineShiba   = $jsonShiba->activeMiners;
    $timeShiba         = $jsonShiba->avaiableSeconds;
    $balanceShiba      = $jsonShiba->pointBalance;
    
    if($sttsShiba == "1"){
        echo $WhiteTebal. "\nServer        = ". $YellowTebal. "SHIBA\n";
        sleep(2);
        echo $WhiteTebal. "Aktif         = ". $PinkTebal. "   ". $sttsOnlineShiba. "".$WhiteTebal." Orang\n";
        sleep(2);
        echo $WhiteTebal. "Menambang     = ". $GreenTebal. "". $balanceShiba. "".$WhiteTebal." Shiba\n";
        sleep(2);
        echo $WhiteTebal. "Waktu Claim   = ". $CyanTebal. "". waktu($timeShiba). "\n";
    }else{
        wktClaim(10);
        $dashboardShiba = dashboardShiba();
        $tokenShiba = explode("'",explode("grecaptcha.execute('",$dashboardShiba)[1])[0];
    
        //---------------------- USAGE ----------------------
        $site_url="https://skymining.club/shiba/index.php/dashboard"; //****CHANGE HERE WITH YOUR VALUE*******
        $site_key=$tokenShiba; //****CHANGE HERE WITH YOUR VALUE*******
        $rc3Shiba=reCAPTCHAV3($site_url,$site_key);
        $startShiba = startShiba($rc3Shiba,array_merge(headIndexShiba(),array("referer: https://skymining.club/shiba/index.php/dashboard")));
        echo $WhiteTebal."Claim ". $GreenTebal."BERHASIL !!!!";
        sleep(2);
        echo "\r                                                     \r";
        echo $WhiteTebal. "\nServer        = ". $YellowTebal. "SHIBA\n";
        sleep(2);
        echo $WhiteTebal. "Aktif         = ". $PinkTebal. "   ". $sttsOnlineShiba. "".$WhiteTebal." Orang\n";
        sleep(2);
        echo $WhiteTebal. "Menambang     = ". $GreenTebal. "". $balanceShiba. "".$WhiteTebal." Shiba\n";
        timer(25);
        echo $WhiteTebal. "Waktu Claim   = ". $CyanTebal. "". waktu($timeShiba). "\n";
    }
    wktClaim(15);
endwhile;
