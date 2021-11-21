<?php
    header("Content-type: text/css; charset: UTF-8");
	include('../../../../../wp-config.php');
	global $wpdb;
	$table_prefix = $wpdb->prefix;
	
	$options_data = get_option('combo_front_end_data');
	
	$img_width = $options_data['img_width'];
	$img_height = $options_data['img_height'];
	$img_border_color = $options_data['img_border_color'];
	
	$option_slide_data = get_option('combo_front_end_slide_data');
	
	$$thumbnail_view = $option_slide_data['$thumbnail_view'];
	$thumbnail_position = $option_slide_data['thumbnail_position'];
	$gallery_width = $option_slide_data['gallery_width'];
	if($option_slide_data['gallery_width'] == "" || $option_slide_data['gallery_width'] <= 0)
		$gallery_width = 560;
		
	$slider_width = $option_slide_data['slider_width'];
	$thumb_nav_width = $option_slide_data['thumb_nav_width'];
	
?>	
/************* css for main plugin *******************/

	div.pagination {padding:3px; margin:3px; text-align:center;}
    div.pagination span { padding: 2px 5px 2px 5px; margin-right: 2px; border: 1px solid #a8a8a8; text-decoration: none; color: #666666; cursor:pointer; }
    div.pagination span.current {color: #ffffff; background-color:#666666 }
    div.pagination a { padding: 2px 5px 2px 5px; margin-right: 2px; border: 1px solid #a8a8a8; text-decoration: none; color: #666666; cursor:pointer;}
	div.pagination a:hover, div.pagination a:active { color: #ffffff; background-color: #666666; }
	.combo-gallery-main img{ margin-left:19px; margin-bottom:18px; 
            border:4px solid <?php if($img_border_color == ""){?>#dbdbdd <?php }else{ echo $img_border_color;}?>; height: <?php if($img_height == ""){?>170 <?php }else{ echo $img_height;}?>px; width: <?php if($img_width == ""){?>170 <?php }else{ echo $img_width;}?>px;
            
     }
     .combo-gallery-main{ padding:10px 10px 10px 10px;
            border:1px solid <?php if($img_border_color == ""){?>#dbdbdd <?php }else{ echo $img_border_color;}?>;
     }
     
     div.pagination span.disabled{color:#cccccc;}
	 .current{color:#bbb8fa;}
	 .combo-gallery-title{color:#000!important;border:1px solid #DBDBDD;text-transform:uppercase;font-weight:bold;background-color:#ebeaf2;padding-left:10px;font-size:20px;padding-top:1px;padding-bottom:2px;}

/**************** css for slide show ******************/     
     					  				  
/*
	UTILITY STYLES
*/				  				  
					  				  
.floatLeft { float: left; margin-right: 10px;}
.floatRight { float: right; }
.clear { clear: both; }
a { outline: none; }

#page-wrap {float:left; width:<?php echo $gallery_width.'px';?>; margin: 25px auto; position: relative; background-color:#000000; border:10px solid #CCCCCC;}
blockquote { padding: 0 20px; margin-left: 20px; border-left: 20px solid #ccc; font-size: 14px; font-family: Georgia, serif; font-style: italic; margin-top: 10px;}

		
.stripViewer { position: relative; float:<?php if($thumbnail_position == 'Left')echo 'right';else echo 'left';?>; overflow: hidden; width:<?php if($thumbnail_position == 'Right' || $thumbnail_position == 'Left')echo $slider_width.'px'; else echo $gallery_width.'px';?>; height: 300px; }
.stripViewer .panelContainer { position: relative; left: 0; top: 0; }
.stripViewer .panelContainer .panel { float: left; height: 100%; position: relative; width: <?php echo $gallery_width.'px';?> }
.stripViewer .panelContainer .panel .wrapper{ float: left; height: 100%; position: relative; height: 300px; overflow:hidden }
.stripViewer .panelContainer .panel .wrapper img {max-width:100%}
.stripNavL, .stripNavR, .stripNav { display: none; }
#movers-row { margin: 3px 0 0 4px; float:left; width: auto}
#movers-row div	{ width: 20%; float: left; }
#movers-row div a.cross-link { float: right; }
#movers-row .nav-thumb { border: 1px solid black; margin:0; padding: 3px; background-color:#666666}
#movers-row .cross-link	{ display: block; float:left; margin: -14px 2px 0;   position: relative; padding-top: 15px; z-index: 9999; }
#movers-row .active-thumb { background: transparent url(../../images/icon-uparrowsmallwhite.png) top center no-repeat; }
#movers-row .active-thumb img { background-color:#d1d1d1}

#right-nav { margin: 8px 0 0 4px; float:right; height:294px; width: <?php if($thumbnail_position == 'Right' || $thumbnail_position == 'Left')echo $thumb_nav_width.'px';else echo '100px';?>;}
#right-nav div { width: 20%; float: left; }
#right-nav div a.cross-link { float: right; }
#right-nav .nav-thumb { border: 1px solid black; margin:0; padding: 3px; background-color:#666666}
#right-nav .cross-link { display: block; float:left; margin: 3px 2px;  position: relative; z-index: 9999; }
#right-nav .active-thumb { }
#right-nav .active-thumb img { background-color:#d1d1d1}

#left-nav { margin: 8px 0 0 4px; float:right; height:294px; width: <?php if($thumbnail_position == 'Right')echo $thumb_nav_width.'px';else echo '100px';?>;}
#left-nav div { width: 20%; float: left; }
#left-nav div a.cross-link { float: right; }
#left-nav .nav-thumb { border: 1px solid black; margin:0; padding: 3px; background-color:#666666}
#left-nav .cross-link { display: block; float:left; margin: 3px 2px;  position: relative; z-index: 9999; }
#left-nav .active-thumb { }
#left-nav .active-thumb img { background-color:#d1d1d1}



.photo-meta-data { background: url(../../images/transpBlack.png); padding: 2px 0; width:<?php echo $gallery_width.'px';?>; height: 56px; position: absolute; top:240px;  z-index: 9999; color: white; }
.photo-meta-data p.slide_title {margin-bottom:1px!important; margin-left:7px; font-size:13px; line-height:1.3em; font-weight:bold}
.photo-meta-data p.slide_title a { color:#ffffff; background-color:inherit}
.photo-meta-data p.slide_desc {margin-bottom:10px!important; margin-left:7px; font-size:13px;}
.photo-meta-data span { font-size: 13px; }
.error_msg{background-color:#ff0000; font-size:12px;}

/****************** css for shadowbox *****************************/


#sb-title-inner,#sb-info-inner,#sb-loading-inner,div.sb-message {font-family:"HelveticaNeue-Light","Helvetica Neue",Helvetica,Arial,sans-serif;font-weight:200;color:#fff;}
#sb-container {position:fixed;margin:0;padding:0;top:0;left:0;z-index:999;text-align:left;visibility:hidden;display:none;}
#sb-overlay {position:relative;height:100%;width:100%;}
#sb-wrapper {position:absolute;visibility:hidden;width:100px;}
#sb-wrapper-inner {position:relative;border:1px solid #303030;overflow:hidden;height:100px;}
#sb-body {position:relative;height:100%;}
#sb-body-inner {position:absolute;height:100%;width:100%;}
#sb-player.html {height:100%;overflow:auto;}
#sb-body img {border:none;}
#sb-loading {position:relative;height:100%;}
#sb-loading-inner {position:absolute;font-size:14px;line-height:24px;height:24px;top:50%;margin-top:-12px;width:100%;text-align:center;}
#sb-loading-inner span {background:url(images/loading.gif) no-repeat;padding-left:34px;display:inline-block;}
#sb-body,#sb-loading {background-color:#060606;}
#sb-title,#sb-info {position:relative;margin:0;padding:0;overflow:hidden;}
#sb-title,#sb-title-inner {line-height:26px;}
#sb-title-inner {font-size:16px;}
#sb-info,#sb-info-inner {height:20px;line-height:20px;}
#sb-info-inner {font-size:12px;}
#sb-nav {float:right;height:16px;padding:2px 0;width:45%;}
#sb-nav a {display:block;float:right;height:16px;width:16px;margin-left:3px;cursor:pointer;background-repeat:no-repeat;}
#sb-nav-close {background-image:url(../../images/close.png);}
#sb-nav-next {background-image:url(../../images/next.png);}
#sb-nav-previous {background-image:url(../../images/previous.png);}
#sb-nav-play {background-image:url(../../images/play.png);}
#sb-nav-pause {background-image:url(../../images/pause.png);}
#sb-counter {float:left;width:45%;}
#sb-counter a {padding:0 4px 0 0;text-decoration:none;cursor:pointer;color:#fff;}
#sb-counter a.sb-counter-current {text-decoration:underline;}
div.sb-message {font-size:12px;padding:10px;text-align:center;}
div.sb-message a:link,div.sb-message a:visited {color:#fff;text-decoration:underline;}

/******************* css of tabs.css ***********************/

#page-wrap-admin{ width: 700px; margin: 25px 0; }
.ui-tabs .ui-tabs-nav{ list-style: none; position: relative; padding: 2px 2px 0 30px; overflow: hidden; top: 1px; z-index: 1000; }
.ui-tabs .ui-tabs-nav li{ position: relative; float: left; border: 1px solid #DFDFDF;  margin: 0 7px 0 0; background-color: #FBFBFB; }
.ui-tabs .ui-tabs-nav li a { float: left; text-decoration: none; padding: 5px 10px; color: #AAAAAA; }
.ui-tabs .ui-tabs-nav li.ui-tabs-selected 	{ padding-bottom: 1px; border-bottom-width: 0; background: #F9F9F9; color:#464646 }
.ui-tabs .ui-tabs-nav li.ui-tabs-selected a	{color:#464646 }

.ui-tabs .ui-tabs-panel { padding: 20px; display: block; border-width: 0; background-color:#FBFBFB; border: 1px solid #ccc; position: relative; min-height: 200px; }
.ui-tabs .ui-tabs-panel-1 { padding: 20px; display: block; border-width: 0; background-color:#FBFBFB; border: 1px solid #DFDFDF; position: relative; min-height: 517px; }
.ui-tabs .ui-tabs-hide{ display: none !important; }
a.mover{ background: #900; padding: 6px 12px; position: absolute; color: white; font-weight: bold; text-decoration: none; }
#upload_image {width:100px; text-align:center}
#fragment-3 #files {margin-left: 15px; list-style-type:disc!important}
.clearer {border: 0 none; clear: both; height: 1px; margin: 0; padding: 0; visibility: hidden !important; width: 1px;}