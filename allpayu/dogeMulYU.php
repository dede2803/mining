<?php
system('clear');
error_reporting(0);
date_default_timezone_set("Asia/Jakarta");
session_start();

//WARNA
$RedTebal    = "\33[1;31m";
$GreenTebal  = "\33[1;32m";
$YellowTebal = "\33[1;33m";
$PurpleTebal = "\33[1;34m";
$PinkTebal   = "\33[1;35m";
$CyanTebal   = "\33[1;36m";
$WhiteTebal  = "\33[1;37m";
$NormalTebal = "\33[1m";

function wktClaim($tmr){ 
     $timr=time()+$tmr; 
      while(true): 
      echo "\r                                            \r"; 
      $res=$timr-time(); 
      if($res < 1){break;} 
      echo "\33[1;37mTunggu, sedang melakukan claim \33[1;31m".date('s',$res)."\33[1;37m detik."; 
      sleep(1); 
      endwhile;
}

function timer($tmr){ 
     $timr=time()+$tmr; 
      while(true): 
      echo "\r                                            \r"; 
      $res=$timr-time(); 
      if($res < 1){break;} 
      echo "\33[1;37mTunggu, proses selanjutnya selama \33[1;31m".date($res)."\33[1;37m detik."; 
      sleep(1); 
      endwhile;
}


//PARSING JSON
function fetch_value($str,$find_start,$find_end) {
	$start = @strpos($str,$find_start);
	if ($start === false) {
		return "";
	}
	$length = strlen($find_start);
	$end = strpos(substr($str,$start +$length),$find_end);
	return trim(substr($str,$start +$length,$end));
}


//SAVE JSON
function save($data,$data_post){
    if(!file_get_contents($data)){
        file_put_contents($data,"[]");
    }
    
    $json=json_decode(file_get_contents($data),1);
    $arr=array_merge($json,$data_post);
    file_put_contents($data,json_encode($arr,JSON_PRETTY_PRINT));
}


//============================ CURL =============================================
function curl($url, $post = 0, $httpheader = 0, $proxy = 0){ 
    // url, postdata, http headers, proxy, uagent
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_COOKIE,TRUE);
    curl_setopt($ch, CURLOPT_COOKIEFILE,"cookieDogeMulYU.txt");
    curl_setopt($ch, CURLOPT_COOKIEJAR,"cookieDogeMulYU.txt");
    
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

