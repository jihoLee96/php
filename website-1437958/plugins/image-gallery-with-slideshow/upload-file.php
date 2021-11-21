<?php
require_once('../../../wp-config.php');
require_once(ABSPATH .'wp-includes/pluggable.php');
$nonce=$_GET['_ajax_nonce'];
//echo $nonce;
if (! wp_verify_nonce($nonce, 'wp-image-gallery-with-slideshow') ) die("Security check");


global $wpdb;
$table_prefix = $wpdb->prefix;
$page_value = get_option('combo_front_end_data');
$path_value = get_combo_root_path_value();

$value = $_REQUEST['selectGallery'];
$new_image =time()."_".$_FILES['uploadfilename']['name'];
$original_image = $_FILES['uploadfilename']['name'];

$uploaddir_original = $path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/original/";
$uploaddir_thumbnail = $path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/thumbnail/";
$uploaddir_slideshow = $path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/slideshow/"; 
$uploaddir_slideshowthumb = $path_value."/wp-content/plugins/image-gallery-with-slideshow/uploads/slideshowthumb/";

$file_original = $uploaddir_original.$new_image; 
$file_thumbnail = $uploaddir_thumbnail.$new_image;
$file_slideshow = $uploaddir_slideshow.$new_image;
$file_slideshowthumb = $uploaddir_slideshowthumb.$new_image;

$value_org = move_uploaded_file($_FILES['uploadfilename']['tmp_name'], $file_original);
$value_thumb = move_uploaded_file($_FILES['uploadfilename']['tmp_name'], $file_thumbnail);
$value_thumb = move_uploaded_file($_FILES['uploadfilename']['tmp_name'], $file_slideshow);
$value_thumbslide = move_uploaded_file($_FILES['uploadfilename']['tmp_name'], $file_slideshowthumb);

$option_data = get_option('combo_front_end_data');		 
$img_width_thumb = $option_data['img_width'];
$img_height_thumb = $option_data['img_height'];
						
fixed_size_cropper($uploaddir_original,$uploaddir_thumbnail,$new_image,$img_width_thumb,$img_height_thumb);
fixed_size_cropper($uploaddir_original,$uploaddir_slideshow,$new_image,640,300);
fixed_size_cropper($uploaddir_original,$uploaddir_slideshowthumb,$new_image,80,53);

$wpdb->insert($table_prefix.'combo_image', array('gallery_id' => 0,'image_name' => $new_image,'original_name' => $original_image,'date' => current_time('mysql')));
?>