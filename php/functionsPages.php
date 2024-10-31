<?php

global $ptplChangeColor;
global $ptplMainColor;
global $ptplSpreadColor;

$ptplChangeColor = true;
$ptplSpreadColor = 25;
for($c=0;$c<3;++$c) {
	$ptplMainColor[$c] = rand(0+$ptplSpreadColor,255-$ptplSpreadColor);
}

function ptplStyle () {
?>
	<style>
		@font-face
		{
			font-family: pluginsTalkFont;
			src: url('<?php echo PTPL_BASE_URL.'/assets/pluginsTalk.ttf'; ?>');
		} 
		#ptMainContent {
			font-family: pluginsTalkFont,century gothic, Segoe UI Light, Segoe UI, open sans, arial;
			font-size: 25px;
		}
		.menu_toggle {
			padding:15px 15px 15px 15px;
			color: black;
			cursor: pointer;
			font-size:22px;	
		}
		.menu_toggle a {
			color: black;
			text-decoration: none;
		}
		.toggle_content {
			padding:15px 15px 15px 15px;
			overflow: hidden;
			font-size: 16px;
			letter-spacing: 1px;
		}
		.toggle_content a {
			text-decoration: none;
		}
		.toggle_content button {
			padding: 4px 10px;
		}
	</style>
<?php
}

function ptplShowHelp () {
?>
<br></br>
<div class="menu_toggle" style="background:<?php echo ptplGetColor(); ?>;"><a href="http://pluginstalk.com/contact" target="_blank">Need Any Help & Support?</a></div>
	<div class="toggle_content" style="background:<?php echo ptplGetColor(); ?>;">
		<p>
			Don&#8217;t know how to use the plugin? Or do you have any problem using our plugin?<br/>
			Just leave a comment on <a href="http://dev.pluginstalk.com/social-statistics" target="_blank">this page</a> or you can directly <a href="http://pluginstalk.com/contact" target="_blank">contact us by email</a> ( contact@pluginstalk.com )
		</p>
	</div>
<?php
}

function ptplShowHeader () {
?>
	<div style="overflow: hidden">
		<div style="height: 150px; float: left">
			<a href="http://pluginstalk.com" target="_blank"><img src="<?php echo PTPL_BASE_URL.'/images/logo_x150.png' ?>" style="height: inherit;"></a>
		</div>
		<div style="float: right">
			<a href="http://www.PluginsTalk.com" target="_blank"><img src="<?php echo PTPL_BASE_URL.'/images/visitWebsite.png' ?>"  border="0" width="163px"></a>
			<br />
			<a href="https://www.facebook.com/PluginsTalk" target="_blank"><img src="<?php echo PTPL_BASE_URL.'/images/likeUsOnFacebook.png' ?>"  border="0"></a>
			<br />
			<a href="https://www.twitter.com/PluginsTalk" target="_blank"><img src="<?php echo PTPL_BASE_URL.'/images/followUsOnTwitter.png' ?>"  border="0"></a>
		</div>
	</div>
<?php
}


function ptplShowLinkToUs () {
?>
	<div class="menu_toggle" style="background:<?php echo ptplGetColor(); ?>;">Link To Us</div>
	<div class="toggle_content" style="background:<?php echo ptplGetColor(); ?>;">
		<p>
		If you like my articles, my work or my plugins and you want to join me through social media then I'm available for you:
		<p>
		<p>
		<a href="https://www.facebook.com/PluginsTalk" target="_blank"><img src="<?php echo PTPL_BASE_URL.'/images/likeUsOnFacebook.png' ?>"  border="0"></a> <a href="https://www.twitter.com/PluginsTalk" target="_blank"><img src="<?php echo PTPL_BASE_URL.'/images/followUsOnTwitter.png' ?>"  border="0"></a> <a href="http://www.PluginsTalk.com" target="_blank"><img src="<?php echo PTPL_BASE_URL.'/images/visitWebsite.png' ?>"  border="0"></a>
		</p>
	</div>
<?php
}

function ptplStartOutput (){
	echo '<div id="ptMainContent">';
}

function ptplEndOutput (){
	echo '</div>';
}

function ptplGetColor(){
	global $ptplChangeColor;	
	global $ptplColorCode;
	global $ptplMainColor;
	global $ptplSpreadColor;
	
	
	if( $ptplChangeColor ) {
		$ptplChangeColor = false;
	
		$r = rand($ptplMainColor[0]-$ptplSpreadColor, $ptplMainColor[0]+$ptplSpreadColor);
		$g = rand($ptplMainColor[1]-$ptplSpreadColor, $ptplMainColor[1]+$ptplSpreadColor);
		$b = rand($ptplMainColor[2]-$ptplSpreadColor, $ptplMainColor[2]+$ptplSpreadColor); 
	
		//$color = '#' . strtoupper(dechex(rand(0,10000000)));
		if ($r + $g + $b > 382){ // will have to experiment with this number
			$ptplColorCode = "rgb($r,$g,$b);color:black";
			return $ptplColorCode;
		} else {
			$ptplColorCode = "rgb($r,$g,$b);color:white";
			return $ptplColorCode;
		}
	} else {
		$ptplChangeColor = true;
		return $ptplColorCode;
	}
}


