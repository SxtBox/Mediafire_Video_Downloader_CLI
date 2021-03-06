<?php

namespace Proxy;

class Video_Player
{
    protected $buffer_size = 256 * 1024;
    protected $headers = array();
    protected $headers_sent = false;
    protected $debug = false;

    protected function sendHeader($header)
    {
        if ($this->debug) {
            var_dump($header);
        } else {
            header($header);
        }
    }

    public function headerCallback($ch, $data)
    {

        if (preg_match('/HTTP\/[\d.]+\s*(\d+)/', $data, $matches)) {
            $status_code = $matches[1];

            if ($status_code == 200 || $status_code == 206 || $status_code == 403 || $status_code == 404) {
                $this->headers_sent = true;
                $this->sendHeader(rtrim($data));
            }
        } else {
            $forward = array('content-type', 'content-length', 'accept-ranges', 'content-range');
            $parts = explode(':', $data, 2);
            if ($this->headers_sent && count($parts) == 2 && in_array(trim(strtolower($parts[0])), $forward)) {
                $this->sendHeader(rtrim($data));
            }
        }
        return strlen($data);
    }

    public function bodyCallback($ch, $data)
    {
        if (true) {
            echo $data;
            flush();
        }
        return strlen($data);
    }

    public function stream($url)
    {
        $ch = curl_init();
        $headers = array();
        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0';
        if (isset($_SERVER['HTTP_RANGE'])) {
            $headers[] = 'Range: ' . $_SERVER['HTTP_RANGE'];
        }
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_BUFFERSIZE, $this->buffer_size);
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, [$this, 'headerCallback']);
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, [$this, 'bodyCallback']);
        $ret = curl_exec($ch);
        // TODO: $this->logError($ch);
        $error = ($ret === false) ? sprintf('curl error: %s, num: %s', curl_error($ch), curl_errno($ch)) : null;
        curl_close($ch);
        return true;
    }
}

error_reporting(0);
set_time_limit(0);
function strip_ids($param, $main_url_1, $main_url_2){
    if(strpos($param, $main_url_1) === FALSE) return FALSE;
    if(strpos($param, $main_url_2) === FALSE) return FALSE;
    $start = strpos($param, $main_url_1) + strlen($main_url_1);
    $end = strpos($param, $main_url_2, $start);
    $return = substr($param, $start, $end - $start);
    return $return;
}

$get_video_url = trim("https://www.mediafire.com/file/b1l3wqlrrut9s5t/Butrint_Imeri_-_Xhanem.mp4/file");
$input = @file_get_contents($get_video_url) or die("Could Not Get File From: $get_video_url");
$file_name = strip_ids($input, '<div class="filename">', '</div>');
$file_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);
$regex = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
if(preg_match_all("/$regex/siU", $input, $matches)) {
	$url = $matches[2][6];
    $stream = $url;

$video = new \Proxy\Video_Player();
$video->stream($stream);
}
?>
