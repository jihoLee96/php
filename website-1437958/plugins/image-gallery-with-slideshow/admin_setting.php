<?php
/*
Plugin Name: Image Gallery with Slideshow
Plugin URI: http://wordpress.org/extend/plugins/image-gallery-with-slideshow/
Description: Image Gallery with Slideshow is a full integrated Image Gallery and Slideshow plugin for WordPress .It can fulfil the requirement of Image Gallery and Slideshow or any one of them. All the features can fully be controlled through Administration end. If you want to upgrade this plugin to a new version and you want to prevail all your existing images, please copy your image folder located at "image-gallery-with-slideshow/uploads" and save it somewhere in a secure location. While the upgradation process is over, you can simply put the image folder back into the same location.  
Version: 1.5.2
Author: Anblik Web Design Company
Author URI: http://www.anblik.com/
*/
?>
<?php
ob_start();
include('shortcode.php');
include('front_end_setting.php');
include("function.php");

function my_admin_scripts() 
{
	wp_register_script('my-upload', WP_PLUGIN_URL.'/image-gallery-with-slideshow/js/jquery-ui-1.7.custom.min.js', array('jquery'));
	wp_register_script('my-upload', WP_PLUGIN_URL.'/image-gallery-with-slideshow/js/jquery-1.3.2.min.js', array('jquery'));
	wp_enqueue_script('my-upload');
	}
	 
	/*function my_admin_styles() {
	wp_enqueue_style('thickbox');
	}*/
	 
	if (isset($_GET['page']) && $_GET['page'] == 'add_gallery_images') {
	add_action('admin_print_scripts', 'my_admin_scripts');
	//add_action('admin_print_styles', 'my_admin_styles');
}


/****** Start of adding table at the time of plugin activation *****/
register_activation_hook(__FILE__,'gallery_install');
function gallery_install () 
{
	global $wpdb;
	$table_prefix = $wpdb->prefix;
	$gallery_table_name = $wpdb->prefix.'combo_gallery';
	if($wpdb->get_var("show tables like ".$gallery_table_name) != $gallery_table_name) 
	{
		$sql1 = "CREATE TABLE  ".$table_prefix."combo_gallery (
		gallery_id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		gallery_name VARCHAR( 255 ) NOT NULL,
		gallery_description TEXT NOT NULL,
		date TIMESTAMP NOT NULL
		) ENGINE = MYISAM ;
		";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql1);
	}
	$image_table_name = $wpdb->prefix.'combo_image';
	if($wpdb->get_var("show tables like ".$image_table_name) != $image_table_name) 
	{
		$sql2 = "CREATE TABLE  `".$table_prefix."combo_image` (
		image_id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		gallery_id INT( 11 ) NOT NULL ,
		image_name VARCHAR( 255 ) NOT NULL,
		original_name VARCHAR( 255 ) NOT NULL,
		image_title VARCHAR( 255 ) NOT NULL,
		image_description TEXT NOT NULL,
		link_url VARCHAR( 255 ) NOT NULL,
		date TIMESTAMP NOT NULL
		) ENGINE = MYISAM ;";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql2);
	}	   
}
/****** End of adding table at the time of plugin activation *****/
add_action('admin_menu', 'admin_panel_image_upload');

/* Add [combogallery id=x] to your post or page to display your gallery. */
if(function_exists('combo_gallery')){
	/* Only works if plugin is active. */
	add_shortcode( 'combogallery','combo_gallery');
}

/* Add [comboslideshow id=x] to your post or page to display your gallery slideshow. */
if(function_exists('combo_slide_show')){
	/* Only works if plugin is active. */
	add_shortcode( 'comboslideshow','combo_slide_show');
}


function admin_panel_image_upload()
{
	add_menu_page('Gallery with Slideshow', 'Gallery with Slideshow', 'administrator', 'gallery_with_slideshow', 'admin_menu_image_upload');
	add_submenu_page('gallery_with_slideshow',	'Gallery Settings',	'Gallery Settings',		'administrator',	'gallery_settings',	'admin_front_end_setting');
	add_submenu_page('gallery_with_slideshow',	'Add Gallery / Images',	'Add Gallery / Images',		'administrator',	  'add_gallery_images',	'admin_setting_image_upload');
}

