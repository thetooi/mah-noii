<?php
require "include/functions.php";
dbconn(false);
loggedinorreturn();
parked();
//referer();
stdhead();
begin_main_frame();
insert_smilies_frame();
end_main_frame();
stdfoot();
?>