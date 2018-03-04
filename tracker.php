<?php
//THIS RETURNS THE IMAGE
header ('Location: https://img.etimg.com/thumb/msid-62723322,width-640,resizemode-4,imgsize-95865/a-marvel.jpg ');
$user_agent = $_SERVER['HTTP_USER_AGENT'];


function getOS() { 

    global $user_agent;

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function getBrowser() {

    global $user_agent;

    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}


$user_os        = getOS();
$user_browser   = getBrowser();
$details = json_decode(file_get_contents('https://www.iplocate.io/api/lookup/'.$_SERVER['REMOTE_ADDR']));
$country = $details->country;
$country_code = $details->country_code;
$city =  $details->city;
$continent = $details->continent;
$latitude = $details->latitude;
$longitude = $details->longitude;
$time_zone = $details->time_zone;
$postal_code = $details->postal_code;
$org = $details->org;
$asn = $details->asn;
$subdivision = $details->subdivision;
//THIS IS THE SCRIPT FOR THE ACTUAL TRACKING
date_default_timezone_set("Asia/Calcutta");
$httphost = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$hostadder = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
$datetime=date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
$my_file = 'log.txt';
$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
$data = " HOSTNAME : $httphost \n
  DateTime : $datetime  \n 
  IP ADDRESS : $hostadder  \n
  User Agent : $user_agent \n
  Browser: $user_browser \n
  Operating System: $user_os\n
  Country : $country  \n
  Country Code : $country_code  \n
  City : $city  \n
  Continent : $continent  \n
  Latitude : $latitude  \n
  Longitude : $longitude  \n
  Time Zone : $time_zone  \n
  Postal Code : $postal_code  \n
  Org : $org  \n
  ASN : $asn  \n
  Subdivision : $subdivision
  \n-----------------------------------------------------------\n";
fwrite($handle, $data);
?>