/******************** Start of function admin_menu_image_upload ******************/
function admin_menu_image_upload()
{
?>
<script type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/js/script_confirm.js" ></script>
<?php
	$path_value = get_combo_path_value();	
/***** Start of php code to view gallery section *****/
	if(!$_REQUEST['val'] =='view')
	{
		$path_value = get_combo_path_value();
		global $wpdb;
		$table_prefix = $wpdb->prefix;		
		$result = $wpdb->get_results("SELECT * FROM `".$table_prefix."combo_gallery`");
		$count_gallery = count($result);
	?>
		<div class="warp">
			<h2>Welcome to Gallery with Slideshow Plugin</h2>
				<div id="wpbody-content">
					<table class="widefat" border="1">
					<thead>
						<tr>
                            <th class="check-column" style="padding-left:10px;">ID</th>
                            <th>Gallery Name</th>
                            <th>Gallery Description</th>
                            <th>Gallery Shortcode</th>
                            <th>Slideshow Shortcode</th>
                            <th class="column-links">Action</th>
                        </tr>
					</thead>
					<tbody id="the-liast">
					<?php
                    if($count_gallery == 0)
                    {
                    ?>
                    <tr>
                        <td colspan="6" align="center">Sorry! No gallery has been added</td>
                    </tr>
                    <?php
                    }
					else
					{
						$gallery_count = 0;
						foreach($result as $value)
						{
							$gallery_count +=1;
						?>
                        <?php if(($gallery_count % 2) == 1){?>
						<tr class="alternate author-self status-inherit"> <?php } else {?> <tr class="author-self status-inherit"><?php };?>
							<th><?php echo $value->gallery_id;?></th>
							<td><a class="row-title" title="Edit" href="<?php echo bloginfo('url');?>/wp-admin/admin.php?page=gallery_with_slideshow&val=view&gid=<?php echo $value->gallery_id;?>"><?php echo $value->gallery_name;?></a></td>
							<td>&nbsp;<?php echo $value->gallery_description;?></td>
							<td>[combogallery id='<?php echo $value->gallery_id;?>']</td>
                            <td>[comboslideshow id='<?php echo $value->gallery_id;?>']</td>
							<td><span><a href="<?php echo bloginfo('url');?>/wp-admin/admin.php?page=gallery_with_slideshow&val=edit&gid=<?php echo $value->gallery_id;?>">Edit</a></span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<span onclick="confirmGalleryDelete('<?php echo $value->gallery_id;?>','<?php echo $path_value;?>');"><a href="javascript:void();">Delete</a></span></td>
						</tr>
						<?php
						}
					}
					?>
					</tbody>
					<thead>
						<tr>
                            <th class="check-column" style="padding-left:10px;">ID</th>
                            <th>Gallery Name</th>
                            <th>Gallery Description</th>
                            <th>Gallery Shortcode</th>
                            <th>Slideshow Shortcode</th>
                            <th class="column-links">Action</th>
                        </tr>
                    </thead>
					</table>	
				</div><!-- end of #wpbody-content -->
		</div><!-- end of .warp -->
<?php
}
/***** End of php code to view gallery section *****/
/***** Start of php code to view images of a gallery section *****/
if($_REQUEST['val'] == 'view')
{
	$path_value = get_combo_path_value();
	$id = $_REQUEST['gid'];
	global $wpdb;
	$table_prefix = $wpdb->prefix;	
	$result = $wpdb->get_results("SELECT ig.gallery_name,ii.image_id,ii.original_name,ii.image_name,ii.gallery_id,ii.image_title,ii.link_url,ii.image_description FROM `".		$table_prefix."combo_gallery` AS ig,`".$table_prefix."combo_image` AS ii WHERE ig.gallery_id=ii.gallery_id AND ii.gallery_id =".$id);
	//print_r($result);
	$count_image = count($result);
	?>
		<div class="warp">
		<?php
			if($count_image != 0)
			{
		?>
				<h2><?php echo $result[0]->gallery_name;?> consist of <?php echo $count_image;?> images</h2>
    	<?php
			}
		?>
			<div id="wpbody-content">
				<table class="widefat fixed">
				<thead>
                    <tr>
                        <th class="check-column" style="padding-left:10px;">ID</th>
                        <th class="column-icon media-icon">Thumbnail</th>
                        <th>Image Name</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Link URL</th>
                        <th class="column-links">Action</th>
                    </tr>
            </thead>
            <tbody>
					<?php
                    if($count_image == 0)
                    {
                    ?>
                    <tr>
                        <td colspan="7" align="center">Sorry, no images in this gallery.</td>
                    </tr>
                    <?php
                    }
                    else
                    {
						$image_count = 0;
						foreach($result as $value)
						{
							$image_count +=1;
					?>
						<?php if(($image_count % 2) == 1){?>
						<tr class="alternate author-self status-inherit"> <?php } else {?> <tr class="author-self status-inherit"><?php };?>
							<th><?php echo $value->image_id;?></th>
							<td class="column-icon media-icon"><img class="attachment-80x60" src="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/uploads/thumbnail/<?php echo $value->image_name;?>" alt="<?php if($value->image_title != ''){echo strtolower($value->image_title);}else{echo strtolower($value->image_name);} ?>" width="100" height="100" /></td>
							<td class="title column-title"><a class="row-title" title="Edit" href="<?php echo bloginfo('url');?>/wp-admin/admin.php?page=gallery_with_slideshow&val=imgedit&gid=<?php echo $value->gallery_id;?>&imgid=<?php echo $value->image_id;?>"><?php echo $value->original_name;?></a></td>
							<td class="title column-title"><?php echo $value->image_title;?></td>
							<td><?php echo $value->image_description;?></td>
                            <td><?php echo $value->link_url;?></td>
							<td><span><a href="<?php echo bloginfo('url');?>/wp-admin/admin.php?page=gallery_with_slideshow&val=imgedit&gid=<?php echo $value->gallery_id;?>&imgid=<?php echo $value->image_id;?>">Edit</a></span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<span onclick="confirmImageDelete('<?php echo $value->image_id;?>','<?php echo $path_value;?>');"><a href="javascript:void();">Delete</a></span></td>
						</tr>
						<?php
						}
					}
					?>
			</tbody>
			<thead>
                <tr>
                    <th class="check-column" style="padding-left:10px;">ID</th>
                    <th class="column-icon media-icon">Thumbnail</th>
                    <th>Image Name</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Link URL</th>
                    <th class="column-links">Action</th>
                </tr>
            </thead>
        </table>	
	</div><!-- end of #wpbody-content -->
</div><!-- end of .warp -->
<?php
}
/***** End of php code to view images of a gallery section *****/
/***** Start of html code to edit gallery *****/
if($_REQUEST['val'] == 'edit')
{
	$id = $_REQUEST['gid'];
	global $wpdb;
	$table_prefix = $wpdb->prefix;
	$info_blog = get_bloginfo('url');
/***** Start of php code to edit gallery *****/	
	if(isset($_REQUEST['edit_gallery_submit']))
	{
		$gallery_name = $_REQUEST['gallery_name'];
		$description = $_REQUEST['gallery_description'];
		$update_query_result = $wpdb->query($wpdb->prepare("UPDATE `".$table_prefix."combo_gallery` SET gallery_name = '".$gallery_name."',gallery_description = '".$description."' WHERE gallery_id=".$id));	
		wp_redirect($info_blog."/wp-admin/admin.php?page=gallery_with_slideshow"); exit;
	}
/***** End of php code to edit gallery *****/
	$edit_result = $wpdb->get_results("SELECT * FROM `".$table_prefix."combo_gallery` WHERE gallery_id = ".$id);
	foreach($edit_result as $edit_value)
	{
?>
	<div class="warp">
		<h3>Edit Gallery</h3>
		<div id="wpbody-content">
			<form name="add_gallery" method="post" action="">
				<table class="form-table">
                    <tbody>
                        <tr valign="top" class="form-field">
                            <th scope="row">Name of the Gallery</th>
                            <td><input type="text" name="gallery_name" value="<?php echo $edit_value->gallery_name;?>" size="75"/></td>
                        </tr>
                        <tr valign="top" class="form-field">
                            <th scope="row">Description of the Gallery</th>
                            <td><textarea name="gallery_description" rows="7" cols="60"><?php echo $edit_value->gallery_description;?></textarea></td>
                        </tr>
                    </tbody>
				</table>
                <p class="submit">
                        <input class="button-primary" type="submit" value="Update gallery" name="edit_gallery_submit">
                </p>
			</form>
		</div><!--end of #wpbody-content-->
	</div><!--end of .warp-->
<?php
	}	
}
/***** End of html code to edit gallery *****/
/***** Start of html code to edit gallery images *****/
if($_REQUEST['val'] == 'imgedit')
{
	$id = $_REQUEST['imgid'];
	$gid = $_REQUEST['gid'];
	global $wpdb;
	$table_prefix = $wpdb->prefix;
	$info_blog = get_bloginfo('url');
/***** Start of php code to edit gallery images *****/	
	if(isset($_REQUEST['edit_image_submit']))
	{
		$image_title = $_REQUEST['image_title'];
		$link_url = $_REQUEST['link_url'];
		$image_description = $_REQUEST['image_description'];
		$update_query_result = $wpdb->query($wpdb->prepare("UPDATE `".$table_prefix."combo_image` SET image_title = '".$image_title."',link_url = '".$link_url."', image_description = '".$image_description."' WHERE image_id=".$id));
		wp_redirect($info_blog."/wp-admin/admin.php?page=gallery_with_slideshow&val=view&gid=".$gid ); exit; 
	}
/***** End of php code to edit gallery images *****/
	$edit_img_result = $wpdb->get_results("SELECT * FROM `".$table_prefix."combo_image` WHERE image_id = ".$id);
	foreach($edit_img_result as $edit_img_value)
	{
?>
	<div class="warp">
		<h3>Edit Image</h3>
			<div id="wpbody-content">
				<form name="edit_image" method="post" action="" enctype="multipart/form-data">
					<table class="form-table">
            			<tbody>
                            <tr valign="top" class="form-field">
                                <th scope="row">Uploaded Image </th>
                                <td><img src="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/uploads/thumbnail/<?php echo $edit_img_value->image_name;?>" alt="imagevalue" width="100" height="100" /></td>
                            </tr>
                            <tr valign="top" class="form-field">
                                <th scope="row">Name of the Image</th>
                                <td><input type="text" name="image_name" value="<?php echo $edit_img_value->image_name;?>" readonly="readonly"/></td>
                            </tr>
                            <tr valign="top" class="form-field">
                                <th scope="row">Title of the Image</th>
                                <td><input type="text" name="image_title" value="<?php echo $edit_img_value->image_title;?>"/></td>
                            </tr>
                            <tr valign="top" class="form-field">
                                <th scope="row">Link URL</th>
                                <td><input type="text" name="link_url" value="<?php echo $edit_img_value->link_url;?>"/> (Example: http://www.example.com)</td>
                            </tr>
                            <tr valign="top" class="form-field">
                                <th scope="row">Description of the Image</th>
                                <td><textarea name="image_description"><?php echo $edit_img_value->image_description;?></textarea><br /> (Max 80 characters for best view)</td>
                            </tr>
						</tbody>
					</table>
                    <p class="submit">
                            <input class="button-primary" type="submit" value="Update image" name="edit_image_submit">
                    </p>
				</form>
			</div><!--end of #wpbody-content-->
	</div><!--end of .warp-->
<?php
	}	
}
/***** End of html code to edit gallery images *****/
/***** Start of deleting gallery *****/
if($_REQUEST['gval'] == 'delete')
{
	$id = $_REQUEST['gid'];
	global $wpdb;
	$table_prefix = $wpdb->prefix;
	$info = $_SERVER['DOCUMENT_ROOT'];
	$path_value = get_combo_path_value();	
	$select_img_query_result = $wpdb->get_results("SELECT * FROM `".$table_prefix."combo_image` WHERE gallery_id=".$id);
	foreach($select_img_query_result as $value)
	{
		$image_value = $value->image_name;
		$image_id_value = $value->gallery_id;
		unlink($info.$path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/original/".$image_value); 
		unlink($info.$path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/thumbnail/".$image_value);
		unlink($info.$path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/slideshow/".$image_value);
		unlink($info.$path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/slideshowthumb/".$image_value);		
		$delete_image_query_result = $wpdb->query($wpdb->prepare("delete from `".$table_prefix."combo_image` where gallery_id=".$image_id_value));
	}	
	$delete_query_result = $wpdb->query($wpdb->prepare("DELETE FROM `".$table_prefix."combo_gallery` WHERE gallery_id=".$id));	
	wp_redirect($info_blog.$path_value."/wp-admin/admin.php?page=gallery_with_slideshow"); exit; 
}
/***** End of deleting gallery *****/
/***** Start of deleting gallery images *****/
if($_REQUEST['ival'] == 'delete')
{
	$path_value = get_combo_path_value();
	$id = $_REQUEST['gid'];
	global $wpdb;
	$table_prefix = $wpdb->prefix;
	$info = $_SERVER['DOCUMENT_ROOT'];	
	$select_img_query_result1 = $wpdb->get_results("SELECT * FROM `".$table_prefix."combo_image` WHERE image_id=".$id);	
	$image_value1 = $select_img_query_result1[0]->image_name;
	$image_id_value1 = $select_img_query_result1[0]->image_id;
	$gallery_id_value1 = $select_img_query_result1[0]->gallery_id;	
	unlink($info.$path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/original/".$image_value1); 
	unlink($info.$path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/thumbnail/".$image_value1);
	unlink($info.$path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/slideshow/".$image_value1);
	unlink($info.$path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/slideshowthumb/".$image_value1);	
	$delete_image_query_result1 = $wpdb->query($wpdb->prepare("DELETE FROM `".$table_prefix."combo_image` WHERE image_id=".$image_id_value1));	
	wp_redirect($info_blog.$path_value."/wp-admin/admin.php?page=gallery_with_slideshow&val=view&gid=".$gallery_id_value1); exit;
}
/***** End of deleting gallery images *****/	
}
/******************** End of function admin_menu_image_upload ******************/
/******************** Sratr of function admin_setting_image_upload ********************/



function admin_setting_image_upload()
{
?>
<script type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/js/ajaxupload.3.5.js" ></script>
<script type="text/javascript" src="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/js/script_admin.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/css/styles.css" />
<link rel="stylesheet" href="<?php echo WP_PLUGIN_URL;?>/image-gallery-with-slideshow/css/template/style.php" type="text/css" media="screen, projection"/>
<?php
global $wpdb;
$table_prefix = $wpdb->prefix;
$info_blog = get_bloginfo('url');
$root_path_value = get_combo_root_path_value();
/***** Start of php code for upload gallery *****/
if(isset($_POST['gallery_submit']))
{
	$gallery_name = $_REQUEST['gallery_name'];
	$insert_query_result = $wpdb->insert($table_prefix.'combo_gallery', array('gallery_name' => $gallery_name,'date' => current_time('mysql')));
	
	if($insert_query_result)
	{	
		wp_redirect($info_blog."/wp-admin/admin.php?page=add_gallery_images&val=success"); exit;
	}
	else
	{
		wp_redirect($info_blog."/wp-admin/admin.php?page=add_gallery_images&val=error"); exit;
	}
}
/***** End of php code for upload gallery *****/
/***** Start of php code for single image upload *****/
if(isset($_POST['submit']))
{
	define("MAX_SIZE",2000);
	$info_blog = get_bloginfo('url');
	$selectGallery = $_REQUEST['selectGallery'];
	$filename = $_FILES['upImage']['name'];
	$image = $_FILES['upImage']['name'];		
	if($image)
	{
		$filename = stripslashes($filename);
		$extension = getExtension($filename);
		$extension = strtolower($extension);
		$file_size = filesize($_FILES['upImage']['tmp_name']);		
		if($extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif")
		{
			wp_redirect($info_blog."/wp-admin/admin.php?page=add_gallery_images&val=uperr"); exit;		
		}
		else if($size > (MAX_SIZE*1024))
		{
			wp_redirect($info_blog."/wp-admin/admin.php?page=add_gallery_images&val=tolar"); exit;
		}
		else
		{			
			$new_image = time()."_".$image;
			$original_image = $image;			
			$path_original = $root_path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/original/";
			$path_thumbnail = $root_path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/thumbnail/";
			$path_slideshow = $root_path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/slideshow/";
			$path_slideshowthumb = $root_path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/slideshowthumb/";
			move_uploaded_file($_FILES['upImage']['tmp_name'],$path_original.$new_image);
			
			$option_data = get_option('combo_front_end_data');		 
		 	$img_width_thumb = $option_data['img_width'];
		 	$img_height_thumb = $option_data['img_height'];
						
			fixed_size_cropper($path_original,$path_thumbnail,$new_image,$img_width_thumb,$img_height_thumb);
			fixed_size_cropper($path_original,$path_slideshow,$new_image,640,300);
			fixed_size_cropper($path_original,$path_slideshowthumb,$new_image,80,53);
			
			$insert_query_result = $wpdb->insert($table_prefix.'combo_image', array('gallery_id' => $selectGallery,'image_name' => $new_image, 'original_name' => $original_image,'date' => current_time('mysql')));
			
			if($insert_query_result)
			{
				wp_redirect($info_blog."/wp-admin/admin.php?page=add_gallery_images&val=successsingle"); exit;
			}
			else
			{
				wp_redirect($info_blog."/wp-admin/admin.php?page=add_gallery_images&val=errorsingle"); exit;
			}
		}				
	}
}
/***** End of php code for single image upload *****/
/***** Start of selecting gallery for multiple uploaded image *****/
if(isset($_POST['image_submit']))
{
	$gallery_id = $_POST['selectMulGallery'];
	$update_gallery_query = "UPDATE `".$table_prefix."combo_image` SET gallery_id=".$gallery_id." WHERE gallery_id = '0'";
	$wpdb->query($update_gallery_query);	
	if($update_gallery_query)
	{
		wp_redirect($info_blog."/wp-admin/admin.php?page=add_gallery_images&val=successmul"); exit;
	}
	else
	{
		wp_redirect($info_blog."/wp-admin/admin.php?page=add_gallery_images&val=errormul"); exit;
	}
}
/***** End of selecting gallery for multiple uploaded image *****/
$path_value = get_combo_path_value();
$nonce = wp_create_nonce('wp-image-gallery-with-slideshow');
?>
<div id="nonce_value" style="display:none;"><?php echo $nonce;?></div>
<div id="path_value" style="display:none;"><?php echo $path_value;?></div>
<div class="warp">
	<h2>Add Gallery / Images</h2>
        <div id="page-wrap-admin">
			<div id="tabs">		
                <ul>
                    <li><a href="#fragment-1">Add Gallery</a></li>
                    <li><a href="#fragment-2">Single Image Upload</a></li>
                    <li><a href="#fragment-3">Multiple Image Upload</a></li>
                </ul>  
<!-- Start of Add gallery section -->
		        <div id="fragment-1" class="ui-tabs-panel">
					<?php
					if($_REQUEST['val'] == 'success')
                        echo "<div id=\"message\" class=\"updated\">Gallery has been successfully added</div>";                 
                    if($_REQUEST['val'] == 'error')
						echo "<div class=\"error_msg\">Gallery has not been added properly</div>";
                 	if($_REQUEST['val'] == 'successsingle')
						echo "<div id=\"message\" class=\"updated\">Image successfully added</div>";	
					if($_REQUEST['val'] == 'errorsingle')
						echo "<div class=\"error_msg\">Problem in image addition</div>";
					if($_REQUEST['val'] == 'successmul')
						echo "<div id=\"message\" class=\"updated\">Images successfully added</div>";	
					if($_REQUEST['val'] == 'errormul')
						echo "<div class=\"error_msg\">Problem in adding images</div>";
					if($_REQUEST['val'] == 'uperr')
						echo "<div class=\"error_msg\">Type the correct extention please</div>";
					if($_REQUEST['val'] == 'tolar')
						echo "<div class=\"error_msg\">Image is too large</div>";
					?>
                    <h3>Add Gallery</h3>
						<form name="add_gallery" method="post" action="" onsubmit="return galleryForm()">
							<table class="form-table">
                			<tbody>
								<tr valign="top">
									<th scope="row">Name of the Gallery</th>
									<td><input type="text" name="gallery_name"/ size="45"></td>
								</tr>
							</tbody>
							</table>
                			<p class="submit">
            					<input class="button-primary" type="submit" value="Add gallery" name="gallery_submit">
            				</p>
						</form>
                        <strong>Note</strong>
                        <ul>
                        	<li> To view the Gallery Images and Slideshow, at first set the <strong>"Gallery Settings"</strong> option.</li>
                            <li>To add the Title and Description of Gallery Images or Slideshow Images edit the uploaded image from <strong>"Gallery with Slideshow"</strong> >> Gallery name.</li>
                        </ul>
                 </div><!-- end of #fragment-1 -->                
<!-- End of Add gallery section -->
<!-- Start of Single image upload section --> 
        		<div id="fragment-2" class="ui-tabs-panel ui-tabs-hide">
        			<h3>Single Image Upload</h3>
						<form name="image_upload" action="" method="post" enctype="multipart/form-data" onsubmit="return singleimageForm()">
							<table class="form-table">
            				<tbody>
								<tr valign="top">
									<th scope="row">Upload Image</th>
									<td><input type="file" name="upImage" /></td>
								</tr>
                                <tr valign="top">
                				<th scope="row">&nbsp;</th>
                   				<td>Upload Images with dimension more than the dimension of Thumbnail Image in the "Gallery Settings". (Default 170px X 170px)</td>
                			</tr>
								<tr valign="top">
									<th scope="row">Select Gallery</th>
									<td><select name="selectGallery">
										<option value='0'>Select Gallery</option>
										<?php
											$select_query_result = $wpdb->get_results("SELECT * FROM `".$table_prefix."combo_gallery`");
											foreach ($select_query_result as $value)
											{
										?>
												<option value="<?php echo $value->gallery_id;?>"><?php echo $value->gallery_name;?></option>
											<?php
                                            }
                                            ?>
										</select>
                        			</td>
								</tr>
			                </tbody>
							</table>
                            <p class="submit">
                                    <input class="button-primary" type="submit" value="Upload Image" name="submit">
                            </p>
						</form>
				</div><!-- end of #fragment-2 -->                
<!--Start of Multiple image upload section -->     
		        <div id="fragment-3" class="ui-tabs-panel ui-tabs-hide">
					<h3>Multiple Image Upload</h3>
            		<!-- Upload Button, use any id you wish-->
            			<table class="form-table">
                		<tbody>
                			<tr valign="top">
                				<th scope="row">Upload Images</th>
                   				<td><div id="upload_image" class="button"><span>Upload Image<span></div>
                			</tr>
                            <tr valign="top">
                				<th scope="row">&nbsp;</th>
                   				<td>Upload Images with dimension more than the dimension of Thumbnail Image in the "Gallery Settings". (Default 170px X 170px)</td>
                			</tr>
                			<tr valign="top">
                				<th scope="row">Select Gallery</th>
                                <td> 
                                    <div>
                                        <form action="" method="post" name="muntiple_upload" enctype="multipart/form-data" onsubmit="return mulimageForm();">
                                            <select name="selectMulGallery" id="selectMulGallery">
                                            <option value='0'>Select Gallery</option>
                                            <?php
                                                $select_query_result = $wpdb->get_results("SELECT * FROM `".$table_prefix."combo_gallery`");
                                                foreach ($select_query_result as $value)
                                                {
                                            ?>
                                                    <option value="<?php echo $value->gallery_id;?>"><?php echo $value->gallery_name;?></option>
                                            <?php
                                                }
                                            ?>
                                            </select>
                                      </div>
                                </td>
                			</tr>
                		</tbody>
            			</table>
                        <span id="status"></span></td>
                        <ul id="files"></ul>
                        <br clear="all" />
                        <p class="submit">
                        	<input class="button-primary" type="submit" name="image_submit" value="Upload Image" />
                        </p>
                        </form>
       				</div><!-- end of #fragment-3 -->
				</div><!-- end of #tabs -->                
<!-- End of Multiple image upload section --->
			</div><!-- end of #page-wrap -->
	</div><!-- end of .warp -->
<?php
}
/***** End of function admin_setting_image_upload *****/
?>