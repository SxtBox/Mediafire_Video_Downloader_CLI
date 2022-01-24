<?php

/*
- SCRIPTI ESHTE NE PUNE E SIPER PER OPSIONE TE TJERA ME TE AVANCUARA
- KY SCRIPT ESHTE FALAS PER TE GJITHE
- THIS SCRIPT IS FREE FOR ALL

 [INSTALL]

 Mediafire Video Downloader v1.0 BETA#1
 Operating System: LINUX
 Tested on Ubuntu 14.04
 Support: MP4/Xtream Codes Panel

 [ALB]
 VENDOSE Mediafire.php NE /root/ HAP TERMINALIN EDHE SHKRUAJ chmod 777 Mediafire.php OSE chmod 777 /root/Mediafire.php
 SHARKIMI PER VIDEO NGA TERMINALI php Mediafire.php + ENTER EDHE VENDOS FULL VIDEO URL NGA Mediafire
 VIDEOT RUHEN NE /var/www/html/Mediafire

 [ENG]
 PUT Mediafire.php IN /root/ OPEN TERMINAL AND TYPE chmod 777 Mediafire.php OR chmod 777 /root/Mediafire.php
 DOWNLOADER VIDEOS FROM TERMINAL Mediafire.php + ENTER AND INSERT FULL VIDEO URL FROM Mediafire
 SAVING FOLDER /var/www/html/Mediafire

*/

error_reporting(0);
date_default_timezone_set("Europe/Tirane");

if (PHP_SAPI != "cli") {
    exit("You Can Only Run This Script From Terminal");
}

$get_root = trim( shell_exec( "whoami" ) );
if ( $get_root != "root" )
{
	
echo "\n  ┌───────────────────────────────────────────────┐ ";
echo "\n  | [ALB] > Duhet Ta Perdorni Kete Script si ROOT | ";
echo "\n  └───────────────────────────────────────────────┘ ";
echo "\n  ┌───────────────────────────────────────────────┐ ";
echo "\n  | [ENG] > You Have to Run This Script as ROOT   | ";
echo "\n  └───────────────────────────────────────────────┘\n";
    exit;
}

define("MAIN_DIR", "/var/www/html/");
shell_exec("mkdir " . MAIN_DIR . "Mediafire > /dev/null 2>&1");
shell_exec("chmod -R 755 " . MAIN_DIR . "/");
define("DOWNLOAD_DIRECTORY", MAIN_DIR . "Mediafire"); // SET DOWNLOADER DIR
chdir(DOWNLOAD_DIRECTORY . "/");

function strip_ids($param, $main_url_1, $main_url_2){
    if(strpos($param, $main_url_1) === FALSE) return FALSE;
    if(strpos($param, $main_url_2) === FALSE) return FALSE;
    $start = strpos($param, $main_url_1) + strlen($main_url_1);
    $end = strpos($param, $main_url_2, $start);
    $return = substr($param, $start, $end - $start);
    return $return;
}

system("clear");
echo "\e[40;38;5;82m \e[1;36m \e[m".PHP_EOL;
echo "\n  ┌────────────────────────────────────────────────────────────┐ ";
echo "\n  |  For More Moduled Or Updates Stay Connected to Kodi dot AL | ";
echo "\n  └────────────────────────────────────────────────────────────┘ ";
echo "\n  ┌───────────┬────────────────────────────┐ ";
echo "\n  │ Product   │ Mediafire Video Downloader │ ";
echo "\n  │ Version   │ v1.0 BETA#1                │ ";
echo "\n  │ Support   │ MP4/Xream Codes Panel      │ ";
echo "\n  │ Licence   │ FREE                       │ ";
echo "\n  │ Author    │ Olsion Bakiaj              │ ";
echo "\n  │ Email     │ TRC4@USA.COM               │ ";
echo "\n  │ Author    │ Endrit Pano                │ ";
echo "\n  │ Email     │ INFO@ALBDROID.AL           │ ";
echo "\n  │ Website   │ https://kodi.al            │ ";
echo "\n  │ Facebook  │ /albdroid.official/        │ ";
echo "\n  │ Created   │ 11 November 2019           │ ";
echo "\n  │ Modified  │ 24 January 2022            │ ";
echo "\n  └────────────────────────────────────────┘ \n";
echo "\n ┌────────────────────────────────────────────────────────────────────────────────────────────────────┐";
echo "\n | [!] Example: \e[30;48;5;82mhttps://www.mediafire.com/file/y0k2xfl18o5ikap/Fatima_Ymeri_ft_Trimi_-_Amore.mp4/file \e[0m|";
echo "\n └────────────────────────────────────────────────────────────────────────────────────────────────────┘";
echo "\n";
echo "\n";
echo "[+] Enter Video URL: ";

