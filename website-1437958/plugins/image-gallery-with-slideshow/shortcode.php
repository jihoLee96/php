<?php
ob_start();
/*require_once ('pagination.php');*/
add_action ( 'wp_head', 'javascriptIncludes');
add_action ( 'wp_head', 'slideshow_script_link');
function javascriptIncludes()  
{
	if(!is_admin())
	{
?>
    <link rel="stylesheet" type="text/css" href="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/shadowbox.css">
    <script type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/js/shadowbox.js"></script>
    <script type="text/javascript">
    Shadowbox.init({});
    </script>
    
    <link rel='stylesheet' type='text/css' href='<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/css/template/style.php' />
<?php
	}
}
function slideshow_script_link()
{
	if(!is_admin())
	{
	?>
		<script type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/js/jquery-1.2.6.min.js"></script>
		<script type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/js/jquery-easing-1.3.pack.js"></script>
		<script type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/js/jquery-easing-compatibility.1.2.pack.js"></script>
		<script type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/js/coda-slider.1.1.1.pack.js"></script>
        <script type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/js/script_user.js"></script>
	<?php
	}
}
/***** Start to show gallery images with shortcode [combogallery id='x'] *****/
function combo_gallery( $atts ) {
?>
<style type="text/css">
a {
color:#333;
text-transform: capitalize;
}
a:hover{
color: #999;
text-decoration:underline
}
</style>
<?php
        global $wpdb;
		$table_prefix = $wpdb->prefix;
		$arrayvalue = array();
      	extract(shortcode_atts(array(
            'id'        => 0,
            'template'  => '',  
            'images'    => false
        ), $atts ));
		
		$slug_page = $_SERVER['REQUEST_URI'];		
		$new_value = explode("/",$slug_page);
		$new_value = array_reverse($new_value);
		$full_url = get_bloginfo('url')."/".$new_value[1]."/";
		
		/*if($new_value[2] == "")
		{
			$full_url = get_bloginfo('url')."/".$new_value[1]."/";
		}
		else
		{
			//$full_url = get_bloginfo('url')."/".$new_value[2]."/".$new_value[1]."/";
			echo $full_url = get_bloginfo('url')."/".$new_value[2]."/";
		}*/
		/*$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
		$page = ($page == 0 ? 1 : $page);*/
		$page_value = get_option('combo_front_end_data');
		$gallery_result = $wpdb->get_results("SELECT * FROM `".$table_prefix."combo_gallery` WHERE gallery_id = ".$id);		
		$select_query = "";
		$select_query .= "SELECT * FROM `".$table_prefix."combo_image` WHERE gallery_id = '".$id."' ";		
		if($page_value['sort_thumbnails'] == 'Date/Time')
		{
			$select_query .= "ORDER BY date ";
		}
		else if($page_value['sort_thumbnails'] == 'Image ID')
		{
			$select_query .= "ORDER BY image_id ";
		}
		else 
		{
			$select_query .= "ORDER BY original_name ";
		}
		if($page_value['sort_direction'] == 'Ascending')
		{
			$select_query .= "ASC ";
		}
		else
		{
			$select_query .= "DESC ";
		}
		/*if($page_value['img_per_page'] == 0)
		{
			$select_query .= "";
		}
		else
		{
			$perpage = $page_value['img_per_page'];//limit in each page
			$startpoint = ($page * $perpage) - $perpage;
			$select_query .= "LIMIT $startpoint,$perpage";			
		}*/
		
		$result = $wpdb->get_results($select_query);
			$combo_gallery_content = '';
            $combo_gallery_content .= '<h3 class="combo-gallery-title">'.$gallery_result[0]->gallery_name.'</h3>';            
            $combo_gallery_content .= '<div class="combo-gallery-main">';
            
			foreach($result as $value)
			{
				$combo_gallery_name = $value->image_name;
				$combo_gallery_title = $value->image_title;
				$combo_gallery_description = $value->image_description;
			
				$combo_gallery_content .= '<a href="'.WP_PLUGIN_URL.'/image-gallery-with-slideshow/uploads/original/'.$combo_gallery_name.'" rel="lightbox[album]" title="';				
				if($combo_gallery_title != '')
				{
					$combo_gallery_content .= '<h3>'.$combo_gallery_title.'</h3>';
				} 
				if(strlen($combo_gallery_description) > 80)
				{
				 	$combo_gallery_content .= substr($combo_gallery_description,0,80).'...';
				}
				else
				{
					$combo_gallery_content .= $combo_gallery_description;
				} 
				$combo_gallery_content .='"><img src="'.WP_PLUGIN_URL.'/image-gallery-with-slideshow/uploads/thumbnail/'.$combo_gallery_name.'" alt="';
				if($combo_gallery_title != '')
				{
					$combo_gallery_content .= strtolower($combo_gallery_title);
				}
				else
				{
					$combo_gallery_content .= strtolower($combo_gallery_name);
				} 
				
				$combo_gallery_content .='" title="'.$combo_gallery_title.'" /></a>';	   
			
			}
				$combo_gallery_content .= '</div>';
				
				return $combo_gallery_content;
               			
    }
