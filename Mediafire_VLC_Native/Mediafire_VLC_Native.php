<?php
/*
MEDIAFIRE HAS PROBLEMS IN SOME CHARACTERS, YOU MUST SET A FUNCTION TO DECODE THESE CHARACTERS
THE PROBLEM IS NOT WITH THE TITLE BUT WITH THE MDF SYSTEM

EXAMPLE
TITLE Ultimate Hardcore Megamix
URL https://www.mediafire.com/file/ic9ed4xjkws33fh/Ultimate_H%2Ardc%2Ar%2A_Megamix.mp4/file

TITLE_PROBLEM.png
TITLE_PROBLEM_ORIGINAL.png
MAYBE THE WORD [HARDCORE] IS ON THE OFFENSE LIST

My Advanced API https://paidcodes.albdroid.al/Mediafire/New_Deep/VLC/ [FIXED ALL ERRORS]
GET: https://paidcodes.albdroid.al/Mediafire/New_Deep/VLC/?url=https://www.mediafire.com/file/ic9ed4xjkws33fh/Ultimate_H%2Ardc%2Ar%2A_Megamix.mp4/file
*/

// INFO: IF YOU MAKE TOO MANY REQUESTS MEDIAFIRE LIMITS YOUR BANDWIDTH PASSES IT IN SLOW FOR A FEW MINUTES

error_reporting(0);
function strip_ids($param, $main_url_1, $main_url_2){
    if(strpos($param, $main_url_1) === FALSE) return FALSE;
    if(strpos($param, $main_url_2) === FALSE) return FALSE;
    $start = strpos($param, $main_url_1) + strlen($main_url_1);
    $end = strpos($param, $main_url_2, $start);
    $return = substr($param, $start, $end - $start);
    return $return;
}

// Tomorrowland 2010 (TRC4 Edit) My old Editing
$video_url = "https://www.mediafire.com/file/qwqmixrbmjwib2c/Tomorrowland_2010_%2528TRC4_Edit%2529.mp4/file";

/*
    IF YOU MAKE TOO MANY REQUESTS TO MY SERVER, THE SERVER WILL AUTOMATICALLY BLOCK YOUR IP IN BLACKLIST
    Simple Proxy .*kodi.al
*/
$Proxy_url = "https://kodi.al/??????Proxy.php?url=";
$Proxy_mode = "&mode=native";

// Proxied
//$get_video_url = trim("{$Proxy_url}{$video_url}{$Proxy_mode}");

// no Proxied
$get_video_url = trim($video_url);
$input = @file_get_contents($get_video_url) or die("Could Not Get File From: $get_video_url");
$file_name = strip_ids($input, '<div class="filename">', '</div>');
$file_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);
$regex = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
if(preg_match_all("/$regex/siU", $input, $matches)) {
	$url = $matches[2][6];
    $title = $file_name;
    $stream = $url;

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
echo "#EXTM3U Albdroid PHP Streaming Tools".PHP_EOL;
echo "#EXTINF:-1,".$title.PHP_EOL;
echo $stream;
ob_end_flush();
}
?>