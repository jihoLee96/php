<?php
session_start();
ob_start();
function my_admin_scripts_front_end() 
{
	wp_register_script('my-upload', WP_PLUGIN_URL.'/image-gallery-with-slideshow/js/jquery-ui-1.7.custom.min.js', array('jquery'));
	wp_register_script('my-upload', WP_PLUGIN_URL.'/image-gallery-with-slideshow/js/jquery-1.3.2.min.js', array('jquery'));
	wp_enqueue_script('my-upload');
	}
	 
	/*function my_admin_styles() {
	wp_enqueue_style('thickbox');
	}*/
	 
	if (isset($_GET['page']) && $_GET['page'] == 'gallery_settings') {
	add_action('admin_print_scripts', 'my_admin_scripts_front_end');
	//add_action('admin_print_styles', 'my_admin_styles');
}
function admin_front_end_setting()
{
	if(isset($_POST['submit']))
	{
		$img_width = $_POST['img_width'];
		$img_height = $_POST['img_height'];
		$img_zooming_level = $_POST['img_zooming_level'];
		$img_border_color = $_POST['img_border_color'];
		$root_path_image_upload = $_POST['root_path_image_upload'];
		$sort_thumbnails = $_POST['sort_thumbnails'];
		$sort_direction = $_POST['sort_direction'];		
		if($img_width == "" || $img_width == 0){$img_width = 170;}else{$img_width = $_POST['img_width'];}
		if($img_height == "" || $img_width == 0){$img_height = 170;}else{$img_height = $_POST['img_height'];}
		if($img_zooming_level == "" || $img_zooming_level == 0){$img_zooming_level = 0.7;}else{$img_zooming_level = $_POST['img_zooming_level'];}
		if($img_border_color == "" || $img_border_color == 0){$img_border_color = '#dbdbdd';}else{$img_border_color = $_POST['img_border_color'];}
		$combo_front_end_data = array( 
										'img_width' => $img_width ,
										'img_height' => $img_height,
										'img_zooming_level' => $img_zooming_level,
										'img_border_color' =>$img_border_color,
										'root_path_image_upload' => $root_path_image_upload,
										'sort_thumbnails' => $sort_thumbnails,
										'sort_direction' => $sort_direction										
									  );									  
		if ( ! get_option('combo_front_end_data'))
		{
		  add_option('combo_front_end_data' , $combo_front_end_data);
		}
		 else 
		 {
		  update_option('combo_front_end_data' , $combo_front_end_data);
		 }
	}	
		 $option_data = get_option('combo_front_end_data');
		 $img_width_show = $option_data['img_width'];
		 $img_height_show = $option_data['img_height'];
		 $img_zooming_level_show = $option_data['img_zooming_level'];
		 $img_border_color_show = $option_data['img_border_color'];
		 $img_per_page_show = $option_data['img_per_page'];		 
		 $sort_thumbnails_show = $option_data['sort_thumbnails'];
		 $sort_direction_show = $option_data['sort_direction'];
		 		 
		 if($img_width_show == ''){$img_width_show = '170';}
		 if($img_height_show == ''){$img_height_show = '170';}
		 if($img_border_color_show == ''){$img_border_color_show = '#dbdbdd';}
		 if($img_per_page_show == ''){$img_per_page_show = '6';}
		 if($sort_thumbnails_show == ''){$sort_thumbnails_show = 'Date/Time';}
		 if($sort_direction_show == ''){$sort_direction_show = 'Descending';}
	
	if(isset($_POST['submit_slide']))
	{
		$thumbnail_view = $_POST['thumbnail_view'];
		$thumbnail_position = $_POST['thumbnail_position'];
		$slider_width = $_POST['slider_width'];
		$thumb_nav_width = $_POST['thumb_nav_width'];
		$gallery_width = $_POST['gallery_width'];		
		$combo_front_end_slide_data = array( 
										'thumbnail_view' => $thumbnail_view,
										'thumbnail_position' => $thumbnail_position,
										'slider_width' => $slider_width,
										'thumb_nav_width' => $thumb_nav_width,
										'gallery_width' => $gallery_width 																			
									  );
		if ( ! get_option('combo_front_end_slide_data'))
		{
		  	add_option('combo_front_end_slide_data' , $combo_front_end_slide_data);
		}
		else 
		{
		 	update_option('combo_front_end_slide_data' , $combo_front_end_slide_data);
		}
	}	
		$option_slide_data = get_option('combo_front_end_slide_data');		
		$thumbnail_view_show = $option_slide_data['thumbnail_view'];
		$thumbnail_position_show = $option_slide_data['thumbnail_position'];
		$slider_width_show = $option_slide_data['slider_width'];
		$thumb_nav_width_show = $option_slide_data['thumb_nav_width'];
		$gallery_width_show = $option_slide_data['gallery_width'];		
		if($thumbnail_view_show == ''){$thumbnail_view_show = 'Yes';}
		if($thumbnail_position_show == ''){$thumbnail_position_show = 'Buttom';}
		if($gallery_width_show == ''){$gallery_width_show = '560';}
		if($slider_width_show == ''){$slider_width_show = '560';}
		if($thumb_nav_width_show == ''){$thumb_nav_width_show = '100';}
?>
<script type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/js/script_confirm.js" ></script>
<link rel="stylesheet" href="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/css/template/style.php" type="text/css" media="screen, projection"/>	
<div class="warp">
<h2>Gallery Settings</h2>
	 <div id="page-wrap-admin">
		<div id="tabs">		
                <ul>
                    <li><a href="#fragment-11">Gallery Setting</a></li>
                    <li><a href="#fragment-22">Slideshow Setting</a></li>
                </ul>
                <div id="fragment-11" class="ui-tabs-panel-1"> 
                    <!--<h3>Gallery Setting</h3>-->
                    <div id="wpbody-content">
                       <form name="front_end_setting" action="" method="post">
                            <table class="form-table">
                                <tbody>
                                    <tr valign="top">
                                        <th scope="row">Width of the Thumbnail Image</th>
                                        <td><input type="text" name="img_width" value="<?php echo $img_width_show;?>" /> Pixel<br />Default is 170 px</td>
                                    </tr>
                                    <tr valign="top">
                                        <th scope="row">Height of the Thumbnail Image</th>
                                        <td><input type="text" name="img_height" value="<?php echo $img_height_show;?>" /> Pixel<br />Default is 170 px</td>
                                    </tr>
                                     <tr valign="top">
                                        <th scope="row">Image Zooming Level</th>
                                        <td><input type="text" name="img_zooming_level" value="<?php echo $img_zooming_level_show;?>" /> Enter 0.1 for 10% <br />Default is 0.7 i.e 70%</td>
                                    </tr>                                    
                                    <tr valign="top">
                                        <th scope="row">Border Color</th>
                                        <td><input type="text" name="img_border_color" value="<?php echo $img_border_color_show;?>"/><br />6 digit hexa code with # , Default is #dbdbdd</td>
                                    </tr>
                                   <tr valign="top">
                                        <th scope="row">Root Path</th>
                                        <td><input type="text" name="root_path_image_upload" value="<?php if($root_path_image_upload == ''){echo $option_data['root_path_image_upload'];} else {echo $root_path_image_upload;}?>"/><br /> For example C:/xampp/htdocs/mysite , write the "mysite" in the given field.<br/>
                                        <strong>Note:</strong> This is only for <em>Local</em> installation and need not required if you are using any <em>Remote Server</em>.</td>
                                    </tr>
                                     <tr valign="top">
                                        <th scope="row">Sort Thumbnails</th>
                                        <td>
                                        	<input class="tog" type="radio" name="sort_thumbnails" value="Date/Time" <?php if($sort_thumbnails_show == 'Date/Time'){echo 'checked="checked"';}?> />&nbsp;Date/Time<br />
                                            <input class="tog" type="radio" name="sort_thumbnails" value="Image ID" <?php if($sort_thumbnails_show == 'Image ID') {echo 'checked="checked"';}?> />&nbsp;Image ID<br />
                                            <input class="tog" type="radio" name="sort_thumbnails" value="Image Name" <?php if($sort_thumbnails_show == 'Image Name') {echo 'checked="checked"';}?> />&nbsp;Image Name<br />
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th scope="row">Sort Direction</th>
                                        <td>
                                        	<input class="tog" type= "radio" name="sort_direction" value="Ascending" <?php if($sort_direction_show == 'Ascending'){echo 'checked="checked"';}?> />&nbsp;Ascending<br />
                                            <input class="tog" type="radio" name="sort_direction" value="Descending" <?php if($sort_direction_show == 'Descending'){echo 'checked="checked"';}?> />&nbsp;Descending<br />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="submit">
                                    <input class="button-primary" type="submit" value="Save Changes" name="submit">
                            </p>
                       </form> 
                    </div>
    		</div><!-- end of #fragment-1 -->
            <div id="fragment-22" class="ui-tabs-panel-1 ui-tabs-hide">
            	<!--<h3>Slideshow Setting</h3>-->
                	<div id="wpbody-content">
                    	<form name="front_end_slider_setting" action="" method="post">
                        	<table class="form-table">
                                <tbody>
                                	<tr valign="top">
                                        <th scope="row">Thumbnail View</th>
                                        <td>
                                        	<input class="tog" type="radio" name="thumbnail_view" value="Yes" <?php if($thumbnail_view_show == 'Yes'){echo 'checked="checked"';}?> />&nbsp;Yes<br />
                                            <input class="tog" type="radio" name="thumbnail_view" value="No" <?php if($thumbnail_view_show == 'No'){echo 'checked="checked"';}?> />&nbsp;No<br />                                            
                                    </tr>                                
                                	<tr valign="top">
                                        <th scope="row">Thumbnail Position</th>
                                        <td>
                                        	<input class="tog" type="radio" name="thumbnail_position" value="Buttom" <?php if($thumbnail_position_show == 'Buttom'){echo 'checked="checked"';}?> />&nbsp;Buttom<br />
                                            <input class="tog" type="radio" name="thumbnail_position" value="Left" <?php if($thumbnail_position_show == 'Left'){echo 'checked="checked"';}?> />&nbsp;Left<br />
                                            <input class="tog" type="radio" name="thumbnail_position" value="Right" <?php if($thumbnail_position_show == 'Right'){echo 'checked="checked"';}?> />&nbsp;Right<br />
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th scope="row">Gallery Width</th>
                                        <td><input type="text" name="gallery_width" value="<?php echo $gallery_width_show;?>" /> Pixel<br />Default is 560 px<br />For Thumbnail position at 'left' or 'right' use 630 px</td>
                                    </tr>
                                    <tr valign="top">
                                        <th scope="row">Slider Width</th>
                                        <td><input type="text" name="slider_width" value="<?php echo $slider_width_show;?>" /> Pixel<br />Default is 560 px<br />For Thumbnail position at 'left' or 'right' use 520 px</td>
                                    </tr>
                                    <tr valign="top">
                                        <th scope="row">Thumbnail Navigation Width</th>
                                        <td><input type="text" name="thumb_nav_width" value="<?php echo $thumb_nav_width_show;?>" /> Pixel<br />Default is 100 px<br />For Thumbnail position at 'left' or 'right' use 100 px</td>
                                    </tr>
                                    <tr valign="top">
                                        <td colspan="2"><strong>Note:</strong><br/>Thumbnail Navigation Width and Slider Width is not required for Thumbnail position at 'Buttom' .<br/>For Best view, use 6 Images for Thumbnail position at 'Buttom' and use 4 Images for Thumbnail position at 'Left' of 'Right'.</td>
                                    </tr>
                                 </tbody>
                            </table>
                            <p class="submit">
                                    <input class="button-primary" type="submit" value="Save Changes" name="submit_slide">
                            </p>
                        </form>                  
                    </div>
            </div><!-- end of #fragment-2 -->
        </div><!-- end of #tabs -->
	</div><!-- end of #page-wrap -->
</div><!-- end of .warp -->
<?php	
}
?>