function headIP(){
    $h[] = "Accept: text/html,application/xhtml+xml,application/xml;";
    $h[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/100.0.3239.111 Safari/537.1";
    return $h;
}
        
function getIP(){
    $url = "https://ipsaya.com/";
    return curl($url,'',headIP())[1];
}


for ($adaPayuTop = 0; $adaPayuTop < 50; $adaPayuTop++) 
{
    $getIP = getIP();
    $IP = explode('">',explode('<input type="hidden" name="lihatip" id="lihatip"  value="',$getIP)[1])[0];
    if($IP != ""){
        //===========================================================================================================================
        //===========================================================================================================================
        //===========================================================================================================================
        //ADA PAYU TOP
        function head(){
            //$cookie = json_decode(file_get_contents('cookie.json'),1);
            $h[] = "Accept: text/html,application/xhtml+xml,application/xml;";
            $h[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/100.0.3239.111 Safari/537.1";
            $h[] = "content-type: application/x-www-form-urlencoded";
            //$h[] = "cookie: ".$cookie['cookie'];
            return $h;
        }
        /*
        function getCookie(){
            $url = "https://adapayu.top";
            return curl($url,'',head())[0];
        }
        
        $getCookie = getCookie();
        $c1 = explode(' expires',explode('Set-Cookie:',$getCookie)[1])[0];
        $session = explode(' expires',explode('Set-Cookie:',$getCookie)[2])[0];
        
        if(file_exists("cookie.json")){
            system('rm cookie.json');
            if($session == ""){
                $s = "session_start();";
                $data=["cookie"=>$c1, "ses"=>$s];
                save("cookie.json",$data);
            }else{
                $data=["cookie"=>$c1 ." ".$session];
                save("cookie.json",$data);
            }    
        }else{
            if($session == ""){
                $s = "session_start();";
                $data=["cookie"=>$c1, "ses"=>$s];
                save("cookie.json",$data);
            }else{
                $data=["cookie"=>$c1 ." ".$session];
                save("cookie.json",$data);
            }
        }
        */
 
        function get(){
            $url = "https://multipayu.top/";
            return curl($url,'',head())[1];
        }
            
        function login($email,$token,$header){
            $url="https://multipayu.top/auth/login";
            $data=http_build_query(array("wallet"=>$email,"csrf_token_name"=>$token));
            return curl($url,$data,$header)[1];
        }
            
        function test() {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://multipayu.top/faucet/currency/doge");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
            $server_output = curl_exec ($ch);
            curl_close ($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            return $httpcode;
        }
            
        function currency(){
            $url = "https://multipayu.top/faucet/currency/doge";
            return curl($url,'',head())[1];
        }
            
        function claim($aft,$ctn,$tkn,$header){
            $url = "https://multipayu.top/faucet/verify/doge";
            $data = http_build_query(array('auto_faucet_token'=>$aft,'csrf_token_name'=>$ctn,'token'=>$tkn));
            return curl($url,$data,$header)[1];
        }
        
        function afterClaim($header){
            $url = "https://multipayu.top/faucet/currency/doge";
            return curl($url,'',$header)[1];
        }
    
        $get = get();
        $email="dede.sulaiman2803@gmail.com";
        $token = explode('">',explode('<input type="hidden" name="csrf_token_name" id="token" value="',$get)[1])[0];
        $login=login($email,$token,array_merge(head(),array("Referer: https://multipayu.top/")));
        sleep(5);
            
        while(true)
        {
            for ($adaPayuTop = 0; $adaPayuTop < 50; $adaPayuTop++) {
                $check = test();
                
                if($check=="404"){
                    echo $WhiteTebal. "Situs Website". $RedTebal." Tidak ada,".$WhiteTebal." coba periksa kembali". $YellowTebal." SITUS LINK WEBSITE..!!! \n";
                }
                $currency = currency();
                $sttsBal = explode('</span></h6>',explode('<span class="badge badge-danger">',$currency)[1])[0];
                
                if($sttsBal == "Empty"){
                    echo $check2;
                    echo $WhiteTebal. "Server ". $YellowTebal . "MULTI PAYU ". $WhiteTebal. "Coin Crypto ". $YellowTebal . "DOGE ". $RedTebal. "Sedang Kosong.".$WhiteTebal. "Tunggu Besok Lagi !!!\n";
                    sleep(2);
                    system('php feyMulYU.php');
                }
                    
                //===================================================================================================
                //===================================================================================================
                //===================================================================================================
                    
                $alert = explode(' text-center">',explode('<div class="alert alert-',$currency)[1])[0];
                if($alert == "danger"){
                    echo $WhiteTebal. "[1]. Server ". $YellowTebal . "MULTI PAYU ". $WhiteTebal. "Coin Crypto ". $YellowTebal . "DOGE ". $RedTebal. "Habis.".$WhiteTebal. "Tunggu Besok Lagi !!!\n";
                    sleep(2);
                    system('php feyMulYU.php');
                }else{
                        
                    //====================================================================================================
                    //====================================================================================================
                    //====================================================================================================
                        
                    $aft = explode('">',explode('<input type="hidden" name="auto_faucet_token" value="',$currency)[1])[0];
                    $ctn = explode('">',explode('<input type="hidden" name="csrf_token_name" id="token" value="',$currency)[1])[0];
                    $tkn = explode('">',explode('<input type="hidden" name="token" value="',$currency)[1])[0];
                    $timeClaim = explode(',',explode('let timer = ',$currency)[1])[0];
                    $balance = explode('</p>',explode('<p class="lh-1 mb-1 font-weight-bold">',$currency)[1])[0];
                    $totClaim = explode('</p>',explode('<p class="lh-1 mb-1 font-weight-bold">',$currency)[3])[0];
                        
                    if($aft == ""){
                        echo $WhiteTebal. "Server sedang ". $RedTebal." Gangguan..!!!";
                        sleep(2);
                        echo "\r                                                                   \r";
                        sleep(2);
                        system('php feyMulYU.php');
                    }else{
                        wktClaim($timeClaim);
                        sleep(2);
                        $claim = claim($aft,$ctn,$tkn,array_merge(head(),array("Referer: https://multipayu.top/faucet/currency/doge")));
                    
                        echo $WhiteTebal ."Selamat, claim ".$GreenTebal."BERHASIL.!!!";
                        sleep(2);
                        echo "\r                                                                \r";
                        sleep(2);
                        echo $WhiteTebal ."SERVER        = ". $YellowTebal. "DOGE MULTI PAYU TOP\n";
                        sleep(2);
                        echo $WhiteTebal ."Telah dikirim = ". $GreenTebal. "".$balance."\n";
                        sleep(2);
                        echo $WhiteTebal ."Jumlah claim  = ". $CyanTebal. "".$totClaim."".$WhiteTebal." claim\n";
                        sleep(2);
                        echo $PurpleTebal ."". str_repeat("_",40)."\n";
                    }
                }
            }
        }
        //sleep(2);
        //timer(10);
        //system('php bot.php');
    
    //AKHIR KONEKSI TERHUBUNG
    }else{
        echo $WhiteTebal. "Koneksi internet ". $RedTebal."TERPUTUS,".$WhiteTebal." Coba periksa kembali WiFi anda..!!!";
        sleep(2);
        echo "\r                                                                                                            \r";
        sleep(2);
    }
}