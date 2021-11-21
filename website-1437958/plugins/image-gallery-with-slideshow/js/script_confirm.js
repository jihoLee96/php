function confirmGalleryDelete(gallery_id,url)
{
	var yy = document.location.hostname;
	var ready = confirm('Are you sure you wish to delete this Gallery? All the images in this gallery will be deleted permanently.');
	if(ready)
	{
		window.location="http://"+yy + url+"/wp-admin/admin.php?page=gallery_with_slideshow&gval=delete&gid="+gallery_id;
	}
}

function confirmImageDelete(image_id,url)
{
	var aa = document.location.hostname;
	var ready = confirm('Are you sure you wish to delete this Image?');
	if(ready)
	{
		window.location="http://"+aa + url+"/wp-admin/admin.php?page=gallery_with_slideshow&val=view&ival=delete&gid="+image_id;
	}
}

var $j=jQuery.noConflict();
$j(function() {
	var $tabs = $j('#tabs').tabs();
});