function ptplShowAboutPluginsTalk () {
?>

<div style="overflow:hidden;">
	<div class="menu_toggle" style="background:<?php echo ptplGetColor(); ?>;"><a href="http://pluginstalk.com" target="_blank">Something About PluginsTalk.com</a></div>
	<div class="toggle_content" style="background:<?php echo ptplGetColor(); ?>;">
		<p><a href="http://pluginstalk.com" target="_blank">PluginsTalk.com</a> is just another website among all of the websites where we strive hard to provide you the detailed information about web browser&#8217;s plugins. The information we provide includes the steps of plugin installation, how does the plugin work, what are the settings of plugin and how we can use the plugin in most effective way. You'll find plugins which you already know about, which you use daily; with some new and most downloaded plugins. We tell about plugins of all major browsers like: Mozilla Firefox, Google Chrome, Safari, Opera & Internet Explorer.
		</p>
		<p>
		If you also know about some plugins which are cool and want to tell the world then you are always welcomed to write about the plugins. You can <a href="http://pluginstalk.com/contact" target="_blank">contact us</a> for further information.
		</p>
		<p>
		<a href="http://pluginstalk.com" target="_blank">Click Here</a> to visit <a href="http://pluginstalk.com" target="_blank">PluginsTalk.com</a> and know more about it.
		</p>
	</div>
	
	<div class="menu_toggle" style="background:<?php echo ptplGetColor(); ?>;"><a href="http://dev.pluginstalk.com" target="_blank">About Our Developer&#8217;s Section</a></div>
	<div class="toggle_content" style="background:<?php echo ptplGetColor(); ?>;">
		<p>
		We do have a developer section where we tell the world about the plugins which we create, be it on any platform like WordPress or any web browser. Here in our developer&#8217;s section you can get help regarding any of our plugins just by leaving comment or contacting us.
		</p>
		<p>
		If you have any new plugin idea which you think is missing or is a paid service then you are free to provide us the actual requirements that you need through our <a href="http://pluginstalk.com/contact" target="_blank">contact section</a>, and if we felt that its worth developing the plugin then we&#8217;ll develop it for the world (including you, obviously). In return your name will be written as a idea submitter in that plugin information section. And if you are lucky enough then you&#8217;ll might get special goodies or cash prizes.
		</p>
		<p>
		Are you a developer? Have you developed any plugin and you want to submit it? Or you want to develop the plugin for us and join our PluginsTalk team? Be it any case, you are always welcomed to <a href="http://pluginstalk.com/contact" target="_blank">contact us</a> at any time for any reason.
		</p>
	</div>	
	
	<div class="menu_toggle" style="background:<?php echo ptplGetColor(); ?>;">About The Developers</div>
	<div class="toggle_content" style="background:<?php echo ptplGetColor(); ?>;">
		<p>
		We started with a very few developers in our team. With time our PluginsTalk team increased as many highly experienced and talented developers kept joining our team. Presently some of our developers are working on YouTube plugins and most of them working on WordPress & Joomla plugins.
		</p>
		<p>
		If you want to join our team and want to do something which you like, want to develop your own idea. You can <a href="http://pluginstalk.com/contact" target="_blank">join us</a> at anytime.
		</p>
	</div>
	
	<div class="menu_toggle" style="background:<?php echo ptplGetColor(); ?>;"><a href="http://pluginstalk.com/contact" target="_blank">Contact Us</a></div>
	<div class="toggle_content" style="background:<?php echo ptplGetColor(); ?>;">
		<p>
		We don&#8217;t believe that there must be a reason for someone to contact someone. If you just want to say "Hi!!" or you want to do some professional talking or you want to tell us your secrets or you might want to tell that your height is taller than one of our team member, whatever may be the reason you are always welcomed to contact us. We are always happy to hear from you. If everything goes normal then we&#8217;ll surely reply as soon as possible so that you won&#8217;t have to wait for next conversation to begin.
		</p>
		<p>
		Visit our <a href="http://pluginstalk.com/contact" target="_blank">contact section</a> for communicating with us.
		</p>
	</div>
	<?php
		ptplShowLinkToUs ();
	?>
	
</div>
<?php
}

?>