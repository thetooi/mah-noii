<?
require "include/functions.php";
dbconn(false);
loggedinorreturn();
parked();
//referer();
stdhead(chat);
//// Shoutbox

?>
<h2>Shoutbox</h2>
        <script language=javascript>
function SmileIT(smile,form,text){
   document.forms[form].elements[text].value = document.forms[form].elements[text].value+" "+smile+" ";
   document.forms[form].elements[text].focus();
}
</script>
<?
echo("<table width=80%' border='1' cellspacing='0' cellpadding='1'><tr><td class=text>\n");
echo("<iframe src='shoutbox.php' width='100%' height='450' frameborder='0' name='sbox' marginwidth='0' marginheight='0'></iframe><br><br>\n");
echo("<form action='shoutbox.php' method='get' target='sbox' name='shbox' onSubmit=\"mySubmit()\">\n");
echo("<center>Message: <input type='text' maxlength=140 name='shbox_text' size='100'>  <input type='submit' value='Post it'> <input type='hidden' name='sent' value='yes'>  \n");

echo("</td></tr></table></form>");
?>



<center><font size="1"><a href='shoutbox.php' target='sbox'><b>ReFrEsH</b></a><span class="smallfont"></center>
<center><a href="javascript: SmileIT(':-)','shbox','shbox_text')"><img border=0 src=pic/smilies/smile1.gif></a><a href="javascript: SmileIT(':smile:','shbox','shbox_text')"><img border=0 src=pic/smilies/smile2.gif></a><a href="javascript: SmileIT(':-D','shbox','shbox_text')"><img border=0 src=pic/smilies/grin.gif></a><a href="javascript: SmileIT(':evo:','shbox','shbox_text')"><img src=pic/smilies/evo.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':-|','shbox','shbox_text')"><img border=0 src=pic/smilies/noexpression.gif></a><a href="javascript: SmileIT(':-/','shbox','shbox_text')"><img border=0 src=pic/smilies/confused.gif></a><a href="javascript: SmileIT(':-(','shbox','post')"><img border=0 src=pic/smilies/sad.gif></a><a href="javascript: SmileIT(':weep:','shbox','shbox_text')"><img src=pic/smilies/weep.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':-O','shbox','shbox_text')"><img src=pic/smilies/ohmy.gif border=0></a><a href="javascript: SmileIT('8-)','shbox','shbox_text')"><img src=pic/smilies/cool1.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':yawn:','shbox','shbox_text')"><img src=pic/smilies/yawn.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':sly:','shbox','shbox_text')"><img src=pic/smilies/sly.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':greedy:','shbox','shbox_text')"><img src=pic/smilies/greedy.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':weirdo:','shbox','shbox_text')"><img src=pic/smilies/weirdo.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':sneaky:','shbox','shbox_text')"><img src=pic/smilies/sneaky.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':kiss:','shbox','shbox_text')"><img src=pic/smilies/kiss.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':geek:','shbox','shbox_text')"><img src=pic/smilies/geek.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':evil:','shbox','shbox_text')"><img src=pic/smilies/evil.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':yucky:','shbox','shbox_text')"><img src=pic/smilies/yucky.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':shit:','shbox','shbox_text')"><img src=pic/smilies/shit.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':?:','shbox','shbox_text')"><img src=pic/smilies/question.gif width="18" height="18" border=0></a><a href="javascript: SmileIT(':!:','shbox','shbox_text')"><img src=pic/smilies/idea.gif width="18" height="18" border=0></a></center>
<br></br>


</center><p>

<?
stdfoot();
?>