<?
require "include/functions.php";
dbconn();
loggedinorreturn();
//referer();
if (get_user_class() < UC_VIP) stderr("Error", "Permission denied");
$maxfilesize = 256 * 1024;
$imgtypes = array (null,'gif','jpg','png');
$scaleh = 150; // set our height size desired
$scalew = 150; // set our width size desired

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
$file = $_FILES["file"];
if (!isset($file) || $file["size"] < 1)
stderr("Upload failed", "Nothing received!");
if ($file["size"] > $maxfilesize)
stderr("Upload failed", "Sorry, that file is too large for the bit-bucket.");
$pp=pathinfo($filename = $file["name"]);
if($pp['basename'] != $filename)
stderr("Upload failed", "Bad file name.");
$tgtfile = "bitbucket/$filename";
if (file_exists($tgtfile))
stderr("Upload failed", "Sorry, a file with the name <b>" . htmlspecialchars($filename) . "</b> already exists in the bit-bucket.");

$size = getimagesize($file["tmp_name"]);
$height = $size[1];
$width = $size[0];
$it = $size[2];
if($imgtypes[$it] == null || $imgtypes[$it] != $pp['extension'])
stderr("Error", "Invalid extension: <b>GIF, JPG or PNG only!</b>");

// Scale image to appropriate avatar dimensions
$hscale=$height/$scaleh;
$wscale=$width/$scalew;
$scale=($hscale < 1 && $wscale < 1) ? 1 : ( $hscale > $wscale) ? $hscale : $wscale;
$newwidth=floor($width/$scale);
$newheight=floor($height/$scale);
$orig=($it==1)?@imagecreatefromgif($file["tmp_name"]): ($it==2)?@imagecreatefromjpeg($file["tmp_name"]):@imagecreatefrompng($file["tmp_name"]);
if(!$orig)
stderr("Image processing failed","Sorry, the uploaded $imgtypes[$it] failed processing. Try resaving the image in a graphic editor. Thanx");
$thumb = imagecreatetruecolor($newwidth, $newheight);
imagecopyresized($thumb, $orig, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
$ret=($it==1)?imagegif($thumb, $tgtfile): ($it==2)?imagejpeg($thumb, $tgtfile):imagepng($thumb, $tgtfile);

$url = str_replace(" ", "%20", htmlspecialchars("$BASEURL/bitbucket/$filename"));
stderr("Success", "Use the following URL to access the file: <b><a href=\"$url\">$url</a></b><p><a href=/bitbucket-upload>Upload another file</a>.<br>Image ". ($width=$newwidth && $height==$newheight ? "doesn't require rescaling":"Image rescaled from $height x $width to $newheight x $newwidth") .'.');
}

stdhead("Bit-bucket upload");
?>
<h1>Bit-bucket upload</h1>
<form method=post enctype="multipart/form-data">
<p><b>Maximum file size: <?=number_format($maxfilesize); ?> bytes.</b></p>
<table border=1 cellspacing=0 cellpadding=5>
<tr><td class=rowhead>Upload file</td><td><input type=file name=file size=60></td></tr>
<tr><td colspan=2 align=center><input type=submit class="groovybutton" value="Upload" class=btn></td></tr>
</table>
</form>
<p>
<table class=main width=410 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>
<font class=small><b>Disclaimer:</b> Do not upload unauthorized or illegal pictures. Uploaded pictures should be considered "public domain"; do not upload pictures you wouldn't want a stranger to have access to. Uploaded images will be scaled to <?=$scaleh ?> x <?=$scalew ?></font>
</td></tr></table>
<?
stdfoot();

?>