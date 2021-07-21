
CREATE TABLE `articles` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `public` enum('yes','no') NOT NULL default 'yes',
  `class` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;


INSERT INTO `articles` VALUES(10, 'A Handy Guide to Using the Files You\\''ve Downloaded', 'Hey guys, here\\''s some info about common files that you can download from the internet,and a little bit about using these files for their intended purposes. If you\\''re stuckon what exactly a file is or how to open it maybe your answer lies ahead. If you dont\\''find your answer here, then please post in the \\"Forum\\". So without further adieu letsget the show on the road!', 'yes', 0);
INSERT INTO `articles` VALUES(11, 'Compression Files', '[B].rar .zip .ace .r01 .001[/B]\r\n\r\nThese extensions are quite common and mean that your file(s) are compressed into an \\"archive\\".\r\nThis is just a way of making the files more compact and easier to download.\r\n\r\nTo open any of those archives listed above you can use [URL=http://www.rarsoft.com/download.htm]WinRAR[/URL] (Make sure you have the latest version) or [URL=http://www.powerarchiver.com/download/]PowerArchiver[/URL].\r\n\r\nIf those progams aren\\''t working for you and you have a .zip file you can try [URL=http://www.winzip.com/download.htm]WinZip[/URL] (Trial version).\r\n\r\nIf the two first mentioned programs aren\\''t working for you and you have a .ace or .001file you can try [URL=http://www.winace.com/]Winace[/URL] (Trial version).\r\n\r\n\r\n[B].cbr .cbz[/B]\r\n\r\nThese are usually comic books in an archive format. a .cbr file is actually the samething as a .rar file and a .cbz file is the same as a .zip file. However, often whenopening them with WinRAR or WinZip it will disorder your pages. To display thesearchives properly it\\''s often best to use [URL=http://www.geocities.com/davidayton/CDisplay]CDisplay[/URL].', 'yes', 0);
INSERT INTO `articles` VALUES(12, 'Multimedia Files', '[B].avi .mpg. .mpeg .divx .xvid .wmv[/B]\r\n\r\nThese files are usually movies or TVshows, or a host of other types of media. They canbe viewed using various media players, but I suggest using[URL=http://www.inmatrix.com/files/zoomplayer_download.shtml]Zoomplayer[/URL],[URL=http://www.bsplayer.org/]BSPlayer[/URL], [URL=http://www.videolan.org/vlc/]VLC media player[/URL] or [URL=http://www.microsoft.com/windows/windowsmedia/default.aspx]Windows Media Player[/URL]. Also, you\\''ll need to make sure you havethe right codecs to play each individual file. Codecs are a tricky business sometimes so to helpyou out with your file and what exact codecs it needs try using [URL=http://www.headbands.com/gspot/download.html]GSpot[/URL]. It tells you what codecs you need. Then just look on the net to findthem, below are some common codecs and their download links for quick reference:\r\n\r\n• [URL=http://sourceforge.net/project/showfiles.php?group_id=53761&release_id=95213]ffdshow[/URL] (Recommended! (plays many formats: XviD, DivX, 3ivX, mpeg-4))\r\n• [URL=http://nic.dnsalias.com/xvid.html]XviD codec[/URL]\r\n• [URL=http://www.divx.com/divx/]DivX codec[/URL]\r\n• [URL=http://sourceforge.net/project/showfiles.php?group_id=66022&release_id=178906]ac3filter[/URL] (for AC3 soundtracks, aka \\"5.1\\")\r\n• [URL=http://tobias.everwicked.com/oggds.htm]Ogg media codec[/URL] (for .OGM files)\r\n\r\nCan\\''t find what you\\''re looking for? Check out these sites...\r\n\r\n• [URL=http://www.divx-digest.com/]DivX-Digest[/URL]\r\n• [URL=http://www.digital-digest.com/]Digital-Digest[/URL]\r\n• [URL=http://www.doom9.org/]Doom9[/URL]\r\n• [URL=http://www.dvdrhelp.com/]DVD-R Help[/URL]\r\n\r\n\r\n[B].mov[/B]\r\n\r\nThese are [URL=http://www.apple.com/quicktime/]QuickTime[/URL] files. Hopefully youwon\\''t have to open these as I hate quicktime, but if you do you can[URL=http://www.apple.com/quicktime/download/]get it here[/URL].There are however alternatives to the original program,Check out [URL=http://home.hccnet.nl/h.edskes/finalbuilds.htm]QuickTime Alternative[/URL].\r\n\r\n\r\n[B].ra .rm .ram[/B]\r\n\r\nThese are [URL=http://www.real.com/]RealPlayer[/URL] files. RealPlayer IMO is thedevils work. It installs lord knows what on your system and never really goes away whenyou want to uninstall it. Still if you insists you can get the player[URL=http://service.real.com/downloads.html]here[/URL].There are however alternatives to the original program,check out [URL=http://home.hccnet.nl/h.edskes/finalbuilds.htm]Real Alternative[/URL].\r\n\r\n\r\n[B]vcd/svcd[/B]\r\n\r\nThese can be a pain on some peoples setups, but more so, on your stand-alone DVD player.For all your vcd needs check out [URL=http://www.dvdrhelp.com/]www.dvdrhelp.com[/URL].These guys know their stuff, and can help you with all kinds of media related questions.\r\n\r\n\r\n[B].mp3 .mp2[/B]\r\n\r\nUsually music files. Play them with [URL=http://www.winamp.com/]WinAmp[/URL].\r\n\r\n\r\n[B].ogm .ogg[/B]\r\n\r\nOgg Vorbis media files. You can find out more about them and download applications[URL=http://www.vorbis.com/download.psp]here[/URL].This filetype is another music file format, but can be used for various media. You willprobably want to download the [URL=http://tobias.everwicked.com/oggds.htm]DirectShow Ogg filter[/URL] to play back OGM files. Any new version of[URL=http://www.winamp.com/]WinAmp[/URL] will also do.\r\n\r\n\r\nCD Image Files [B].bin and .cue[/B]\r\n\r\nThese are your standard images of a CD, and are used quite alot these days. To open themyou have a couple options. You can burn them using [URL=http://www.ahead.de/]Nero[/URL](Trial Version) or [URL=http://www.alcohol-software.com/]Alcohol 120%[/URL],but this proves to be soooooooo problematic for a lot of people. You should also consultthis tutorial for burning images with various software programs You can also use[URL=http://www.daemon-tools.cc/portal/portal.php]Daemon Tools[/URL], which lets youmount the image to a \\"virtual cd-rom\\", so basically it tricks your computer into thinkingthat you have another cd-rom and that you\\''re putting a cd with your image file on it intothis virtual cd-rom, it\\''s great cuz you\\''ll never make a bad cd again, Alcohol 120% alsosports a virtual cd-rom feature. Finally, if you\\''re still struggling to access the filescontained within any given image file you can use [URL=http://cdmage.cjb.net/]CDMage[/URL]to extract the files and then burn them, or just access them from your hard drive. You canalso use [URL=http://www.vcdgear.com/]VCDGear[/URL] to extract the mpeg contents of aSVCD or VCD image file such as bin/cue.\r\n\r\n\r\n[B].iso[/B]\r\n\r\nAnother type of image file that follows similar rules as .bin and .cue, only you extractor create them using [URL=http://www.winiso.com/]WinISO[/URL] or[URL=http://ww.smart-projects.net/isobuster/]ISOBuster.[/URL] Sometimes converting aproblematic .bin and .cue file to an .iso can help you burn it to a cd.\r\n\r\n\r\n[B].ccd .img .sub[/B]\r\n\r\nAll these files go together and are in the [URL=http://www.elby.ch/english/products/clone_cd/index.html] CloneCD[/URL] format. CloneCD is like most other CD-Burning programs,see the .bin and .cue section if you\\''re having problems with these files.', 'yes', 0);
INSERT INTO `articles` VALUES(13, 'Other Files', '[B].txt .doc[/B]\r\n\r\nThese are text files. .txt files can be opened with notepad or watever you default texteditor happens to be, and .doc are opened with Microsoft Word.\r\n\r\n\r\n[B].nfo[/B]\r\n\r\nThese contain information about the file you just downloaded, and it\\''s HIGHLY recommendedthat you read these! They are plain text files, often with ascii-art. You can open themwith Notepad, Wordpad, [URL=http://www.damn.to/software/nfoviewer.html]DAMN NFO Viewer[/URL]or [URL=http://www.ultraedit.com/]UltraEdit[/URL].\r\n\r\n\r\n[B].pdf[/B]\r\n\r\nOpened with [URL=http://www.adobe.com/products/acrobat/main.html]Adobe Acrobat Reader[/URL].\r\n\r\n\r\n[B].jpg .gif .tga .psd[/B]\r\n\r\nBasic image files. These files generally contain pictures, and can be opened with AdobePhotoshop or whatever your default image viewer is.\r\n\r\n\r\n[B].sfv[/B]\r\n\r\nChecks to make sure that your multi-volume archives are complete. This just lets you knowif you\\''ve downloaded something complete or not. (This is not really an issue when DL:ingvia torrent.) You can open/activate these files with [URL=http://www.traction-software.co.uk/SFVChecker/]SFVChecker[/URL] (Trial version) or [URL=http://www.big-o-software.com/products/hksfv/]hkSFV[/URL] for example.\r\n\r\n\r\n\r\n[B].par[/B]\r\nThis is a parity file, and is often used when downloading from newsgroups. These files canfill in gaps when you\\''re downloading a multi-volume archive and get corrupted or missing parts.Open them with [URL=http://www.pbclements.co.uk/QuickPar/]QuickPar[/URL].\r\n\r\n\r\n[HIGHLIGHT=#ff0000]If you have any suggestion/changes PM one of the Admins/SysOp![/HIGHLIGHT]\r\n\r\n[HIGHLIGHT=#ff0000]This file was originally written by hussdiesel at filesoup, then edited by Rhomboid and re-edited by us. [/HIGHLIGHT]  [IMG]http://84.32.126.36/richedit/smileys/YahooIM/101.gif[/IMG]    ', 'yes', 0);
INSERT INTO `articles` VALUES(14, 'Anatomy of a torrent session ', '[I](Updated to reflect the tracker changes. 14-04-2004)[/I]\r\n\r\nThere seems to be a lot of confusion about how the statistics updateswork. The following is a capture of a fullsession to see what\\''s going on behind the scenes. The clientcommunicates with the tracker via simple http GET commands. The veryfirst in this case was:\r\n\r\nGET/announce.php?info_hash=c%97%91%C5jG%951%BE%C7M%F9%BFa%03%F2%2C%ED%EE%0F&peer_id=S588-----gqQ8TqDeqaY&port=6882&uploaded=0&downloaded=0&left=753690875&event=started\r\n\r\nLet\\''s dissect this:\r\n\r\n• [B]info_hash[/B] is just the hash identifying the torrent in question;\r\n• [B]peer_id[/B], as the name suggests, identifies the client (the s588 part identifies Shad0w\\''s 5.8.8, the rest is random);\r\n• [B]port[/B] just tells the tracker which port the client will listen to for incoming connections;\r\n• [B]uploaded[/B]=0; (this and the following are the relevant ones, and are self-explanatory)\r\n• [B]downloaded[/B]=0;\r\n• [B]left[/B]=753690875 (how much left); \r\n• [B]event=started[/B] (telling the tracker that the client has just started).\r\n\r\nNotice that the client IP doesn\\''t show up here (although it can be sent by the client if it configured to do so). It\\''s up to the tracker to see it and associate it with the user_id.\r\n(Server replies will be omitted, they\\''re just lists of peer ips and respective ports.)\r\nAt this stage the user\\''s profile will be listing this torrent as being leeched.\r\n\r\n>From now on the client will keep send GETs to the tracker. We show only the first one as an example,\r\n\r\nGET/announce.php?info_hash=c%97%91%C5jG%951%BE%C7M%F9%BFa%03%F2%2C%ED%EE%0F&peer_id=S588-----gqQ8TqDeqaY&port=6882&uploaded=67960832&downloaded=40828928&left=715417851&numwant=0\r\n\r\n(\\"numwant\\" is how the client tells the tracker how many new peers it wants, in this case 0.)\r\n\r\nAs you can see at this stage the user had uploaded approx. 68MB anddownloaded approx. 40MB. Whenever the tracker receivesthese GETs it updates both the stats relative to the \\''currentlyleeching/seeding\\'' boxes and the total user upload/download stats. Theseintermediate GETs will be sent either periodically (every 15 minor so, depends on the client and tracker) or when you force a manualannounce in the client.\r\n\r\nFinally, when the client was closed it sent\r\n\r\nGET/announce.php?info_hash=c%97%91%C5jG%951%BE%C7M%F9%BFa%03%F2%2C%ED%EE%0F&peer_id=S588-----gqQ8TqDeqaY&port=6882&uploaded=754384896&downloaded=754215163&left=0&numwant=0&event=completed\r\n\r\nNotice the all-important \\"event=completed\\". It is at this stage thatthe torrent will be removed from the user\\''s profile.If for some reason (tracker down, lost connection, bad client, crash,...) this last GET doesn\\''t reachthe tracker this torrent will still be seen in the user profile untilsome tracker timeout occurs. It should be stressed that this messagewill be sent only whenclosing the client properly, not when the download is finished. (Thetracker will start listinga torrent as \\''currently seeding\\'' after it receives a GET with left=0). \r\n\r\nThere\\''s a further message that causes the torrent to be removed from the user\\''s profile, namely\\"event=stopped\\". This is usually sent when stopping in the middle of a download, e.g. by pressing \\''Cancel\\'' in Shad0w\\''s. \r\n\r\nOne last note: some clients have a pause/resume option. This will [B]not[/B] send any message to the server. Do not use it as a way of updating stats more often, it just doesn\\''t work. (Checked for Shad0w\\''s 5.8.11 and ABC 2.6.5.)', 'yes', 0);
INSERT INTO `articles` VALUES(16, 'Downloaded a movie and don\\''t know what CAM/TS/TC/SCR means?', '[B]CAM -[/B]\r\n\r\nA cam is a theater rip usually done with a digital video camera. A mini tripod issometimes used, but a lot of the time this wont be possible, so the camera make shake.Also seating placement isn\\''t always idle, and it might be filmed from an angle.If cropped properly, this is hard to tell unless there\\''s text on the screen, but a lotof times these are left with triangular borders on the top and bottom of the screen.Sound is taken from the onboard microphone of the camera, and especially in comedies,laughter can often be heard during the film. Due to these factors picture and soundquality are usually quite poor, but sometimes we\\''re lucky, and the theater will be\\''fairly empty and a fairly clear signal will be heard.\r\n\r\n\r\n[B]TELESYNC (TS) -[/B]\r\n\r\nA telesync is the same spec as a CAM except it uses an external audio source (mostlikely an audio jack in the chair for hard of hearing people). A direct audio sourcedoes not ensure a good quality audio source, as a lot of background noise can interfere.A lot of the times a telesync is filmed in an empty cinema or from the projection boothwith a professional camera, giving a better picture quality. Quality ranges drastically,check the sample before downloading the full release. A high percentage of Telesyncsare CAMs that have been mislabeled.\r\n\r\n\r\n[B]TELECINE (TC) -[/B]\r\n\r\nA telecine machine copies the film digitally from the reels. Sound and picture shouldbe very good, but due to the equipment involved and cost telecines are fairly uncommon.Generally the film will be in correct aspect ratio, although 4:3 telecines have existed.A great example is the JURASSIC PARK 3 TC done last year. TC should not be confused withTimeCode , which is a visible counter on screen throughout the film.\r\n\r\n\r\n[B]SCREENER (SCR) -[/B]\r\n\r\nA pre VHS tape, sent to rental stores, and various other places for promotional use.A screener is supplied on a VHS tape, and is usually in a 4:3 (full screen) a/r, althoughletterboxed screeners are sometimes found. The main draw back is a \\"ticker\\" (a messagethat scrolls past at the bottom of the screen, with the copyright and anti-copytelephone number). Also, if the tape contains any serial numbers, or any other markingsthat could lead to the source of the tape, these will have to be blocked, usually with ablack mark over the section. This is sometimes only for a few seconds, but unfortunatelyon some copies this will last for the entire film, and some can be quite big. Dependingon the equipment used, screener quality can range from excellent if done from a MASTERcopy, to very poor if done on an old VHS recorder thru poor capture equipment on a copiedtape. Most screeners are transferred to VCD, but a few attempts at SVCD have occurred,some looking better than others.\r\n\r\n\r\n[B]DVD-SCREENER (DVDscr) -[/B]\r\n\r\nSame premise as a screener, but transferred off a DVD. Usually letterbox , but withoutthe extras that a DVD retail would contain. The ticker is not usually in the black bars,and will disrupt the viewing. If the ripper has any skill, a DVDscr should be very good.Usually transferred to SVCD or DivX/XviD.\r\n\r\n\r\n[B]DVDRip -[/B]\r\n\r\nA copy of the final released DVD. If possible this is released PRE retail (for example,Star Wars episode 2) again, should be excellent quality. DVDrips are released in SVCDand DivX/XviD.\r\n\r\n\r\n[B]VHSRip -[/B]\r\n\r\nTransferred off a retail VHS, mainly skating/sports videos and XXX releases.\r\n\r\n\r\n[B]TVRip -[/B]\r\n\r\nTV episode that is either from Network (capped using digital cable/satellite boxes arepreferable) or PRE-AIR from satellite feeds sending the program around to networks a fewdays earlier (do not contain \\"dogs\\" but sometimes have flickers etc) Some programs suchas WWF Raw Is War contain extra parts, and the \\"dark matches\\" and camera/commentarytests are included on the rips. PDTV is capped from a digital TV PCI card, generallygiving the best results, and groups tend to release in SVCD for these. VCD/SVCD/DivX/XviDrips are all supported by the TV scene.\r\n\r\n\r\n[B]WORKPRINT (WP) -[/B]\r\n\r\nA workprint is a copy of the film that has not been finished. It can be missing scenes,music, and quality can range from excellent to very poor. Some WPs are very differentfrom the final print (Men In Black is missing all the aliens, and has actors in theirplaces) and others can contain extra scenes (Jay and Silent Bob) . WPs can be niceadditions to the collection once a good quality final has been obtained.\r\n\r\n\r\n[B]DivX Re-Enc -[/B]\r\n\r\nA DivX re-enc is a film that has been taken from its original VCD source, and re-encodedinto a small DivX file. Most commonly found on file sharers, these are usually labeledsomething like Film.Name.Group(1of2) etc. Common groups are SMR and TND. These aren\\''treally worth downloading, unless you\\''re that unsure about a film u only want a 200mb copyof it. Generally avoid.\r\n\r\n\r\n[B]Watermarks -[/B]\r\n\r\nA lot of films come from Asian Silvers/PDVD (see below) and these are tagged by thepeople responsible. Usually with a letter/initials or a little logo, generally in oneof the corners. Most famous are the \\"Z\\" \\"A\\" and \\"Globe\\" watermarks.\r\n\r\n\r\n[B]Asian Silvers / PDVD -[/B]\r\n\r\nThese are films put out by eastern bootleggers, and these are usually bought by somegroups to put out as their own. Silvers are very cheap and easily available in a lot ofcountries, and its easy to put out a release, which is why there are so many in the sceneat the moment, mainly from smaller groups who don\\''t last more than a few releases. PDVDsare the same thing pressed onto a DVD. They have removable subtitles, and the quality isusually better than the silvers. These are ripped like a normal DVD, but usually releasedas VCD.\r\n\r\n\r\n[B]Scene Tags...[/B]\r\n\r\n[B]PROPER -[/B]\r\n\r\nDue to scene rules, whoever releases the first Telesync has won that race (for example).But if the quality of that release is fairly poor, if another group has another telesync(or the same source in higher quality) then the tag PROPER is added to the folder toavoid being duped. PROPER is the most subjective tag in the scene, and a lot of peoplewill generally argue whether the PROPER is better than the original release. A lot ofgroups release PROPERS just out of desperation due to losing the race. A reason for thePROPER should always be included in the NFO.\r\n\r\n\r\n[B]LIMITED -[/B]\r\n\r\nA limited movie means it has had a limited theater run, generally opening in less than250 theaters, generally smaller films (such as art house films) are released as limited.\r\n\r\n\r\n[B]INTERNAL -[/B]\r\n\r\nAn internal release is done for several reasons. Classic DVD groups do a lot of INTERNALreleases, as they wont be dupe\\''d on it. Also lower quality theater rips are done INTERNALso not to lower the reputation of the group, or due to the amount of rips done already.An INTERNAL release is available as normal on the groups affiliate sites, but they can\\''tbe traded to other sites without request from the site ops. Some INTERNAL releases stilltrickle down to IRC/Newsgroups, it usually depends on the title and the popularity.Earlier in the year people referred to Centropy going \\"internal\\". This meant the groupwere only releasing the movies to their members and site ops. This is in a differentcontext to the usual definition.\r\n\r\n\r\n[B]STV -[/B]\r\n\r\nStraight To Video. Was never released in theaters, and therefore a lot of sites do notallow these.\r\n\r\n\r\n[B]ASPECT RATIO TAGS -[/B]\r\n\r\nThese are *WS* for widescreen (letterbox) and *FS* for Fullscreen.\r\n\r\n\r\n[B]REPACK -[/B]\r\n\r\nIf a group releases a bad rip, they will release a Repack which will fix the problems.\r\n\r\n\r\n[B]NUKED -[/B]\r\n\r\nA film can be nuked for various reasons. Individual sites will nuke for breaking theirrules (such as \\"No Telesyncs\\") but if the film has something extremely wrong with it(no soundtrack for 20mins, CD2 is incorrect film/game etc) then a global nuke will occur,and people trading it across sites will lose their credits. Nuked films can still reachother sources such as p2p/usenet, but its a good idea to check why it was nuked first incase. If a group realise there is something wrong, they can request a nuke.\r\n\r\n\r\n[B]NUKE REASONS...[/B]\r\n\r\nthis is a list of common reasons a film can be nuked for (generally DVDRip)\r\n\r\n[B]BAD A/R[/B] = bad aspect ratio, ie people appear too fat/thin\r\n[B]BAD IVTC[/B] = bad inverse telecine. process of converting framerates was incorrect.\r\n[B]INTERLACED[/B] = black lines on movement as the field order is incorrect.\r\n\r\n\r\n[B]DUPE -[/B]\r\n\r\nDupe is quite simply, if something exists already, then theres no reason for it to existagain without proper reason.', 'yes', 0);


