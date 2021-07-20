<?
/////////////  Articles mod based on misterb Mysql driven rules modified by hellix
ob_start("ob_gzhandler");
require "include/functions.php";
dbconn();
//referer();
stdhead("Articles");
begin_main_frame();
?>
<?
$file5 = "$CACHE/index/articles.txt";
$expire = 2*60; // 2 minutes
if (file_exists($file5) && filemtime($file5) > (time() - $expire)) {
$articles2 = unserialize(file_get_contents($file5));
} else {
$res = mysql_query("select * from articles order by id");
while ($articles1 = mysql_fetch_array($res) ) {
        $articles2[] = $articles1;
    }
    $OUTPUT = serialize($articles2);
    $fp = fopen($file5,"w");
    fputs($fp, $OUTPUT);
    fclose($fp);
}
 // end else;
if ($articles2)
{

       foreach ($articles2 as $arr)
	{
if ($arr["public"]=="yes"){
echo("<br><table width=100% border=1 cellspacing=0 cellpadding=10>");
echo("<tr><td class=colhead>:: $arr[title]</td></tr><tr><td><ul>\n");
echo(stripslashes(BBCodeToHTML($arr["text"])));
echo("</td></tr>");
end_frame(); }
elseif($arr["public"]=="no" && $arr["class"]<=$CURUSER["class"]){
echo("<br><table width=100% border=1 cellspacing=0 cellpadding=10>");
echo("<tr><td class=colhead>:: $arr[title]</td></tr><tr><td><ul>\n");
echo(stripslashes(BBCodeToHTML($arr["text"])));
echo("</td></tr>");
end_frame();
}
}
}
end_main_frame();
stdfoot(); ?>