<?php
system('clear');
error_reporting(0);
date_default_timezone_set("Asia/Jakarta");
//•
//echo str_repeat("◼",66)."\n"; panjang barisan 66

//================ warna ====================
$Red    = "\33[0;31m";
$Green  = "\33[0;32m";
$Yellow = "\33[0;33m";
$Purple = "\33[0;34m";
$Pink   = "\33[0;35m";
$Cyan   = "\33[0;36m";
$White  = "\33[0;37m";
$Normal = "\33[0m";

$RedTebal    = "\33[1;31m";
$GreenTebal  = "\33[1;32m";
$YellowTebal = "\33[1;33m";
$PurpleTebal = "\33[1;34m";
$PinkTebal   = "\33[1;35m";
$CyanTebal   = "\33[1;36m";
$WhiteTebal  = "\33[1;37m";
$NormalTebal = "\33[1m";

$RedGaris    = "\33[4;31m";
$GreenGaris  = "\33[4;32m";
$YellowGaris = "\33[4;33m";
$PurpleGaris = "\33[4;34m";
$PinkGaris   = "\33[4;35m";
$CyanGaris   = "\33[4;36m";
$WhiteGaris  = "\33[4;37m";
$NormalGaris = "\33[4m";


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
        $lama="        ".$menit." Menit ".number_format($detik,2)." detik";
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

//============================ CURL =============================================
function curl($url, $post = 0, $httpheader = 0, $proxy = 0){ // url, postdata, http headers, proxy, uagent
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_COOKIE,TRUE);
//        curl_setopt($ch, CURLOPT_COOKIEFILE,"cookie.txt");
//        curl_setopt($ch, CURLOPT_COOKIEJAR,"cookie.txt");
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


//Menyimpan data dengan format JSON
function save($data,$data_post){
    if(!file_get_contents($data)){
        file_put_contents($data,"[]");
    }
    
    $json=json_decode(file_get_contents($data),1);
    $arr=array_merge($json,$data_post);
    file_put_contents($data,json_encode($arr,JSON_PRETTY_PRINT));
}

//jika file json ada
if (!file_exists("walet.json")) {
    system('clear');
    while ("true") {
        $a = readline("\033[1;97mWallet Doge : \033[1;92m");
        if (!$a == "") {
            break;
        }
        system('clear');
    }
    while ("true") {
        $d = readline("\033[1;97mApiKey 2Captcha : \033[1;92m");
        if (!$d == "") {
            break;
        }
        system('clear');
    }
    $data = ["wallet" => $a, "api" => $d];
    save("walet.json", $data);
}
//mengambil data json yang disimpan
$wal=json_decode(file_get_contents('coba.json'),1);

// menampilkan data array json menggunakan []
//dengan variable yang ingin ditampilkan
echo $wal['nm'];

//========================= PARSING HEADER =========================
function head() {
    $h[] = "";
    
    return $h;
}

//========================= PARSING GET ============================
function get($url){
  return curl($url,'',head())[1];
}

//========================= PARSING POST============================
function post($url,$data){
  return curl($url,$data,head())[1];
}

function login($wl,$token,$header){
  $url="https://iqfaucet.com/";
  $data=http_build_query(array("address"=>$wl,"token"=>$token));
  return curl($url,$data,$header)[1];
}

//========================= PARSING DATA ===========================
function data($get){
    $a = explode('', $get);
    $b = explode('', $a[1]);
    return $b[0];
// cara singkat
$token = explode('">',explode('<input type="hidden" name="csrf_token_name" id="token" value="',$get)[1])[0];
}


//======================== PARSING DATA JSON =======================
function ($get){
    $json = json_decode($get);
    $integral = $json->data->integral;
}

//======================== WAKTU PENDING ===========================
function timer($tmr)
{ 
     $timr=time()+$tmr; 
      while(true): 
      echo "\r                            \r"; 
      $res=$timr-time(); 
      if($res < 1){break;} 
      echo "\33[1;37mData sedang diproses \33[1;31m".date('s',$res); 
      sleep(1); 
      endwhile;
}

//membuka link
system("xdg-open https://");

//PROSES BUILD login
$veri=verif($ve,$to,array_merge(head(),array("referer: https://iqfaucet.com/index.php")));


//save image
function save_image($inPath,$outPath)
{ //Download images from remote server
    $in=    fopen($inPath, "rb");
    $out=   fopen($outPath, "wb");
    while ($chunk = fread($in,8192))
    {
        fwrite($out, $chunk, 8192);
    }
    fclose($in);
    fclose($out);
}
save_image($imgCapthcha,'image.jpg');