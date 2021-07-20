<?
require ("include/functions.php");
dbconn();
$res = mysql_query("SELECT month, day, year, countdow FROM countdow") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($res) == 0)
echo("<b>Countdown is empty</b>\n");
else
while ($arr = mysql_fetch_assoc($res))
  {
$target = mktime(0,0,0,$arr['month'],$arr['day'],$arr['year']);
$diff = $target - time();

$days = ($diff - ($diff % 86400)) / 86400;
$diff = $diff - ($days * 86400);
$hours = ($diff - ($diff % 3600)) / 3600;
$diff = $diff - ($hours * 3600);
$minutes = ($diff - ($diff % 60)) / 60;
$diff = $diff - ($minutes * 60);
$seconds = ($diff - ($diff % 1)) / 1;

header ("Content-type: image/png");
$imgname = "countdown.png";
$im = @imagecreatefrompng ($imgname);
$background_color = imagecolorallocate ($im, 0, 0, 0);
$orange = imagecolorallocate ($im, 255, 127, 36);
$yellow = imagecolorallocate ($im, 247, 246, 201);

imagestring ($im, 2, 60, 5,  $arr['countdow'], $yellow);
imagestring ($im, 3, 65, 18,  "[ $days day(s) ] [ $hours hour(s) ] [ $minutes minute(s) ] [ $seconds second(s) ]", $orange);

imagepng ($im);
imagedestroy ($im);
  } {
 }
?>
