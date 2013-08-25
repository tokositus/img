<?
ob_start();
$ip=$_SERVER["REMOTE_ADDR"];
$title=$_GET[q];
$offset = $_GET[offset];if($offset=='0'){$offset=1;}
$size = $_GET[size];
if($size =='small'){$size ='medium';}
elseif($size =='medium'){$size ='large|xlarge';}
elseif($size =='large'){$size = 'xxlarge';}
elseif($size =='huge'){$size = 'huge';}
else{echo 'Image not found';exit;}

$api = 'ABQIAAAA-ZesnkkYFpZjKpJQKXfF-BSPv8AlflX-SZ24KNL5KscO-A-k1RQ4Qa4HTK-alKI4JwupksVDltVU-Q';
function get_match($regex,$content){preg_match($regex,$content,$matches);return $matches[1];}
function get_data($url){
$ch = curl_init();
$timeout=25;
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; rv:10.0.1) Gecko/20100101 Firefox/10.0.1');
curl_setopt($ch,CURLOPT_REFERER,$_SERVER['HTTP_REFERER']);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
$data = curl_exec($ch);curl_close($ch);return $data;}

function gabutuh($string){
$string= $string;
$string= preg_replace('/&.+?;/', ' ', $string);
$string= preg_replace('/\s+/', ' ', $string);
$string= preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', ' ', $string);
$string= preg_replace('|-+|', ' ', $string);
$string= preg_replace('/&#?[a-z0-9]+;/i',' ',$string);
$string= preg_replace('/[^%A-Za-z0-9 _-]/', ' ', $string);
$string= preg_replace('/[0-9]/', '', $string);
$string= str_replace('_', ' ', $string);
$string= trim($string);
$string = preg_replace('/\s{2,}/',' ', $string);
return $string;
}

$link = "http://ajax.googleapis.com/ajax/services/search/images?userip=".$ip."&v=1.0&key=".$api."&start=".$offset."&rsz=1&imgsz=".$size."&q=".str_replace(' ','+',gabutuh($title));
$img = get_data($link);
$image = get_match('/"unescapedUrl":"(.*)"/isU',$img);

$jpg = strpos($image,'.jpg');
$png = strpos($image,'.png');
$gif = strpos($image,'.gif');
$jpeg = strpos($image,'.jpeg');

if($jpg!==false){
header('Content-type: image/jpg');
}elseif($png!==false){
header('Content-type: image/png');
}elseif($gif!==false){
header('Content-type: image/gif');
}elseif($jpeg!==false){
header('Content-type: image/jpeg');
}
header('Cache-Control: max-age=864000, must-revalidate');
header('Content-transfer-encoding: binary');
$gmt_mtime = gmdate('D, d M Y H:i:s', time() ) . ' GMT';
header("Last-Modified: " . $gmt_mtime );

readfile($image);header('Content-Length: ' . ob_get_length());
ob_end_flush();
?>