/***** End to show gallery images with shortcode [combogallery id='x'] *****/
/***** Start to show gallery slideshow with shortcode [comboslideshow id='x'] *****/
function combo_slide_show($atts)
{
	global $wpdb;
	$table_prefix = $wpdb->prefix;
	$arrayvalue = array();
	extract(shortcode_atts(array(
		'id'        => 0,
		'template'  => '',  
		'images'    => false
	), $atts ));	
	$option_slide_data = get_option('combo_front_end_slide_data');	
	$slider_result = $wpdb->get_results("SELECT * FROM `".$table_prefix."combo_image` WHERE gallery_id = ".$id);
?>	
	
    <?php
    $slideshow_content = ''; 
	$slideshow_content .='<div id="page-wrap">';
	$slideshow_content .='<div class="slider-wrap">';
	$slideshow_content .='<div id="main-photo-slider" class="csw">'; 
	$slideshow_content .='<div class="panelContainer">';
	
					$slider_count = 1;
					foreach($slider_result as $value)
					{
						$slideshow_content .='<div class="panel" title="Panel'.$slider_count.'">';
						$slideshow_content .='<div class="wrapper">';
					 if($value->link_url != "")
					 {
						$slideshow_content .='<a href="'.$value->link_url.'" title="'.$value->image_title.'">';
					 }
						$slideshow_content .='<img src="'.WP_PLUGIN_URL.'/image-gallery-with-slideshow/uploads/slideshow/'.$value->image_name.'" alt="';
					if($value->image_title != '')
					{
						$slideshow_content .= strtolower($value->image_title);
					}
					else
					{
						$slideshow_content .= strtolower($value->image_name);
					}
						$slideshow_content .='" />';				 
				   	if($value->link_url != "")
				   	{
						$slideshow_content .= '</a>';
				   	}
            	   	if($value->image_title != "" || $value->image_description !="")
				   	{
						$slideshow_content .='<div class="photo-meta-data">';	
						    if($value->image_title !="")
								{
								$slideshow_content .= '<p class="slide_title">';
								if($value->link_url != "")
								{
								$slideshow_content .='<a href="'.$value->link_url.'" title="'.$value->image_title.'">'.$value->image_title.'</a>';
								}
								else
								{
								$slideshow_content .= $value->image_title;
								}
								$slideshow_content .='</p>';
					}
								if($value->image_description != ""){	
								$slideshow_content .='<p class="slide_desc">';
									if(strlen($value->image_description) > 80) {
								$slideshow_content .= substr($value->image_description,0,80).'...';
									} else {
								$slideshow_content .= $value->image_description; 
									}
								$slideshow_content .='</p>';	
								}
								
							$slideshow_content .='</div>';
                            }
							
                         $slideshow_content .= '</div>
					</div>';				
                	$slider_count++;
                	}
               
    		$slideshow_content .='</div>
		</div>';
		$slideshow_content .='<div ';
		if($option_slide_data['thumbnail_position'] == 'Buttom')
		{
			$slideshow_content .='id="movers-row"';
		}
		else if($option_slide_data['thumbnail_position'] == 'Right')
		{
			$slideshow_content .='id="right-nav"';
		} 
		else
		{ 
			$slideshow_content .='id="left-nav"';
		}
		if($option_slide_data['thumbnail_view'] == 'No')
		{
			$slideshow_content .= 'style="display:none;"';
		}
		$slideshow_content .= '>';
		
		$slider_count = 1;
		foreach($slider_result as $value)
		{
		$slideshow_content .= '<a href="#'.$slider_count.'" class="cross-link active-thumb"><img src="'.WP_PLUGIN_URL.'/image-gallery-with-slideshow/uploads/slideshowthumb/'.$value->image_name.'" class="nav-thumb" alt="';
		if($value->image_title != '')
		{
		$slideshow_content .= strtolower($value->image_title);
		}
		else
		{
		$slideshow_content .= strtolower($value->image_name);
		}
		$slideshow_content .='" /></a>';
	$slider_count++;
}

        $slideshow_content .= '</div>
	</div>
</div>
<div class="clearer"></div>';
/***** end of #page-wrap ******/
return $slideshow_content;
}
/***** End to show gallery slideshow with shortcode [comboslideshow id='x'] *****/
?>