CREATE TABLE `attachmentdownloads` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `fileid` int(10) NOT NULL default '0',
  `username` varchar(50) NOT NULL default '',
  `userid` int(10) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `downloads` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fileid_userid` (`fileid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE `attachments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `topicid` int(10) unsigned NOT NULL default '0',
  `postid` int(10) unsigned NOT NULL default '0',
  `filename` varchar(255) NOT NULL default '',
  `size` bigint(20) unsigned NOT NULL default '0',
  `owner` int(10) unsigned NOT NULL default '0',
  `downloads` int(10) unsigned NOT NULL default '0',
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `type` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `topicid` (`topicid`),
  KEY `postid` (`postid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE `avps` (
  `arg` varchar(20) NOT NULL default '',
  `value_s` text NOT NULL,
  `value_i` int(11) NOT NULL default '0',
  `value_u` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`arg`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `bans` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `addedby` int(10) unsigned NOT NULL default '0',
  `comment` varchar(255) NOT NULL default '',
  `first` int(11) default NULL,
  `last` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `first_last` (`first`,`last`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE `blocks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `blockid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `userfriend` (`userid`,`blockid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE `bookmarks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `torrentid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;


CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `sort_index` int(10) unsigned NOT NULL default '0',
  `cat_desc` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;



INSERT INTO `categories` VALUES(73, 'Blues', 'blues.png', 0, '');
INSERT INTO `categories` VALUES(72, 'Arabic', 'arabic.png', 0, '');
INSERT INTO `categories` VALUES(69, 'Ambiental', 'ambiental.png', 0, '');
INSERT INTO `categories` VALUES(43, 'Alternative', 'alternative.png', 0, '');
INSERT INTO `categories` VALUES(44, 'Country', 'country.png', 0, '');
INSERT INTO `categories` VALUES(45, 'Dance', 'Dance.png', 0, '');
INSERT INTO `categories` VALUES(46, 'DrumnBass', 'DrumBass.png', 0, '');
INSERT INTO `categories` VALUES(47, 'Electronic', 'Electronic.png', 0, '');
INSERT INTO `categories` VALUES(67, 'Funny', 'funny.png', 0, '');
INSERT INTO `categories` VALUES(70, 'Hardcore', 'hardcore.png', 0, '');
INSERT INTO `categories` VALUES(48, 'Hip-Hop', 'hiphop.png', 0, '');
INSERT INTO `categories` VALUES(49, 'House', 'house.png', 0, '');
INSERT INTO `categories` VALUES(74, 'Jazz', 'jazz.png', 0, '');
INSERT INTO `categories` VALUES(71, 'Latino', 'latino.png', 0, '');
INSERT INTO `categories` VALUES(68, 'Lautareasca', 'Lautareasca.png', 0, '');
INSERT INTO `categories` VALUES(37, 'Manele', 'Manele.png', 0, '');
INSERT INTO `categories` VALUES(64, 'Media Appz', 'mediaapzz.png', 0, '');
INSERT INTO `categories` VALUES(50, 'Metal', 'metal.png', 0, '');
INSERT INTO `categories` VALUES(52, 'Music Vids', 'musicvids.png', 0, '');
INSERT INTO `categories` VALUES(53, 'OST', 'ost.png', 0, '');
INSERT INTO `categories` VALUES(51, 'Old Music', 'oldmusic.png', 0, '');
INSERT INTO `categories` VALUES(54, 'Other', 'other.png', 0, '');
INSERT INTO `categories` VALUES(55, 'Pop', 'Pop.png', 0, '');
INSERT INTO `categories` VALUES(56, 'Psychedelic', 'Psychedelic.png', 0, '');
INSERT INTO `categories` VALUES(57, 'Punk', 'punk.png', 0, '');
INSERT INTO `categories` VALUES(65, '''R''n''B''', 'rnb.png', 0, '');
INSERT INTO `categories` VALUES(59, 'Rap', 'rap.png', 0, '');
INSERT INTO `categories` VALUES(58, 'Reggae', 'reggae.png', 0, '');
INSERT INTO `categories` VALUES(60, 'Rock', 'rock.png', 0, '');
INSERT INTO `categories` VALUES(66, 'Romaneasca', 'Romaneasca.png', 0, '');
INSERT INTO `categories` VALUES(63, 'Techno', 'Techno.png', 0, '');
INSERT INTO `categories` VALUES(62, 'Trance', 'Trance.png', 0, '');


CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user` int(10) unsigned NOT NULL default '0',
  `torrent` int(10) unsigned NOT NULL default '0',
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `text` text NOT NULL,
  `ori_text` text NOT NULL,
  `editedby` int(10) unsigned NOT NULL default '0',
  `editedat` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `user` (`user`),
  KEY `torrent` (`torrent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;



CREATE TABLE `countdow` (
  `month` text NOT NULL,
  `day` text NOT NULL,
  `year` year(4) NOT NULL,
  `countdow` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `countries` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `flagpic` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;


INSERT INTO `countries` VALUES(1, 'Sweden', 'sweden.gif');
INSERT INTO `countries` VALUES(2, 'United States of America', 'usa.gif');
INSERT INTO `countries` VALUES(3, 'Russia', 'russia.gif');
INSERT INTO `countries` VALUES(4, 'Finland', 'finland.gif');
INSERT INTO `countries` VALUES(5, 'Canada', 'canada.gif');
INSERT INTO `countries` VALUES(6, 'France', 'france.gif');
INSERT INTO `countries` VALUES(7, 'Germany', 'germany.gif');
INSERT INTO `countries` VALUES(8, 'China', 'china.gif');
INSERT INTO `countries` VALUES(9, 'Italy', 'italy.gif');
INSERT INTO `countries` VALUES(10, 'Denmark', 'denmark.gif');
INSERT INTO `countries` VALUES(11, 'Norway', 'norway.gif');
INSERT INTO `countries` VALUES(12, 'United Kingdom', 'uk.gif');
INSERT INTO `countries` VALUES(13, 'Ireland', 'ireland.gif');
INSERT INTO `countries` VALUES(14, 'Poland', 'poland.gif');
INSERT INTO `countries` VALUES(15, 'Netherlands', 'netherlands.gif');
INSERT INTO `countries` VALUES(16, 'Belgium', 'belgium.gif');
INSERT INTO `countries` VALUES(17, 'Japan', 'japan.gif');
INSERT INTO `countries` VALUES(18, 'Brazil', 'brazil.gif');
INSERT INTO `countries` VALUES(19, 'Argentina', 'argentina.gif');
INSERT INTO `countries` VALUES(20, 'Australia', 'australia.gif');
INSERT INTO `countries` VALUES(21, 'New Zealand', 'newzealand.gif');
INSERT INTO `countries` VALUES(22, 'Spain', 'spain.gif');
INSERT INTO `countries` VALUES(23, 'Portugal', 'portugal.gif');
INSERT INTO `countries` VALUES(24, 'Mexico', 'mexico.gif');
INSERT INTO `countries` VALUES(25, 'Singapore', 'singapore.gif');
INSERT INTO `countries` VALUES(67, 'India', 'india.gif');
INSERT INTO `countries` VALUES(62, 'Albania', 'albania.gif');
INSERT INTO `countries` VALUES(26, 'South Africa', 'southafrica.gif');
INSERT INTO `countries` VALUES(27, 'South Korea', 'southkorea.gif');
INSERT INTO `countries` VALUES(28, 'Jamaica', 'jamaica.gif');
INSERT INTO `countries` VALUES(29, 'Luxembourg', 'luxembourg.gif');
INSERT INTO `countries` VALUES(30, 'Hong Kong', 'hongkong.gif');
INSERT INTO `countries` VALUES(31, 'Belize', 'belize.gif');
INSERT INTO `countries` VALUES(32, 'Algeria', 'algeria.gif');
INSERT INTO `countries` VALUES(33, 'Angola', 'angola.gif');
INSERT INTO `countries` VALUES(34, 'Austria', 'austria.gif');
INSERT INTO `countries` VALUES(35, 'Yugoslavia', 'yugoslavia.gif');
INSERT INTO `countries` VALUES(36, 'Western Samoa', 'westernsamoa.gif');
INSERT INTO `countries` VALUES(37, 'Malaysia', 'malaysia.gif');
INSERT INTO `countries` VALUES(38, 'Dominican Republic', 'dominicanrep.gif');
INSERT INTO `countries` VALUES(39, 'Greece', 'greece.gif');
INSERT INTO `countries` VALUES(40, 'Guatemala', 'guatemala.gif');
INSERT INTO `countries` VALUES(41, 'Israel', 'israel.gif');
INSERT INTO `countries` VALUES(42, 'Pakistan', 'pakistan.gif');
INSERT INTO `countries` VALUES(43, 'Czech Republic', 'czechrep.gif');
INSERT INTO `countries` VALUES(44, 'Serbia', 'serbia.gif');
INSERT INTO `countries` VALUES(45, 'Seychelles', 'seychelles.gif');
INSERT INTO `countries` VALUES(46, 'Taiwan', 'taiwan.gif');
INSERT INTO `countries` VALUES(47, 'Puerto Rico', 'puertorico.gif');
INSERT INTO `countries` VALUES(48, 'Chile', 'chile.gif');
INSERT INTO `countries` VALUES(49, 'Cuba', 'cuba.gif');
INSERT INTO `countries` VALUES(50, 'Congo', 'congo.gif');
INSERT INTO `countries` VALUES(51, 'Afghanistan', 'afghanistan.gif');
INSERT INTO `countries` VALUES(52, 'Turkey', 'turkey.gif');
INSERT INTO `countries` VALUES(53, 'Uzbekistan', 'uzbekistan.gif');
INSERT INTO `countries` VALUES(54, 'Switzerland', 'switzerland.gif');
INSERT INTO `countries` VALUES(55, 'Kiribati', 'kiribati.gif');
INSERT INTO `countries` VALUES(56, 'Philippines', 'philippines.gif');
INSERT INTO `countries` VALUES(57, 'Burkina Faso', 'burkinafaso.gif');
INSERT INTO `countries` VALUES(58, 'Nigeria', 'nigeria.gif');
INSERT INTO `countries` VALUES(59, 'Iceland', 'iceland.gif');
INSERT INTO `countries` VALUES(60, 'Nauru', 'nauru.gif');
INSERT INTO `countries` VALUES(61, 'Slovenia', 'slovenia.gif');
INSERT INTO `countries` VALUES(63, 'Turkmenistan', 'turkmenistan.gif');
INSERT INTO `countries` VALUES(64, 'Bosnia Herzegovina', 'bosniaherzegovina.gif');
INSERT INTO `countries` VALUES(65, 'Andorra', 'andorra.gif');
INSERT INTO `countries` VALUES(66, 'Lithuania', 'lithuania.gif');
INSERT INTO `countries` VALUES(68, 'Netherlands Antilles', 'nethantilles.gif');
INSERT INTO `countries` VALUES(69, 'Ukraine', 'ukraine.gif');
INSERT INTO `countries` VALUES(70, 'Venezuela', 'venezuela.gif');
INSERT INTO `countries` VALUES(71, 'Hungary', 'hungary.gif');
INSERT INTO `countries` VALUES(72, 'Romania', 'romania.gif');
INSERT INTO `countries` VALUES(73, 'Vanuatu', 'vanuatu.gif');
INSERT INTO `countries` VALUES(74, 'Vietnam', 'vietnam.gif');
INSERT INTO `countries` VALUES(75, 'Trinidad & Tobago', 'trinidadandtobago.gif');
INSERT INTO `countries` VALUES(76, 'Honduras', 'honduras.gif');
INSERT INTO `countries` VALUES(77, 'Kyrgyzstan', 'kyrgyzstan.gif');
INSERT INTO `countries` VALUES(78, 'Ecuador', 'ecuador.gif');
INSERT INTO `countries` VALUES(79, 'Bahamas', 'bahamas.gif');
INSERT INTO `countries` VALUES(80, 'Peru', 'peru.gif');
INSERT INTO `countries` VALUES(81, 'Cambodia', 'cambodia.gif');
INSERT INTO `countries` VALUES(82, 'Barbados', 'barbados.gif');
INSERT INTO `countries` VALUES(83, 'Bangladesh', 'bangladesh.gif');
INSERT INTO `countries` VALUES(84, 'Laos', 'laos.gif');
INSERT INTO `countries` VALUES(85, 'Uruguay', 'uruguay.gif');
INSERT INTO `countries` VALUES(86, 'Antigua Barbuda', 'antiguabarbuda.gif');
INSERT INTO `countries` VALUES(87, 'Paraguay', 'paraguay.gif');
INSERT INTO `countries` VALUES(89, 'Thailand', 'thailand.gif');
INSERT INTO `countries` VALUES(88, 'Union of Soviet Socialist Republics', 'ussr.gif');
INSERT INTO `countries` VALUES(90, 'Senegal', 'senegal.gif');
INSERT INTO `countries` VALUES(91, 'Togo', 'togo.gif');
INSERT INTO `countries` VALUES(92, 'North Korea', 'northkorea.gif');
INSERT INTO `countries` VALUES(93, 'Croatia', 'croatia.gif');
INSERT INTO `countries` VALUES(94, 'Estonia', 'estonia.gif');
INSERT INTO `countries` VALUES(95, 'Colombia', 'colombia.gif');
INSERT INTO `countries` VALUES(96, 'Lebanon', 'lebanon.gif');
INSERT INTO `countries` VALUES(97, 'Latvia', 'latvia.gif');
INSERT INTO `countries` VALUES(98, 'Costa Rica', 'costarica.gif');
INSERT INTO `countries` VALUES(99, 'Egypt', 'egypt.gif');
INSERT INTO `countries` VALUES(100, 'Bulgaria', 'bulgaria.gif');


CREATE TABLE `faq` (
  `id` int(10) NOT NULL auto_increment,
  `type` set('categ','item') NOT NULL default 'item',
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `flag` set('0','1','2','3') NOT NULL default '1',
  `categ` int(10) NOT NULL default '0',
  `order` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;



INSERT INTO `faq` VALUES(1, 'categ', 'Site information', '', '1', 0, 1);
INSERT INTO `faq` VALUES(2, 'categ', 'User information', '', '1', 0, 2);
INSERT INTO `faq` VALUES(3, 'categ', 'Stats', '', '1', 0, 3);
INSERT INTO `faq` VALUES(4, 'categ', 'Uploading', '', '1', 0, 4);
INSERT INTO `faq` VALUES(5, 'categ', 'Downloading', '', '1', 0, 5);
INSERT INTO `faq` VALUES(6, 'categ', 'How can I improve my download speed?', '', '1', 0, 6);
INSERT INTO `faq` VALUES(7, 'categ', 'My ISP uses a transparent proxy. What should I do?', '', '1', 0, 7);
INSERT INTO `faq` VALUES(8, 'categ', 'Why can''t I connect? Is the site blocking me?', '', '1', 0, 8);
INSERT INTO `faq` VALUES(9, 'categ', 'What if I can''t find the answer to my problem here?', '', '1', 0, 9);
INSERT INTO `faq` VALUES(10, 'item', 'What is this bittorrent all about anyway? How do I get the files?', 'Check out <a class=altlink href="http://www.btfaq.com/">Brian''s BitTorrent FAQ and Guide</a>', '1', 1, 1);
INSERT INTO `faq` VALUES(11, 'item', 'Where does the donated money go?', 'TorrentBits.org is situated on a dedicated server in the Netherlands. For the moment we have monthly running costs of approximately ˆ 213.\r\n', '1', 1, 2);
INSERT INTO `faq` VALUES(12, 'item', 'Where can I get a copy of the source code?', 'Snapshots are available on the <a href=ftp://torrentbits.org/snapshots/ class=altlink>FTP</a>. Please note: We do not give any kind of support on the source code so please don''t bug us about it. If it works, great, if not too bad. Use this software at your own risk!\r\n<br><br>\r\n<a href=http://www.geocities.com/themisterofmisters/tbsourcetut-v0.1.txt>Here</a> is a nice tutorial on getting it all to work, written by one of our users. Note: This tutorial is not supported by TB. Please direct all comments on the tutorial to the author, <b>MrMister</b></a>.', '1', 1, 3);
INSERT INTO `faq` VALUES(13, 'item', 'I registered an account but did not receive the confirmation e-mail!', 'You can use <a class=altlink href=delacct.php>this form</a> to delete the account so you can re-register.\r\nNote though that if you didn''t receive the email the first time it will probably not\r\nsucceed the second time either so you should really try another email address.', '1', 2, 1);
INSERT INTO `faq` VALUES(14, 'item', 'I''ve lost my user name or password! Can you send it to me?', 'Please use <a class=altlink href=recover.php>this form</a> to have the login details mailed back to you.', '1', 2, 2);
INSERT INTO `faq` VALUES(15, 'item', 'Can you rename my account?', 'We do not rename accounts. Please create a new one. (Use <a href=delacct.php class=altlink>this form</a> to\r\ndelete your present account.)', '1', 2, 3);
INSERT INTO `faq` VALUES(16, 'item', 'Can you delete my (confirmed) account?', 'You can do it yourself by using <a href=delacct.php class=altlink>this form</a>.', '2', 2, 4);
INSERT INTO `faq` VALUES(17, 'item', 'So, what''s MY ratio?', 'Click on your <a class=altlink href=my.php>profile</a>, then on your user name (at the top).<br>\r\n<br>\r\nIt''s important to distinguish between your overall ratio and the individual ratio on each torrent\r\nyou may be seeding or leeching. The overall ratio takes into account the total uploaded and downloaded\r\nfrom your account since you joined the site. The individual ratio takes into account those values for each torrent.<br>\r\n<br>\r\nYou may see two symbols instead of a number: &quot;Inf.&quot;, which is just an abbreviation for Infinity, and\r\nmeans that you have downloaded 0 bytes while uploading a non-zero amount (ul/dl becomes infinity); &quot;---&quot;,\r\nwhich should be read as &quot;non-available&quot;, and shows up when you have both downloaded and uploaded 0 bytes\r\n(ul/dl = 0/0 which is an indeterminate amount).', '1', 2, 5);
INSERT INTO `faq` VALUES(18, 'item', 'Why is my IP displayed on my details page?', 'Only you and the site moderators can view your IP address and email. Regular users do not see that information.', '1', 2, 6);
INSERT INTO `faq` VALUES(19, 'item', 'Help! I cannot login!? (a.k.a. Login of Death)', 'This problem sometimes occurs with MSIE. Close all Internet Explorer windows and open Internet Options in the control panel. Click the Delete Cookies button. You should now be able to login.\r\n', '1', 2, 7);
INSERT INTO `faq` VALUES(20, 'item', 'My IP address is dynamic. How do I stay logged in?', 'You do not have to anymore. All you have to do is make sure you are logged in with your actual\r\nIP when starting a torrent session. After that, even if the IP changes mid-session,\r\nthe seeding or leeching will continue and the statistics will update without any problem.', '2', 2, 8);
INSERT INTO `faq` VALUES(21, 'item', 'Why is my port number reported as "---"? (And why should I care?)', 'The tracker has determined that you are firewalled or NATed and cannot accept incoming connections.\r\n<br>\r\n<br>\r\nThis means that other peers in the swarm will be unable to connect to you, only you to them. Even worse,\r\nif two peers are both in this state they will not be able to connect at all. This has obviously a\r\ndetrimental effect on the overall speed.\r\n<br>\r\n<br>\r\nThe way to solve the problem involves opening the ports used for incoming connections\r\n(the same range you defined in your client) on the firewall and/or configuring your\r\nNAT server to use a basic form of NAT\r\nfor that range instead of NAPT (the actual process differs widely between different router models.\r\nCheck your router documentation and/or support forum. You will also find lots of information on the\r\nsubject at <a class=altlink href="http://portforward.com/">PortForward</a>).', '1', 2, 9);
INSERT INTO `faq` VALUES(22, 'item', 'What are the different user classes?', '<table cellspacing=3 cellpadding=0>\r\n<tr>\r\n<td class=embedded width=100 bgcolor="#F5F4EA">&nbsp; <b>User</b></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded>The default class of new members.</td>\r\n</tr>\r\n<tr>\r\n<td class=embedded bgcolor="#F5F4EA">&nbsp; <b>Power User</b></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded>Can download DOX over 1MB and view NFO files.</td>\r\n</tr>\r\n<tr>\r\n<td class=embedded bgcolor="#F5F4EA">&nbsp; <b><img src="pic/star.gif" alt="Star"></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded>Has donated money to TorrentBits.org . </td>\r\n</tr>\r\n<tr>\r\n<td class=embedded valign=top bgcolor="#F5F4EA">&nbsp; <b>VIP</b></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded valign=top>Same privileges as Power User and is considered an Elite Member of TorrentBits. Immune to automatic demotion.</td>\r\n</tr>\r\n<tr>\r\n<td class=embedded bgcolor="#F5F4EA">&nbsp; <b>Other</b></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded>Customised title.</td>\r\n</tr>\r\n<tr>\r\n<td class=embedded bgcolor="#F5F4EA">&nbsp; <b><font color="#4040c0">Uploader</font></b></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded>Same as PU except with upload rights and immune to automatic demotion.</td>\r\n</tr>\r\n<tr>\r\n<td class=embedded valign=top bgcolor="#F5F4EA">&nbsp; <b><font color="#A83838">Moderator</font></b></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded valign=top>Can edit and delete any uploaded torrents. Can also moderate usercomments and disable accounts.</td>\r\n</tr>\r\n<tr>\r\n<td class=embedded bgcolor="#F5F4EA">&nbsp; <b><font color="#A83838">Administrator</color></b></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded>Can do just about anything.</td>\r\n</tr>\r\n<tr>\r\n<td class=embedded bgcolor="#F5F4EA">&nbsp; <b><font color="#A83838">SysOp</color></b></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded>Redbeard (site owner).</td>\r\n</tr>\r\n</table>', '1', 2, 10);
INSERT INTO `faq` VALUES(23, 'item', 'How does this promotion thing work anyway?', '<table cellspacing=3 cellpadding=0>\r\n<tr>\r\n<td class=embedded bgcolor="#F5F4EA" valign=top width=100>&nbsp; <b>Power User</b></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded valign=top>Must have been be a member for at least 4 weeks, have uploaded at least 25GB and\r\nhave a ratio at or above 1.05.<br>\r\nThe promotion is automatic when these conditions are met. Note that you will be automatically demoted from<br>\r\nthis status if your ratio drops below 0.95 at any time.</td>\r\n</tr>\r\n<tr>\r\n<td class=embedded bgcolor="#F5F4EA">&nbsp; <b><img src="pic/star.gif" alt="Star"></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded>Just donate, and send <a class=altlink href=sendmessage.php?receiver=2>Redbeard</a> - and only\r\nRedbeard - the details.</td>\r\n</tr>\r\n<tr>\r\n<td class=embedded bgcolor="#F5F4EA" valign=top>&nbsp; <b>VIP</b></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded valign=top>Assigned by mods at their discretion to users they feel contribute something special to the site.<br>\r\n(Anyone begging for VIP status will be automatically disqualified.)</td>\r\n</tr>\r\n<tr>\r\n<td class=embedded bgcolor="#F5F4EA">&nbsp; <b>Other</b></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded>Conferred by mods at their discretion (not available to Users or Power Users).</td>\r\n</tr>\r\n<tr>\r\n<td class=embedded bgcolor="#F5F4EA">&nbsp; <b><font color="#4040c0">Uploader</font></b></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded>Appointed by Admins/SysOp (see the ''Uploading'' section for conditions).</td>\r\n</tr>\r\n<tr>\r\n<td class=embedded bgcolor="#F5F4EA">&nbsp; <b><font color="#A83838">Moderator</font></b></td>\r\n<td class=embedded width=5>&nbsp;</td>\r\n<td class=embedded>You don''t ask us, we''ll ask you!</td>\r\n</tr>\r\n</table>', '1', 2, 11);
INSERT INTO `faq` VALUES(24, 'item', 'Hey! I''ve seen Power Users with less than 25GB uploaded!', 'The PU limit used to be 10GB and we didn''t demote anyone when we raised it to 25GB.', '1', 2, 12);
INSERT INTO `faq` VALUES(25, 'item', 'Why can''t my friend become a member?', 'There is a 75.000 users limit. When that number is reached we stop accepting new members. Accounts inactive for more than 42 days are automatically deleted, so keep trying. (There is no reservation or queuing system, don''t ask for that.)', '2', 2, 13);
INSERT INTO `faq` VALUES(26, 'item', 'How do I add an avatar to my profile?', 'First, find an image that you like, and that is within the\r\n<a class=altlink href=rules.php>rules</a>. Then you will have\r\nto find a place to host it, such as our own <a class=altlink href=bitbucket-upload.php>BitBucket</a>.\r\n(Other popular choices are <a class="altlink" href="http://photobucket.com/">Photobucket</a>,\r\n<a class="altlink" href="http://uploadit.org/">Upload-It!</a> or\r\n<a class="altlink" href="http://www.imageshack.us/">ImageShack</a>).\r\nAll that is left to do is copy the URL you were given when\r\nuploading it to the avatar field in your <a class="altlink" href="my.php">profile</a>.<br>\r\n<br>\r\nPlease do not make a post just to test your avatar. If everything is allright you''ll see it\r\nin your <a class="altlink" href="userdetails.php?id=<?=$CURUSER[''id'']?>">details page</a>.', '1', 2, 14);
INSERT INTO `faq` VALUES(27, 'item', 'Most common reason for stats not updating', '<ul>\r\n<li>The user is cheating. (a.k.a. &quot;Summary Ban&quot;)</li>\r\n<li>The server is overloaded and unresponsive. Just try to keep the session open until the server responds again. (Flooding the server with consecutive manual updates is not recommended.)</li>\r\n<li>You are using a faulty client. If you want to use an experimental or CVS version you do it at your own risk.</li>\r\n</ul>', '1', 3, 1);
INSERT INTO `faq` VALUES(28, 'item', 'Best practices', '<ul>\r\n<li>If a torrent you are currently leeching/seeding is not listed on your profile, just wait or force a manual update.</li>\r\n<li>Make sure you exit your client properly, so that the tracker receives &quot;event=completed&quot;.</li>\r\n<li>If the tracker is down, do not stop seeding. As long as the tracker is back up before you exit the client the stats should update properly.</li>\r\n</ul>', '1', 3, 2);
INSERT INTO `faq` VALUES(29, 'item', 'May I use any bittorrent client?', 'Yes. The tracker now updates the stats correctly for all bittorrent clients. However, we still recommend\r\nthat you <b>avoid</b> the following clients:<br>\r\n<br>\r\n• BitTorrent++,<br>\r\n• Nova Torrent,<br>\r\n• TorrentStorm.<br>\r\n<br>\r\nThese clients do not report correctly to the tracker when canceling/finishing a torrent session.\r\nIf you use them then a few MB may not be counted towards\r\nthe stats near the end, and torrents may still be listed in your profile for some time after you have closed the client.<br>\r\n<br>\r\nAlso, clients in alpha or beta version should be avoided.', '1', 3, 3);
INSERT INTO `faq` VALUES(30, 'item', 'Why is a torrent I''m leeching/seeding listed several times in my profile?', 'If for some reason (e.g. pc crash, or frozen client) your client exits improperly and you restart it,\r\nit will have a new peer_id, so it will show as a new torrent. The old one will never receive a &quot;event=completed&quot;\r\nor &quot;event=stopped&quot; and will be listed until some tracker timeout. Just ignore it, it will eventually go away.', '1', 3, 4);
INSERT INTO `faq` VALUES(31, 'item', 'I''ve finished or cancelled a torrent. Why is it still listed in my profile?', 'Some clients, notably TorrentStorm and Nova Torrent, do not report properly to the tracker when canceling or finishing a torrent.\r\nIn that case the tracker will keep waiting for some message - and thus listing the torrent as seeding or leeching - until some\r\ntimeout occurs. Just ignore it, it will eventually go away.', '1', 3, 5);
INSERT INTO `faq` VALUES(32, 'item', 'Why do I sometimes see torrents I''m not leeching in my profile!?', 'When a torrent is first started, the tracker uses the IP to identify the user. Therefore the torrent will\r\nbecome associated with the user <i>who last accessed the site</i> from that IP. If you share your IP in some\r\nway (you are behind NAT/ICS, or using a proxy), and some of the persons you share it with are also users,\r\nyou may occasionally see their torrents listed in your profile. (If they start a torrent session from that\r\nIP and you were the last one to visit the site the torrent will be associated with you). Note that now\r\ntorrents listed in your profile will always count towards your total stats.', '2', 3, 6);



CREATE TABLE `files` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `torrent` int(10) unsigned NOT NULL default '0',
  `filename` varchar(255) NOT NULL default '',
  `size` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `torrent` (`torrent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;



CREATE TABLE `forums` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `description` varchar(200) default NULL,
  `sort` tinyint(3) unsigned NOT NULL default '0',
  `forid` tinyint(4) default '0',
  `postcount` int(10) unsigned NOT NULL default '0',
  `topiccount` int(10) unsigned NOT NULL default '0',
  `minclassread` tinyint(3) unsigned NOT NULL default '0',
  `minclasswrite` tinyint(3) unsigned NOT NULL default '0',
  `minclasscreate` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;



CREATE TABLE `friends` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `friendid` int(10) unsigned NOT NULL default '0',
  `confirmed` enum('yes','no') collate utf8_bin NOT NULL default 'no',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `userfriend` (`userid`,`friendid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;



CREATE TABLE `links` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `public` enum('yes','no') NOT NULL default 'yes',
  `class` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;



INSERT INTO `links` VALUES(4, 'Other pages on this site', '[LIST]\r\n[*][URL=rss.php]RSS feed[/URL] - For use with RSS-enabled software. An alternative to torrent email notifications.\r\n[*][URL=getrss.php]RSS feed (direct download)[/URL] - Links directly to the torrent file.\r\n[*][URL=bitbucket-upload]Bitbucket[/URL] - If you need a place to host your avatar or other pictures.[/LIST]', 'no', 0);
INSERT INTO `links` VALUES(5, 'BitTorrent Information', '[LIST]\r\n[*][URL=http://www.slyck.com/bt.php]Slyck\\''s Guide to Bittorrent[/URL] - Slyck\\''s version of the many FAQs available on BT. Worth the read!\r\n[*][URL=http://tpgcommunity.com/]ThePeerGroup[/URL] - BitTorrent related forum with links to many available torrent sites. \r\n[*][URL=http://www.tbdev.net/]TBdev[/URL] - Forum community where you will find the code used on various torrent sites.[/LIST]', 'yes', 0);
INSERT INTO `links` VALUES(6, 'BitTorrent Software', '[LIST]\r\n[*][URL=http://azureus.sourceforge.net/]Azureus[/URL] - Azureus is a java bittorrent client for use with both Windows & Mac OS.\r\n[*][URL=http://www.utorrent.com/]µTorrent[/URL] - µTorrent is an efficient and feature rich BitTorrent client for Windows sporting a very small footprint.\r\n[*][URL=http://www.torrentflux.com/]TorrentFlux[/URL] - PHP based Torrent client that runs on a web server.\r\n[*][URL=http://libtorrent.rakshasa.no/]rTorrent[/URL] - rTorrent is an ncurses based BitTorrent client for Linux.\r\n\r\n[B]Tools[/B]\r\n[*][URL=http://krypt.dyndns.org:81/torrent/maketorrent/]MakeTorrent[/URL] - A tool for creating torrents.\r\n[*][URL=http://torrentspy.sourceforge.net/]TorrentSpy[/URL] - Torrent file metainfo viewer.[/LIST]', 'yes', 0);
INSERT INTO `links` VALUES(9, 'BitTorrent Search Engines', '[LIST]\r\n[*][URL=http://scrapetorrent.com]ScrapeTorrent[/URL] - Huge search engine that references isohunt/torrentspy/mininova etc...\r\n[*][URL=http://www.btbot.com/]BTbot[/URL] - \\"..a popular and fast growing search engine for bittorrents.\\"\r\n[*][URL=http://www.isohunt.com/]isoHunt[/URL] - \\"..home to the most comprehensive BitTorrent search engine.\\"\r\n[*][URL=http://www.mininova.org/]MiniNova[/URL] - \\"..one of the biggest torrent listing sites.\\"\r\n[*][URL=http://www.torrentspy.com/]TorrentSpy[/URL] - Large BitTorrent search engine.[/LIST]', 'yes', 0);
INSERT INTO `links` VALUES(8, 'Music Information', '[LIST]\r\n[*][URL=http://www.gracenote.com/music/]Gracenote[/URL] - Music reference/index site.\r\n[*][URL=http://www.last.fm/]LastFM[/URL] - Track your musical listening style, and find others with similar tastes.[/LIST]', 'yes', 0);
INSERT INTO `links` VALUES(7, 'Release Indexing Sites', '[LIST]\r\n[*][URL=http://www.nforce.nl/]NFOrce[/URL] - Game and movie release tracker and forums.\r\n[*][URL=http://www.theisonews.com/]iSONEWS[/URL] - Release tracker and forums.\r\n[*][URL=http://www.swedupe.com/]SWEdupe[/URL] - Release news site.\r\n[*][URL=http://www.vcdquality.com/]VCDquality[/URL] - Release news site and quality check for movies.\r\n[*][URL=http://www.mp3shitter.com/]MP3shitter[/URL] - Release news site for MP3s.[/LIST]', 'yes', 0);


CREATE TABLE `loginattempts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ip` varchar(15) NOT NULL,
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `banned` enum('yes','no') NOT NULL default 'no',
  `attempts` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;



CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `sender` int(10) unsigned NOT NULL default '0',
  `receiver` int(10) unsigned NOT NULL default '0',
  `folder_in` int(10) NOT NULL default '0',
  `folder_out` int(10) NOT NULL default '0',
  `added` datetime default NULL,
  `subject` varchar(255) NOT NULL default '(Kein Betreff)',
  `msg` text,
  `unread` enum('yes','no') NOT NULL default 'yes',
  `poster` bigint(20) unsigned NOT NULL default '0',
  `mod_flag` enum('','open','closed') NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `receiver` (`receiver`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(11) NOT NULL default '0',
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `body` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `added` (`added`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;



CREATE TABLE `onews` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `public` enum('yes','no') NOT NULL default 'yes',
  `class` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;



CREATE TABLE `overforums` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `description` varchar(200) default NULL,
  `minclassview` tinyint(3) unsigned NOT NULL default '0',
  `forid` tinyint(3) unsigned NOT NULL default '1',
  `sort` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;



CREATE TABLE `peers` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `torrent` int(10) unsigned NOT NULL default '0',
  `peer_id` varchar(20) character set utf8 collate utf8_bin NOT NULL default '',
  `ip` varchar(64) NOT NULL default '',
  `port` smallint(5) unsigned NOT NULL default '0',
  `uploaded` bigint(20) unsigned NOT NULL default '0',
  `downloaded` bigint(20) unsigned NOT NULL default '0',
  `to_go` bigint(20) unsigned NOT NULL default '0',
  `seeder` enum('yes','no') NOT NULL default 'no',
  `started` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_action` datetime NOT NULL default '0000-00-00 00:00:00',
  `connectable` enum('yes','no') NOT NULL default 'yes',
  `userid` int(10) unsigned NOT NULL default '0',
  `agent` varchar(60) NOT NULL default '',
  `finishedat` int(10) unsigned NOT NULL default '0',
  `downloadoffset` bigint(20) unsigned NOT NULL default '0',
  `uploadoffset` bigint(20) unsigned NOT NULL default '0',
  `passkey` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `torrent_peer_id` (`torrent`,`peer_id`),
  KEY `torrent` (`torrent`),
  KEY `torrent_seeder` (`torrent`,`seeder`),
  KEY `last_action` (`last_action`),
  KEY `connectable` (`connectable`),
  KEY `userid` (`userid`),
  KEY `torrent_passkey` (`torrent`,`passkey`),
  KEY `userid_seeder` (`userid`,`seeder`),
  KEY `torrent_connectable` (`torrent`,`connectable`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;



CREATE TABLE `pmfolders` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent` int(10) unsigned NOT NULL default '0',
  `owner` int(10) unsigned NOT NULL default '0',
  `name` varchar(128) NOT NULL default '',
  `sortfield` varchar(64) NOT NULL default 'added',
  `sortorder` varchar(4) NOT NULL default 'DESC',
  `prunedays` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;



CREATE TABLE `pollanswers` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pollid` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  `selection` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`pollid`),
  KEY `selection` (`selection`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;


CREATE TABLE `polls` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `question` varchar(255) NOT NULL default '',
  `option0` varchar(150) NOT NULL default '',
  `option1` varchar(150) NOT NULL default '',
  `option2` varchar(150) NOT NULL default '',
  `option3` varchar(150) NOT NULL default '',
  `option4` varchar(150) NOT NULL default '',
  `option5` varchar(150) NOT NULL default '',
  `option6` varchar(150) NOT NULL default '',
  `option7` varchar(150) NOT NULL default '',
  `option8` varchar(150) NOT NULL default '',
  `option9` varchar(150) NOT NULL default '',
  `option10` varchar(150) NOT NULL default '',
  `option11` varchar(150) NOT NULL default '',
  `option12` varchar(150) NOT NULL default '',
  `option13` varchar(150) NOT NULL default '',
  `option14` varchar(150) NOT NULL default '',
  `option15` varchar(150) NOT NULL default '',
  `option16` varchar(150) NOT NULL default '',
  `option17` varchar(150) NOT NULL default '',
  `option18` varchar(150) NOT NULL default '',
  `option19` varchar(150) NOT NULL default '',
  `sort` enum('yes','no') NOT NULL default 'yes',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


CREATE TABLE `postpollanswers` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pollid` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  `selection` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`pollid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE `postpolls` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `question` text NOT NULL,
  `option0` varchar(40) NOT NULL default '',
  `option1` varchar(40) NOT NULL default '',
  `option2` varchar(40) NOT NULL default '',
  `option3` varchar(40) NOT NULL default '',
  `option4` varchar(40) NOT NULL default '',
  `option5` varchar(40) NOT NULL default '',
  `option6` varchar(40) NOT NULL default '',
  `option7` varchar(40) NOT NULL default '',
  `option8` varchar(40) NOT NULL default '',
  `option9` varchar(40) NOT NULL default '',
  `option10` varchar(40) NOT NULL default '',
  `option11` varchar(40) NOT NULL default '',
  `option12` varchar(40) NOT NULL default '',
  `option13` varchar(40) NOT NULL default '',
  `option14` varchar(40) NOT NULL default '',
  `option15` varchar(40) NOT NULL default '',
  `option16` varchar(40) NOT NULL default '',
  `option17` varchar(40) NOT NULL default '',
  `option18` varchar(40) NOT NULL default '',
  `option19` varchar(40) NOT NULL default '',
  `sort` enum('yes','no') NOT NULL default 'no',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `topicid` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  `added` datetime default NULL,
  `body` text,
  `editedby` int(10) unsigned NOT NULL default '0',
  `editedat` datetime NOT NULL default '0000-00-00 00:00:00',
  `smile` text,
  PRIMARY KEY  (`id`),
  KEY `topicid` (`topicid`),
  KEY `userid` (`userid`),
  FULLTEXT KEY `body` (`body`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;



CREATE TABLE `readposts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `topicid` int(10) unsigned NOT NULL default '0',
  `lastpostread` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `userid` (`id`),
  KEY `topicid` (`topicid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;



CREATE TABLE `referer` (
  `id` bigint(99) NOT NULL auto_increment,
  `url` varchar(255) NOT NULL default '',
  `ip` varchar(255) NOT NULL default '',
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=269 ;



CREATE TABLE `reports` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `reported_by` int(10) unsigned NOT NULL default '0',
  `reporting_what` int(10) unsigned NOT NULL default '0',
  `reporting_type` enum('User','Comment','Request_Comment','Offer_Comment','Request','Offer','Torrent','Hit_And_Run','Post') NOT NULL default 'Torrent',
  `reason` text NOT NULL,
  `who_delt_with_it` int(10) unsigned NOT NULL default '0',
  `delt_with` tinyint(1) NOT NULL default '0',
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `how_delt_with` text NOT NULL,
  `2nd_value` int(10) unsigned NOT NULL default '0',
  `when_delt_with` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;



CREATE TABLE `respect` (
  `userid` int(11) NOT NULL default '0',
  `respect` int(11) NOT NULL default '0',
  `bad` int(10) unsigned NOT NULL default '0',
  `good` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `UNIQUE` (`respect`,`userid`),
  KEY `respect` (`respect`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE `rules` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `public` enum('yes','no') NOT NULL default 'yes',
  `class` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;



INSERT INTO `rules` VALUES(1, 'General rules - Breaking these rules may get you banned!', '[LIST]\r\n[*]Do not defy the moderators expressed wishes!\r\n[*]Do not upload our torrents to other trackers.\r\n[*][URL=%3Ca][/URL]Disruptive behaviour within the forums will result in a warning ([IMG]http://84.32.126.36//pic/warned.gif[/IMG] ).\r\n[COLOR=#666666]After two warnings, upon receiving a third, your account will be disabled![/COLOR][/LIST]', 'yes', 0);
INSERT INTO `rules` VALUES(2, 'Downloading rules - By not following these rules you will lose download privileges!', '[LIST]\r\n[*]No aggressive behaviour or flaming in the forums.\r\n[*]No trashing of other peoples topics (SPAM).\r\n[COLOR=#666666]There is a special topic for that.[/COLOR]\r\n[*]No language other than Romanian in the forums.\r\n[COLOR=#666666]Except where noted otherwise.[/COLOR]\r\n[*]No systematic foul language (and none at all on titles).\r\n[*]No links to warez or crack sites in the forums.\r\n[*]No requesting or posting of serials, CD keys, passwords or cracks in the forums.\r\n[*]No requesting of torrents within the forum.\r\n[*]No bumping... (All bumped thread owners will receive a warning.)\r\n[*]No images larger than [B]500x500[/B], and preferably web-optimised.\r\n[*]No double posting. If you wish to post again, and yours is the last postin the thread please use the EDIT function, instead of posting a double.\r\n[*]Please ensure all questions are posted in the correct section!\r\n[COLOR=#666666]Game questions in the Games section, Apps questions in the Apps section, etc.[/COLOR]\r\n[*]Last, please read the [URL=faq.php][B]FAQ[/B][/URL] before asking any questions![/LIST]', 'yes', 0);
INSERT INTO `rules` VALUES(3, 'Avatar Guidelines - Please try to follow these guidelines', '   \r\n[LIST]\r\n[*]The allowed posted picture formats are .gif, .jpg and .png.\r\n[*]Be considerate. Resize your images to a width of 150x250 pixels and a size of no more than 150 KB.(Browsers will rescale them anyway: smaller images will be expanded and will not look good;larger images will just waste bandwidth and CPU cycles.) For now this is just a guideline butit will be automatically enforced in the near future.\r\n[*]Do not use potentially offensive material involving porn, religious material, animal / humancruelty or ideologically charged images. Mods have wide discretion on what is acceptable.If in doubt PM one.[/LIST]\r\n[SIZE=1][COLOR=#0000ff] Last update : 2008-11-15[/COLOR][/SIZE]', 'yes', 0);



CREATE TABLE `shoutbox` (
  `id` smallint(6) NOT NULL auto_increment,
  `userid` smallint(6) NOT NULL default '0',
  `username` varchar(25) NOT NULL default '',
  `date` int(11) NOT NULL default '0',
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;


CREATE TABLE `sitelog` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `added` datetime default NULL,
  `txt` text,
  PRIMARY KEY  (`id`),
  KEY `added` (`added`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;



CREATE TABLE `staffpanel` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `page_name` varchar(30) NOT NULL default '',
  `file_name` varchar(30) NOT NULL default '',
  `description` varchar(100) NOT NULL default '',
  `av_class` tinyint(3) unsigned NOT NULL default '0',
  `added_by` int(10) unsigned NOT NULL default '0',
  `added` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `file_name` (`file_name`),
  KEY `av_class` (`av_class`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;


INSERT INTO `staffpanel` VALUES(1, 'FAQ Management', 'faqmanage', 'FAQ Management', 7, 1, 1229562263);
INSERT INTO `staffpanel` VALUES(2, 'Rules Management', 'modrules', 'Rules Management', 7, 1, 1229563018);
INSERT INTO `staffpanel` VALUES(3, 'News', 'news', 'Add, edit and remove news items from the homepage', 6, 1, 1229563092);
INSERT INTO `staffpanel` VALUES(4, 'Create Poll', 'makepoll', ' Create a new poll', 6, 1, 1229563269);
INSERT INTO `staffpanel` VALUES(5, 'Unconfirmed Users', 'unco', 'Shows unconfirmed users', 6, 1, 1229563362);
INSERT INTO `staffpanel` VALUES(21, 'Referer', 'referer', 'Referer', 6, 1, 1231023423);
INSERT INTO `staffpanel` VALUES(7, 'Add User', 'adduser', 'Create new user account', 6, 1, 1229563526);
INSERT INTO `staffpanel` VALUES(8, 'Links Management', 'modlinks', 'Links Management', 7, 1, 1229580070);
INSERT INTO `staffpanel` VALUES(9, ' Request to be uploader', 'uploadapps', ' Request to be uploader', 6, 1, 1229596947);
INSERT INTO `staffpanel` VALUES(10, 'Ban IP', 'bans', ' Ban ip or ip range from the site', 6, 1, 1229598233);
INSERT INTO `staffpanel` VALUES(12, 'Test IP address', 'testip', 'Test IP address', 5, 1, 1229598651);
INSERT INTO `staffpanel` VALUES(13, 'User Search', 'usersearch', 'Administrative User Search', 5, 1, 1229598816);
INSERT INTO `staffpanel` VALUES(14, 'Articles Management', 'modarticles', 'Articles Management', 7, 1, 1229600255);
INSERT INTO `staffpanel` VALUES(15, 'Other News ', 'modonews', 'edit and remove news items from the homepage', 7, 1, 1229606664);
INSERT INTO `staffpanel` VALUES(16, 'Inactive Users', 'inactive', 'Inactive Users', 6, 1, 1229648782);
INSERT INTO `staffpanel` VALUES(17, 'Ip to Country', 'iptocountry', 'Searsh Ip to Country', 6, 1, 1229649194);
INSERT INTO `staffpanel` VALUES(18, 'Reports', 'reports', 'all reports', 5, 1, 1230700006);
INSERT INTO `staffpanel` VALUES(19, 'Maxlogin', 'maxlogin', 'failed logins', 6, 1, 1230710993);
INSERT INTO `staffpanel` VALUES(20, 'Suspect users', 'adminbookmark', 'Staff Bookmarks', 5, 1, 1230713914);
INSERT INTO `staffpanel` VALUES(22, 'Whois', 'whois', 'Whois ip', 5, 1, 1231236850);
INSERT INTO `staffpanel` VALUES(23, 'Countdown', 'countdown', 'countdown to event', 7, 1, 1231283617);
INSERT INTO `staffpanel` VALUES(24, 'Invite add', 'inviteadd', 'Add invites', 7, 1, 1231758594);
INSERT INTO `staffpanel` VALUES(25, 'Free Leech', 'freeleech', 'Free Leech, Only upload counts', 6, 1, 1231832927);
INSERT INTO `staffpanel` VALUES(26, 'Peasants', 'peasant', 'Peasants', 5, 1, 1231853874);



CREATE TABLE `stylesheets` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uri` varchar(255) NOT NULL default '',
  `name` varchar(64) NOT NULL default '',
  `default` enum('yes','no') NOT NULL default 'no',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;



CREATE TABLE `thanks` (
  `id` int(11) NOT NULL auto_increment,
  `torrentid` int(11) NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;



CREATE TABLE `topics` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `subject` varchar(40) default NULL,
  `locked` enum('yes','no') NOT NULL default 'no',
  `forumid` int(10) unsigned NOT NULL default '0',
  `lastpost` int(10) unsigned NOT NULL default '0',
  `sticky` enum('yes','no') NOT NULL default 'no',
  `views` int(10) unsigned NOT NULL default '0',
  `pollid` int(10) unsigned NOT NULL default '0',
  `polls` enum('yes','no') NOT NULL default 'no',
  `atach` enum('yes','no') NOT NULL default 'no',
  `smile` text,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`),
  KEY `subject` (`subject`),
  KEY `lastpost` (`lastpost`),
  KEY `locked_sticky` (`locked`,`sticky`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;


CREATE TABLE `torrents` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `info_hash` varchar(20) character set utf8 collate utf8_bin NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `save_as` varchar(255) NOT NULL default '',
  `search_text` text NOT NULL,
  `descr` text NOT NULL,
  `ori_descr` text NOT NULL,
  `category` int(10) unsigned NOT NULL default '0',
  `size` bigint(20) unsigned NOT NULL default '0',
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `type` enum('single','multi') NOT NULL default 'single',
  `numfiles` int(10) unsigned NOT NULL default '0',
  `comments` int(10) unsigned NOT NULL default '0',
  `views` int(10) unsigned NOT NULL default '0',
  `hits` int(10) unsigned NOT NULL default '0',
  `times_completed` int(10) unsigned NOT NULL default '0',
  `leechers` int(10) unsigned NOT NULL default '0',
  `seeders` int(10) unsigned NOT NULL default '0',
  `last_action` datetime NOT NULL default '0000-00-00 00:00:00',
  `visible` enum('yes','no') NOT NULL default 'yes',
  `banned` enum('yes','no') NOT NULL default 'no',
  `owner` int(10) unsigned NOT NULL default '0',
  `numratings` int(10) unsigned NOT NULL default '0',
  `ratingsum` int(10) unsigned NOT NULL default '0',
  `nfo` text NOT NULL,
  `completed_by` varchar(255) NOT NULL default '',
  `forcevisible` enum('yes','no') NOT NULL default 'no',
  `freeleech` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `info_hash` (`info_hash`),
  KEY `owner` (`owner`),
  KEY `visible` (`visible`),
  KEY `category_visible` (`category`,`visible`),
  KEY `seeders_lastaction` (`seeders`,`last_action`),
  KEY `seeders_lastaction_added` (`seeders`,`last_action`,`added`),
  FULLTEXT KEY `ft_search` (`search_text`,`ori_descr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;



CREATE TABLE `uploadapp` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) NOT NULL default '0',
  `applied` datetime NOT NULL default '0000-00-00 00:00:00',
  `speed` varchar(20) NOT NULL default '',
  `offer` longtext NOT NULL,
  `reason` longtext NOT NULL,
  `sites` enum('yes','no') NOT NULL default 'no',
  `sitenames` varchar(150) NOT NULL default '',
  `scene` enum('yes','no') NOT NULL default 'no',
  `creating` enum('yes','no') NOT NULL default 'no',
  `seeding` enum('yes','no') NOT NULL default 'no',
  `connectable` enum('yes','no','pending') NOT NULL default 'pending',
  `status` enum('accepted','rejected','pending') NOT NULL default 'pending',
  `moderator` varchar(40) NOT NULL default '',
  `comment` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `users` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;



CREATE TABLE `usercomments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `text` text character set latin1 collate latin1_general_ci NOT NULL,
  `ori_text` text character set latin1 collate latin1_general_ci NOT NULL,
  `editedby` int(10) unsigned NOT NULL default '0',
  `editedat` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `user` (`user`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(40) NOT NULL default '',
  `old_password` varchar(40) NOT NULL default '',
  `passhash` varchar(32) NOT NULL default '',
  `secret` varchar(20) character set utf8 collate utf8_bin NOT NULL default '',
  `email` varchar(80) NOT NULL default '',
  `showemail` enum('yes','no') NOT NULL default 'no',
  `status` enum('pending','confirmed') NOT NULL default 'pending',
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_access` datetime NOT NULL default '0000-00-00 00:00:00',
  `editsecret` varchar(20) character set utf8 collate utf8_bin NOT NULL default '',
  `privacy` enum('strong','normal','low') NOT NULL default 'normal',
  `stylesheet` int(10) default '1',
  `info` text,
  `acceptpms` enum('yes','friends','no') NOT NULL default 'yes',
  `ip` varchar(15) NOT NULL default '',
  `avatar` varchar(100) NOT NULL default '',
  `uploaded` bigint(20) unsigned NOT NULL default '0',
  `downloaded` bigint(20) unsigned NOT NULL default '0',
  `maxtorrents` tinyint(3) NOT NULL default '2',
  `country` int(10) unsigned NOT NULL default '0',
  `notifs` varchar(100) NOT NULL default '',
  `modcomment` text NOT NULL,
  `enabled` enum('yes','no') NOT NULL default 'yes',
  `avatars` enum('yes','no') NOT NULL default 'yes',
  `donor` enum('yes','no') NOT NULL default 'no',
  `warned` enum('yes','no') NOT NULL default 'no',
  `warneduntil` datetime NOT NULL default '0000-00-00 00:00:00',
  `torrentsperpage` int(3) unsigned NOT NULL default '0',
  `topicsperpage` int(3) unsigned NOT NULL default '0',
  `postsperpage` int(3) unsigned NOT NULL default '0',
  `deletepms` enum('yes','no') NOT NULL default 'yes',
  `savepms` enum('yes','no') NOT NULL default 'no',
  `loginhash` varchar(32) NOT NULL default '',
  `logintype` enum('secure','normal') NOT NULL default 'secure',
  `last_browse` int(11) NOT NULL default '0',
  `class` tinyint(3) NOT NULL default '1',
  `passkey` varchar(32) NOT NULL default '',
  `oldpasskey` varchar(255) NOT NULL default '',
  `last_check` datetime NOT NULL default '0000-00-00 00:00:00',
  `gender` enum('N/A','Male','Female') NOT NULL default 'N/A',
  `website` varchar(255) NOT NULL default '',
  `showwebsite` enum('yes','no') NOT NULL default 'no',
  `parked` enum('yes','no') NOT NULL default 'no',
  `title` varchar(60) NOT NULL default '',
  `timezone` int(10) unsigned NOT NULL default '0',
  `leechwarn` enum('yes','no') NOT NULL default 'no',
  `tzoffset` smallint(5) NOT NULL default '0',
  `showsig` enum('yes','no') NOT NULL default 'yes',
  `signature` text,
  `donated` varchar(6) NOT NULL default '0',
  `invited_by` int(10) NOT NULL default '0',
  `invites` smallint(4) NOT NULL default '0',
  `invitedate` datetime NOT NULL default '0000-00-00 00:00:00',
  `good` int(10) unsigned NOT NULL default '0',
  `bad` int(10) unsigned NOT NULL default '0',
  `musicstyle` text,
  `showfriends` enum('yes','no') NOT NULL default 'no',
  `year` varchar(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `day` varchar(255) NOT NULL,
  `support` enum('yes','no') NOT NULL default 'no',
  `supportfor` text NOT NULL,
  `forum_access` datetime NOT NULL default '0000-00-00 00:00:00',
  `subscription_pm` enum('yes','no') NOT NULL default 'no',
  `addbookmark` enum('yes','no') NOT NULL default 'no',
  `bookmcomment` text NOT NULL,
  `hideprofile` enum('yes','no') default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status_added` (`status`,`added`),
  KEY `ip` (`ip`),
  KEY `uploaded` (`uploaded`),
  KEY `downloaded` (`downloaded`),
  KEY `country` (`country`),
  KEY `last_access` (`last_access`),
  KEY `enabled` (`enabled`),
  KEY `warned` (`warned`),
  KEY `passkey` (`passkey`),
  KEY `passkey_enabled` (`passkey`,`enabled`),
  KEY `id_enabled` (`id`,`enabled`),
  KEY `username_status` (`username`,`status`),
  KEY `enabled_notifs` (`enabled`,`notifs`),
  KEY `id_ip_passkey_enabled` (`ip`,`passkey`,`enabled`,`id`),
  KEY `id_class_downloaded` (`id`,`class`,`downloaded`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