//$get_video_url = trim(fgets(STDIN));
$get_video_url = trim(fgets(STDIN, 1024)); // FSTR

    if (empty($get_video_url))
	{
	    echo "URL is Empty";
	}

    $get_data = @file_get_contents($get_video_url) or die("Could Not Get File From: $get_video_url");
    $file_name = strip_ids($get_data, '<div class="filename">', '</div>');
    $file_name_withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);
    //$directory = "/var/www/html/Mediafire"; // Manual
    $directory = DOWNLOAD_DIRECTORY;
    if (!file_exists($directory)) {
        mkdir($directory);
    }

    $check_file = $directory."/".$file_name;
    if (file_exists($check_file)) {
        //unlink($check_file); // Auto Delete if file exists
	echo "\n";
	exit("\e[0;31m [-] Video -> \e[30;48;5;82m$file_name\e[0m Exists in \e[5m$directory\e[0m\n\n");
    }

    $file_save_dir = $directory."/".$file_name;
    $regex = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
    if(preg_match_all("/$regex/siU", $get_data, $matches)) {
    $url = $matches[2][6];

    system("clear");
    echo "\n";
    echo " ┌────────────────────────────────┐ \n";
    echo " │ Starting Video Downloading...  │ \n";
    echo " └────────────────────────────────┘ \n";
    echo "";
    sleep(3);
    system("clear");
    echo " ┌────────────────────────────────┐ \n";
    echo " │ Get File Name...               │ \n";
    echo " └────────────────────────────────┘ \n";
    echo "";
    echo "\e[40;38;5;82m [+]\e[1;36m Title:\e[0m \e[30;48;5;82m".$file_name_withoutExt."\e[0m".PHP_EOL;
    echo "";
    echo " ┌────────────────────────────────┐ \n";
    echo " │ Downloading Please \e[5mWait...\e[0m     │ \n";
    echo " └────────────────────────────────┘ \n";
    echo "";
    // Simple curl
    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    $data = curl_exec($ch);
    $err = curl_error($ch);
    curl_close ($ch);
    echo $err;
    $file = fopen($file_save_dir, "w+");
    $fp = fputs($file, $data);
    if ($fp) {
    fclose($file);

    system("clear");
    echo "\n";
    echo " ┌────────────────────────────────┐ \n";
    echo " │ Video Downloading Was Complete │ \n";
    echo " └────────────────────────────────┘ \n";
    echo "";
    echo " ┌────────────────────────────────┐ \n";
    echo " │ DIR: -> \e[30;48;5;82m" . DOWNLOAD_DIRECTORY . "\e[0m│ \n";
    echo " └────────────────────────────────┘ \n";
    echo "\n";
    echo " Video Saved As -> \e[5m" . $file_name . "\e[0m\n";
    echo "\n";
    exit(0);
    }else{
    echo " ┌─────────────────────────────────┐ \n";
    echo " │ Video Can't Download, Try Again │ \n";
    echo " └─────────────────────────────────┘ \n";
    echo "";
    echo $matches[2][6];
    }
}
?>
